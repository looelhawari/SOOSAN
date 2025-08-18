<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\PendingChange;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected $cloudinaryService;

    public function __construct(CloudinaryService $cloudinaryService)
    {
        $this->cloudinaryService = $cloudinaryService;
    }

    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('model_name', 'like', "%{$search}%")
                  ->orWhere('line', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('applicable_carrier', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = ProductCategory::all();

        // Calculate statistics
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $featuredProducts = Product::where('is_featured', true)->count();
        $totalCategories = ProductCategory::count();

        return view('admin.products.index', compact(
            'products',
            'categories',
            'totalProducts',
            'activeProducts',
            'featuredProducts',
            'totalCategories'
        ));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'model_name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'line' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',

            // Specifications
            'body_weight' => 'nullable|string|max:255',
            'operating_weight' => 'nullable|string|max:255',
            'overall_length' => 'nullable|string|max:255',
            'overall_width' => 'nullable|string|max:255',
            'overall_height' => 'nullable|string|max:255',
            'required_oil_flow' => 'nullable|string|max:255',
            'operating_pressure' => 'nullable|string|max:255',
            'impact_rate' => 'nullable|string|max:255',
            'impact_rate_soft_rock' => 'nullable|string|max:255',
            'hose_diameter' => 'nullable|string|max:255',
            'rod_diameter' => 'nullable|string|max:255',
            'applicable_carrier' => 'nullable|string|max:255',

            // Media
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',

            // Options
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $productData = [
            'model_name' => $request->model_name,
            'line' => $request->line,
            'type' => $request->type,
            'category_id' => $request->category_id,

            // Specifications
            'body_weight' => $request->body_weight,
            'operating_weight' => $request->operating_weight,
            'overall_length' => $request->overall_length,
            'overall_width' => $request->overall_width,
            'overall_height' => $request->overall_height,
            'required_oil_flow' => $request->required_oil_flow,
            'operating_pressure' => $request->operating_pressure,
            'impact_rate' => $request->impact_rate,
            'impact_rate_soft_rock' => $request->impact_rate_soft_rock,
            'hose_diameter' => $request->hose_diameter,
            'rod_diameter' => $request->rod_diameter,
            'applicable_carrier' => $request->applicable_carrier,

            // Options
            'is_active' => $request->boolean('is_active'),
            'is_featured' => $request->boolean('is_featured'),
        ];

        // Handle image upload
        if ($request->hasFile('product_image')) {
            $uploadResult = $this->cloudinaryService->uploadImage(
                $request->file('product_image'),
                'products'
            );

            if ($uploadResult) {
                $productData['image_url'] = $uploadResult['url'];
                $productData['cloudinary_public_id'] = $uploadResult['public_id'];
            } else {
                return redirect()->back()
                    ->withErrors(['product_image' => 'Failed to upload image. Please try again.'])
                    ->withInput();
            }
        }

        Product::create($productData);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'model_name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'line' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',

            // Specifications
            'body_weight' => 'nullable|string|max:255',
            'operating_weight' => 'nullable|string|max:255',
            'overall_length' => 'nullable|string|max:255',
            'overall_width' => 'nullable|string|max:255',
            'overall_height' => 'nullable|string|max:255',
            'required_oil_flow' => 'nullable|string|max:255',
            'operating_pressure' => 'nullable|string|max:255',
            'impact_rate' => 'nullable|string|max:255',
            'impact_rate_soft_rock' => 'nullable|string|max:255',
            'hose_diameter' => 'nullable|string|max:255',
            'rod_diameter' => 'nullable|string|max:255',
            'applicable_carrier' => 'nullable|string|max:255',

            // Media
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',

            // Options
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $updateData = [
            'model_name' => $request->model_name,
            'category_id' => $request->category_id,
            'line' => $request->line,
            'type' => $request->type,

            // Specifications
            'body_weight' => $request->body_weight,
            'operating_weight' => $request->operating_weight,
            'overall_length' => $request->overall_length,
            'overall_width' => $request->overall_width,
            'overall_height' => $request->overall_height,
            'required_oil_flow' => $request->required_oil_flow,
            'operating_pressure' => $request->operating_pressure,
            'impact_rate' => $request->impact_rate,
            'impact_rate_soft_rock' => $request->impact_rate_soft_rock,
            'hose_diameter' => $request->hose_diameter,
            'rod_diameter' => $request->rod_diameter,
            'applicable_carrier' => $request->applicable_carrier,

            // Options
            'is_active' => $request->boolean('is_active'),
            'is_featured' => $request->boolean('is_featured'),
        ];

        // Handle image upload
        if ($request->hasFile('product_image')) {
            $uploadResult = $this->cloudinaryService->uploadImage(
                $request->file('product_image'),
                'products'
            );

            if ($uploadResult) {
                $updateData['image_url'] = $uploadResult['url'];
                $updateData['cloudinary_public_id'] = $uploadResult['public_id'];

                // Store old image info for potential deletion later
                $oldImageUrl = $product->image_url;
                $oldPublicId = $product->cloudinary_public_id;
            } else {
                return redirect()->back()
                    ->withErrors(['product_image' => 'Failed to upload image. Please try again.'])
                    ->withInput();
            }
        }

        // If user is an employee, create a pending change instead of directly updating
        if (auth()->user()->isEmployee()) {
            PendingChange::create([
                'model_type' => Product::class,
                'model_id' => $product->id,
                'action' => 'update',
                'original_data' => $product->toArray(),
                'new_data' => $updateData,
                'requested_by' => auth()->id(),
            ]);

            return redirect()->route('admin.products.index')
                ->with('info', __('admin.changes_submitted_for_approval'));
        }

        // If user is admin, apply changes directly
        // Handle old image deletion for admin updates
        if ($request->hasFile('product_image')) {
            // Delete old image from Cloudinary if it exists
            if ($product->cloudinary_public_id) {
                $this->cloudinaryService->deleteImage($product->cloudinary_public_id);
            } elseif ($product->image_url && $this->cloudinaryService->isCloudinaryUrl($product->image_url)) {
                // Fallback: extract public_id from URL if not stored in database
                $publicId = $this->cloudinaryService->extractPublicId($product->image_url);
                if ($publicId) {
                    $this->cloudinaryService->deleteImage($publicId);
                }
            } elseif ($product->image_url && file_exists(public_path($product->image_url))) {
                // Handle legacy local files
                unlink(public_path($product->image_url));
            }
        }

        $product->update($updateData);

        return redirect()->route('admin.products.show', $product)
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // If user is an employee, create a pending change instead of directly deleting
        if (auth()->user()->isEmployee()) {
            PendingChange::create([
                'model_type' => Product::class,
                'model_id' => $product->id,
                'action' => 'delete',
                'original_data' => $product->toArray(),
                'new_data' => [], // No new data for deletion
                'requested_by' => auth()->id(),
            ]);

            return redirect()->route('admin.products.index')
                ->with('info', __('admin.deletion_submitted_for_approval'));
        }

        // If user is admin, delete directly
        // Delete associated image from Cloudinary before deleting product
        if ($product->cloudinary_public_id) {
            $this->cloudinaryService->deleteImage($product->cloudinary_public_id);
        } elseif ($product->image_url && $this->cloudinaryService->isCloudinaryUrl($product->image_url)) {
            $publicId = $this->cloudinaryService->extractPublicId($product->image_url);
            if ($publicId) {
                $this->cloudinaryService->deleteImage($publicId);
            }
        } elseif ($product->image_url && file_exists(public_path($product->image_url))) {
            // Handle legacy local files
            unlink(public_path($product->image_url));
        }

        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function toggleStatus(Product $product)
    {
        // If user is an employee, create a pending change for status toggle
        if (auth()->user()->isEmployee()) {
            $newData = $product->toArray();
            $newData['is_active'] = !$product->is_active;

            PendingChange::create([
                'model_type' => Product::class,
                'model_id' => $product->id,
                'action' => 'update',
                'original_data' => $product->toArray(),
                'new_data' => $newData,
                'requested_by' => auth()->id(),
            ]);

            return redirect()->back()
                ->with('info', 'Your status change request has been submitted for admin approval.');
        }

        // If user is admin, toggle status directly
        $product->update([
            'is_active' => !$product->is_active,
        ]);

        return redirect()->back()
            ->with('success', 'Product status updated successfully.');
    }
}
