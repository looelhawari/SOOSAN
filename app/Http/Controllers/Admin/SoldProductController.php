<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SoldProduct;
use App\Models\Product;
use App\Models\Owner;
use App\Models\PendingChange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoldProductController extends Controller
{
    public function index(Request $request)
    {
        $query = SoldProduct::with(['product', 'owner', 'employee'])
            ->whereHas('product'); // Only include sold products that have valid product relationships

        // Apply filters
        if ($request->filled('owner_name')) {
            $query->whereHas('owner', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->owner_name . '%');
            });
        }

        if ($request->filled('serial_number')) {
            $query->where('serial_number', 'like', '%' . $request->serial_number . '%');
        }

        if ($request->filled('warranty_status')) {
            $today = now()->toDateString();
            switch ($request->warranty_status) {
                case 'active':
                    $query->whereDate('warranty_end_date', '>=', $today);
                    break;
                case 'expired':
                    $query->whereDate('warranty_end_date', '<', $today);
                    break;
                case 'expiring_soon':
                    $query->whereDate('warranty_end_date', '>=', $today)
                          ->whereDate('warranty_end_date', '<=', now()->addDays(30)->toDateString());
                    break;
            }
        }

        if ($request->filled('date_from')) {
            $query->whereDate('sale_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('sale_date', '<=', $request->date_to);
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'sale_date');
        $sortOrder = $request->get('sort_order', 'desc');

        $allowedSorts = ['sale_date', 'warranty_end_date', 'serial_number', 'purchase_price'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest();
        }

        $soldProducts = $query->paginate(15)->withQueryString();

        // Get data for filter dropdowns
        $products = Product::where('is_active', true)->orderBy('model_name')->get();
        $owners = Owner::orderBy('name')->get();

        // Calculate statistics
        $stats = [
            'total' => SoldProduct::count(),
            'this_month' => SoldProduct::whereMonth('sale_date', now()->month)
                                    ->whereYear('sale_date', now()->year)
                                    ->count(),
            'warranty_active' => SoldProduct::whereDate('warranty_end_date', '>=', now()->toDateString())->count(),
            'warranty_expired' => SoldProduct::whereDate('warranty_end_date', '<', now()->toDateString())->count(),
            'expiring_soon' => SoldProduct::whereDate('warranty_end_date', '>=', now()->toDateString())
                                        ->whereDate('warranty_end_date', '<=', now()->addDays(30)->toDateString())
                                        ->count(),
            'voided' => SoldProduct::where('warranty_voided', true)->count(),
        ];

        return view('admin.sold-products.index', compact('soldProducts', 'products', 'owners', 'stats'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->orderBy('model_name')->get();
        $owners = Owner::orderBy('name')->get();
        return view('admin.sold-products.create', compact('products', 'owners'));
    }

    // ✅ Keep only this store method
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'owner_id' => 'required|exists:owners,id',
            'serial_number' => 'required|string|unique:sold_products,serial_number',
            'quantity' => 'required|integer|min:1',
            'sale_date' => 'required|date',
            'warranty_start_date' => 'required|date',
            'warranty_end_date' => 'required|date|after_or_equal:warranty_start_date',
            'purchase_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        $validated['user_id'] = Auth::id();

        SoldProduct::create($validated);

        return redirect()->route('admin.sold-products.index')
            ->with('success', 'Sale recorded successfully.');
    }

    public function show(SoldProduct $soldProduct)
    {
        $soldProduct->load('product', 'owner', 'employee');
        return view('admin.sold-products.show', compact('soldProduct'));
    }

    public function edit(SoldProduct $soldProduct)
    {
        $products = Product::where('is_active', true)->orderBy('model_name')->get();
        $owners = Owner::orderBy('name')->get();

        // Only include employees field for admins
        $employees = Auth::user()->isAdmin()
            ? \App\Models\User::whereIn('role', ['admin', 'employee'])->orderBy('name')->get()
            : collect();

        return view('admin.sold-products.edit', compact('soldProduct', 'products', 'owners', 'employees'));
    }

    public function update(Request $request, SoldProduct $soldProduct)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'owner_id' => 'required|exists:owners,id',
            'serial_number' => 'required|string|unique:sold_products,serial_number,' . $soldProduct->id,
            'quantity' => 'required|integer|min:1',
            'sale_date' => 'required|date',
            'warranty_start_date' => 'required|date',
            'warranty_end_date' => 'required|date|after_or_equal:warranty_start_date',
            'purchase_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'user_id' => 'nullable|exists:users,id',
        ]);

        // If user is an employee, create a pending change instead of directly updating
        if (Auth::user()->isEmployee()) {
            // Always set user_id to the currently logged-in user
            $validated['user_id'] = Auth::id();
            PendingChange::create([
                'model_type' => SoldProduct::class,
                'model_id' => $soldProduct->id,
                'action' => 'update',
                'original_data' => $soldProduct->toArray(),
                'new_data' => $validated,
                'requested_by' => Auth::id(),
            ]);

            return redirect()->route('admin.sold-products.index')
                ->with('info', __('admin.changes_submitted_for_approval'));
        }

        // If user is admin, apply changes directly
        $soldProduct->update($validated);

        return redirect()->route('admin.sold-products.index')
            ->with('success', 'Sold product updated successfully.');
    }

    public function destroy(SoldProduct $soldProduct)
    {
        // If user is an employee, create a pending change instead of directly deleting
        if (Auth::user()->isEmployee()) {
            PendingChange::create([
                'model_type' => SoldProduct::class,
                'model_id' => $soldProduct->id,
                'action' => 'delete',
                'original_data' => $soldProduct->toArray(),
                'new_data' => [], // No new data for deletion
                'requested_by' => Auth::id(),
            ]);

            return redirect()->route('admin.sold-products.index')
                ->with('info', __('admin.deletion_submitted_for_approval'));
        }

        // If user is admin, delete directly
        $soldProduct->delete();
        return redirect()->route('admin.sold-products.index')
            ->with('success', 'Sale record deleted successfully.');
    }

    public function voidWarranty(Request $request, SoldProduct $soldProduct)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'warranty_void_reason' => 'required|string|max:1000',
        ]);

        // Admins can void the warranty directly.
        if ($user->isAdmin()) {
            $soldProduct->voidWarranty($validated['warranty_void_reason'], $user);
            return back()->with('success', 'Warranty has been voided successfully.');
        }

        // Employees must submit a request for approval.
        if ($user->isEmployee() && $user->is_verified) {
            // Check if a pending request already exists to avoid duplicates
            $existingRequest = PendingChange::where('model_type', SoldProduct::class)
                ->where('model_id', $soldProduct->id)
                ->where('action', 'void_warranty')
                ->where('status', 'pending')
                ->first();

            if ($existingRequest) {
                return back()->with('info', 'A request to void this warranty is already pending approval.');
            }

            PendingChange::create([
                'model_type' => SoldProduct::class,
                'model_id' => $soldProduct->id,
                'action' => 'void_warranty',
                'requested_by' => $user->id,
                'new_data' => ['warranty_void_reason' => $validated['warranty_void_reason']],
                'status' => 'pending',
            ]);

            return back()->with('success', 'Request to void warranty has been submitted for admin approval.');
        }

        // If the user is not an admin or a verified employee, deny access.
        return back()->with('error', 'Access denied. You do not have permission to perform this action.');
    }
}
