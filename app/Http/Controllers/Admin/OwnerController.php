<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\PendingChange;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OwnerController extends Controller
{
    protected $cloudinaryService;

    public function __construct(CloudinaryService $cloudinaryService)
    {
        $this->cloudinaryService = $cloudinaryService;
    }
    public function productDetails(Request $request)
    {
        $ownerId = $request->query('owner_id');
        $product = $request->query('product');
        $owner = Owner::with(['soldProducts.product'])
            ->where('id', $ownerId)
            ->firstOrFail();

        $soldProducts = $owner->soldProducts->filter(function($sp) use ($product) {
            return $sp->product && $sp->product->model_name === $product;
        });

        $totalSpent = $owner->soldProducts->sum('purchase_price');

        return view('admin.owners.product-details', [
            'owner' => $owner,
            'product' => $product,
            'soldProducts' => $soldProducts,
            'totalSpent' => $totalSpent,
        ]);
    }

    public function index(Request $request)
    {
        // For clickable pie chart: map of owner_id, model_name, owner_name, total_spent, and product purchase info
        $ownerProductMap = \App\Models\SoldProduct::with(['owner', 'product'])
            ->get()
            ->map(function($sp) {
                return [
                    'owner_id' => $sp->owner_id,
                    'owner_name' => $sp->owner ? $sp->owner->name : 'Unknown',
                    'model_name' => $sp->product ? $sp->product->model_name : 'Unknown',
                    'purchase_price' => $sp->purchase_price,
                    'sale_date' => $sp->sale_date ? $sp->sale_date->toDateString() : null,
                ];
            });
        // Chart data for analytics (devices bought, total spent per owner)
        $ownerChartData = Owner::with('soldProducts')->get()->map(function($owner) {
            return [
                'name' => $owner->name,
                'devicesBought' => $owner->soldProducts->count(),
                'totalSpent' => $owner->soldProducts->sum('purchase_price'),
            ];
        });

        // Chart data for products per owner (for horizontal bar and pie chart)
        $ownerProductsChartData = Owner::with(['soldProducts.product'])->get()->map(function($owner) {
            return [
                'owner' => $owner->name,
                'products' => $owner->soldProducts->map(function($sp) {
                    return [
                        'productName' => $sp->product ? $sp->product->model_name : 'Unknown',
                        'price' => $sp->purchase_price,
                    ];
                })->toArray(),
            ];
        });
        $query = Owner::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%");
            });
        }

        // Filter by country
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        // Filter by city
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'name');
        $sortDirection = $request->get('sort_direction', 'asc');

        if (in_array($sortBy, ['name', 'email', 'company', 'city', 'country', 'created_at'])) {
            $query->orderBy($sortBy, $sortDirection);
        } else {
            $query->orderBy('name', 'asc');
        }

        $owners = $query->paginate(15)->withQueryString();

        // Statistics
        $totalOwners = Owner::count();
        $ownersWithEmail = Owner::whereNotNull('email')->count();
        $ownersWithCompany = Owner::whereNotNull('company')->count();
        $totalCountries = Owner::whereNotNull('country')->distinct('country')->count();

        // Get filter options
        $countries = Owner::whereNotNull('country')->distinct()->pluck('country')->sort();
        $cities = Owner::whereNotNull('city')->distinct()->pluck('city')->sort();

        // Top Owners by Spending (limit 10)
        $topOwners = Owner::withCount('soldProducts')
            ->with(['soldProducts' => function($q) { $q->select('owner_id', 'purchase_price'); }])
            ->get()
            ->map(function($owner) {
                return [
                    'name' => $owner->name,
                    'total_spent' => $owner->soldProducts->sum('purchase_price'),
                    'total_devices' => $owner->sold_products_count,
                ];
            })
            ->sortByDesc('total_spent')
            ->take(10)
            ->values();

        // Owner Product Performance (doughnut): product model_name and count of owners who bought it
        $ownerProductPerformance = \App\Models\SoldProduct::with('product')
            ->get()
            ->groupBy(function($sp) { return $sp->product ? $sp->product->model_name : 'Unknown'; })
            ->map(function($group, $model_name) {
                return [
                    'model_name' => $model_name,
                    'owners_count' => $group->unique('owner_id')->count(),
                ];
            })->values();

        return view('admin.owners.index', compact(
            'owners',
            'totalOwners',
            'ownersWithEmail',
            'ownersWithCompany',
            'totalCountries',
            'countries',
            'cities',
            'topOwners',
            'ownerProductPerformance',
            'ownerProductMap',
            'ownerChartData',
            'ownerProductsChartData'
        ));
    }

    public function create()
    {
        return view('admin.owners.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:owners,email',
            'phone_number' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:1000',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'preferred_language' => 'nullable|string|max:10',
            'company_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // 2MB Max
        ]);

        try {
            $ownerData = $request->except(['company_image', '_token']);

            // Create the owner first to get an ID
            $owner = Owner::create($ownerData);

            // Handle image upload
            if ($request->hasFile('company_image')) {
                try {
                    $uploadResult = $this->cloudinaryService->uploadImage($request->file('company_image'), 'owners');
                    if ($uploadResult) {
                        $owner->company_image_url = $uploadResult['url'];
                        $owner->cloudinary_public_id = $uploadResult['public_id'];
                        $owner->save();
                    }
                } catch (\Exception $e) {
                    // If Cloudinary fails, fall back to local storage
                    $image = $request->file('company_image');
                    $imageName = 'company_' . $owner->id . '_' . time() . '.' . $image->getClientOriginalExtension();

                    // Ensure the directory exists
                    if (!file_exists(public_path('company_logos'))) {
                        mkdir(public_path('company_logos'), 0755, true);
                    }

                    $image->move(public_path('company_logos'), $imageName);
                    $owner->company_image_url = 'company_logos/' . $imageName;
                    $owner->cloudinary_public_id = null;
                    $owner->save();
                }
            }

            return redirect()->route('admin.owners.index')->with('success', __('owners.owner_created'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the owner: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Owner $owner)
    {
        $owner->load('soldProducts.product');
        return view('admin.owners.show', compact('owner'));
    }

    public function edit(Owner $owner)
    {
        return view('admin.owners.edit', compact('owner'));
    }

    public function update(Request $request, Owner $owner)
    {
        // Only admins can perform this action for now
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('admin.owners.index')->with('error', 'You do not have permission to perform this action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:owners,email,' . $owner->id,
            'phone_number' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:1000',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'preferred_language' => 'nullable|string|max:10',
            'company_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // 2MB Max
            'remove_company_image' => 'nullable|boolean',
        ]);

        try {
            $updateData = $request->except(['company_image', 'remove_company_image', '_token', '_method']);

            // 1. Handle Image Removal
            if ($request->boolean('remove_company_image')) {
                // Delete from Cloudinary if it exists
                if ($owner->cloudinary_public_id) {
                    $this->cloudinaryService->deleteImage($owner->cloudinary_public_id);
                } elseif ($owner->company_image_url && file_exists(public_path($owner->company_image_url))) {
                    @unlink(public_path($owner->company_image_url));
                }
                $updateData['company_image_url'] = null;
                $updateData['cloudinary_public_id'] = null;
            }
            // 2. Handle Image Upload
            elseif ($request->hasFile('company_image')) {
                // Delete old image first
                if ($owner->cloudinary_public_id) {
                    $this->cloudinaryService->deleteImage($owner->cloudinary_public_id);
                } elseif ($owner->company_image_url && file_exists(public_path($owner->company_image_url))) {
                    @unlink(public_path($owner->company_image_url));
                }

                try {
                    $uploadResult = $this->cloudinaryService->uploadImage($request->file('company_image'), 'owners');
                    if ($uploadResult) {
                        $updateData['company_image_url'] = $uploadResult['url'];
                        $updateData['cloudinary_public_id'] = $uploadResult['public_id'];
                    }
                } catch (\Exception $e) {
                    // If Cloudinary fails, fall back to local storage
                    $image = $request->file('company_image');
                    $imageName = 'company_' . $owner->id . '_' . time() . '.' . $image->getClientOriginalExtension();

                    // Ensure the directory exists
                    if (!file_exists(public_path('company_logos'))) {
                        mkdir(public_path('company_logos'), 0755, true);
                    }

                    $image->move(public_path('company_logos'), $imageName);
                    $updateData['company_image_url'] = 'company_logos/' . $imageName;
                    $updateData['cloudinary_public_id'] = null;
                }
            }

            $owner->update($updateData);

            return redirect()->route('admin.owners.show', $owner)->with('success', __('owners.owner_updated'));

        } catch (\Exception $e) {
            // Optional: Log the error
            // Log::error('Owner update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the owner: ' . $e->getMessage());
        }
    }

    public function destroy(Owner $owner)
    {
        // If user is an employee, create a pending change instead of directly deleting
        if (auth()->user()->isEmployee()) {
            PendingChange::create([
                'model_type' => Owner::class,
                'model_id' => $owner->id,
                'action' => 'delete',
                'original_data' => $owner->toArray(),
                'new_data' => [], // No new data for deletion
                'requested_by' => auth()->id(),
            ]);

            return redirect()->route('admin.owners.index')
                ->with('info', __('admin.deletion_submitted_for_approval'));
        }

        // If user is admin, delete directly
        // Delete company image from Cloudinary if it exists
        if ($owner->cloudinary_public_id) {
            $this->cloudinaryService->deleteImage($owner->cloudinary_public_id);
        } elseif ($owner->company_image_url && file_exists(public_path($owner->company_image_url))) {
            @unlink(public_path($owner->company_image_url));
        }

        $owner->delete();

        return redirect()->route('admin.owners.index')
            ->with('success', __('owners.owner_deleted'));
    }
}
