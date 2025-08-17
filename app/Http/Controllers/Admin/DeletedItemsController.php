<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Owner;
use App\Models\SoldProduct;
use Illuminate\Http\Request;

class DeletedItemsController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category', 'all');
        
        $deletedData = [
            'users' => User::onlyTrashed()->with(['createdBy'])->get(),
            'products' => Product::onlyTrashed()->with(['category'])->get(),
            'product_categories' => ProductCategory::onlyTrashed()->get(),
            'owners' => Owner::onlyTrashed()->get(),
            'sold_products' => SoldProduct::onlyTrashed()->with(['product', 'owner', 'user'])->get(),
        ];

        $statistics = [
            'users' => $deletedData['users']->count(),
            'products' => $deletedData['products']->count(),
            'product_categories' => $deletedData['product_categories']->count(),
            'owners' => $deletedData['owners']->count(),
            'sold_products' => $deletedData['sold_products']->count(),
            'total' => array_sum([
                $deletedData['users']->count(),
                $deletedData['products']->count(),
                $deletedData['product_categories']->count(),
                $deletedData['owners']->count(),
                $deletedData['sold_products']->count(),
            ])
        ];

        return view('admin.deleted-items.index', compact('deletedData', 'statistics', 'category'));
    }

    public function restore(Request $request, $type, $id)
    {
        $model = $this->getModel($type);
        
        if (!$model) {
            return back()->with('error', 'Invalid item type.');
        }

        $item = $model::onlyTrashed()->find($id);
        
        if (!$item) {
            return back()->with('error', __('deleted_items.item_not_found'));
        }

        $item->restore();

        $itemName = $this->getItemDisplayName($item, $type);
        return back()->with('success', __('deleted_items.restored_successfully', ['item' => $itemName]));
    }

    public function forceDelete(Request $request, $type, $id)
    {
        $model = $this->getModel($type);
        
        if (!$model) {
            return back()->with('error', __('deleted_items.invalid_item_type'));
        }

        $item = $model::onlyTrashed()->find($id);
        
        if (!$item) {
            return back()->with('error', __('deleted_items.item_not_found'));
        }

        $itemName = $this->getItemDisplayName($item, $type);

        // Handle related records before force delete
        $this->handleRelatedRecords($type, $id);

        $item->forceDelete();

        return back()->with('success', __('deleted_items.deleted_permanently', ['item' => $itemName]));
    }

    public function bulkRestore(Request $request)
    {
        $request->validate([
            'items' => 'required|string',
        ]);

        $items = json_decode($request->items, true);
        $restoredCount = 0;

        foreach ($items as $item) {
            [$type, $id] = explode(':', $item);
            
            try {
                $model = $this->getModel($type);
                if ($model) {
                    $instance = $model::onlyTrashed()->find($id);
                    
                    if ($instance) {
                        $instance->restore();
                        $restoredCount++;
                    }
                }
            } catch (\Exception $e) {
                // Log error but continue with other items
                \Log::error("Failed to restore {$type} with ID {$id}: " . $e->getMessage());
            }
        }

        return redirect()->route('admin.deleted-items.index')
            ->with('success', __('deleted_items.bulk_restored', ['count' => $restoredCount]));
    }

    public function bulkForceDelete(Request $request)
    {
        $request->validate([
            'items' => 'required|string',
        ]);

        $items = json_decode($request->items, true);
        $deletedCount = 0;

        foreach ($items as $item) {
            [$type, $id] = explode(':', $item);
            
            try {
                $model = $this->getModel($type);
                if ($model) {
                    $instance = $model::onlyTrashed()->find($id);
                    
                    if ($instance) {
                        // Handle related records before force delete
                        $this->handleRelatedRecords($type, $id);
                        $instance->forceDelete();
                        $deletedCount++;
                    }
                }
            } catch (\Exception $e) {
                // Log error but continue with other items
                \Log::error("Failed to force delete {$type} with ID {$id}: " . $e->getMessage());
            }
        }

        return redirect()->route('admin.deleted-items.index')
            ->with('success', __('deleted_items.bulk_deleted', ['count' => $deletedCount]));
    }

    public function restoreAll(Request $request)
    {
        $request->validate([
            'category' => 'required|string|in:users,products,product_categories,owners,sold_products',
        ]);

        try {
            $model = $this->getModel($request->category);
            if ($model) {
                $count = $model::onlyTrashed()->count();
                $model::onlyTrashed()->get()->each->restore();

                return redirect()->route('admin.deleted-items.index')
                    ->with('success', __('deleted_items.bulk_restored', ['count' => $count]));
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.deleted-items.index')
                ->with('error', 'An error occurred while restoring items.');
        }
    }

    public function cleanOldItems()
    {
        $cutoffDate = now()->subDays(90);
        $deletedCount = 0;

        $models = [
            'users' => User::class,
            'products' => Product::class,
            'product_categories' => ProductCategory::class,
            'owners' => Owner::class,
            'sold_products' => SoldProduct::class,
        ];

        foreach ($models as $type => $model) {
            try {
                $items = $model::onlyTrashed()->where('deleted_at', '<', $cutoffDate)->get();
                foreach ($items as $item) {
                    $this->handleRelatedRecords($type, $item->id);
                    $item->forceDelete();
                    $deletedCount++;
                }
            } catch (\Exception $e) {
                \Log::error("Failed to clean old {$type}: " . $e->getMessage());
            }
        }

        return redirect()->route('admin.deleted-items.index')
            ->with('success', __('deleted_items.bulk_deleted', ['count' => $deletedCount]));
    }

    public function emptyTrash()
    {
        $deletedCount = 0;

        $models = [
            'users' => User::class,
            'products' => Product::class,
            'product_categories' => ProductCategory::class,
            'owners' => Owner::class,
            'sold_products' => SoldProduct::class,
        ];

        foreach ($models as $type => $model) {
            try {
                $items = $model::onlyTrashed()->get();
                foreach ($items as $item) {
                    $this->handleRelatedRecords($type, $item->id);
                    $item->forceDelete();
                    $deletedCount++;
                }
            } catch (\Exception $e) {
                \Log::error("Failed to empty trash for {$type}: " . $e->getMessage());
            }
        }

        return redirect()->route('admin.deleted-items.index')
            ->with('success', __('deleted_items.bulk_deleted', ['count' => $deletedCount]));
    }

    private function handleRelatedRecords($type, $id)
    {
        if ($type === 'users') {
            // Set related records to null before force delete
            SoldProduct::withTrashed()->where('user_id', $id)->update(['user_id' => null]);
            User::withTrashed()->where('created_by', $id)->update(['created_by' => null]);
        } elseif ($type === 'products') {
            // Handle sold products that reference this product
            SoldProduct::withTrashed()->where('product_id', $id)->update(['product_id' => null]);
        } elseif ($type === 'product_categories') {
            // Handle products that reference this category
            Product::withTrashed()->where('category_id', $id)->update(['category_id' => null]);
        } elseif ($type === 'owners') {
            // Handle sold products that reference this owner
            SoldProduct::withTrashed()->where('owner_id', $id)->update(['owner_id' => null]);
        }
    }

    private function getModel($type)
    {
        $models = [
            'users' => User::class,
            'products' => Product::class,
            'product_categories' => ProductCategory::class,
            'owners' => Owner::class,
            'sold_products' => SoldProduct::class,
        ];

        return $models[$type] ?? null;
    }

    private function getItemDisplayName($item, $type)
    {
        switch ($type) {
            case 'users':
                return $item->name ?? 'User';
            case 'products':
                return $item->model_name ?? 'Product';
            case 'product_categories':
                return $item->name ?? 'Category';
            case 'owners':
                return $item->name ?? 'Owner';
            case 'sold_products':
                return 'Sold Product #' . ($item->serial_number ?? $item->id);
            default:
                return 'Item';
        }
    }
}
