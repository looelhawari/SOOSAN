@extends('layouts.admin')

@section('title', __('deleted_items.page_title'))

@push('styles')
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --danger-gradient: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
            --warning-gradient: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            --success-gradient: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            --info-gradient: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
            --border-radius: 1rem;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .modern-page-header {
            background: var(--danger-gradient);
            color: #ffffff;
            padding: 2rem 1.5rem;
            margin: -1rem -1rem 2rem;
            border-radius: 0 0 24px 24px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(220, 53, 69, 0.3);
        }

        .modern-page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,133.3C672,139,768,181,864,197.3C960,213,1056,203,1152,170.7C1248,139,1344,85,1392,58.7L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
        }

        .search-filter-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .search-filter-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 1rem;
            align-items: center;
        }

        .search-input-group {
            position: relative;
        }

        .search-input-group .form-control {
            padding-left: 2.5rem;
            border-radius: 0.5rem;
            border: 2px solid #e9ecef;
            transition: var(--transition);
        }

        .search-input-group .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .search-input-group .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 10;
        }

        .filter-select {
            border-radius: 0.5rem;
            border: 2px solid #e9ecef;
            transition: var(--transition);
        }

        .filter-select:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .btn-clear-filters {
            background: var(--warning-gradient);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: var(--transition);
        }

        .btn-clear-filters:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3);
            color: white;
        }

        .modern-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 2rem;
            overflow: hidden;
            transition: var(--transition);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            text-align: center;
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .stat-card.danger {
            background: var(--danger-gradient);
            color: white;
        }

        .stat-card.warning {
            background: var(--warning-gradient);
            color: white;
        }

        .stat-card.success {
            background: var(--success-gradient);
            color: white;
        }

        .stat-card.info {
            background: var(--info-gradient);
            color: white;
        }

        .stat-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            opacity: 0.8;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .category-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 2rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.95);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
        }

        .category-tab {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: var(--transition);
            border: 2px solid transparent;
            font-weight: 500;
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
        }

        .category-tab:hover {
            background: rgba(108, 117, 125, 0.2);
            color: #495057;
            text-decoration: none;
        }

        .category-tab.active {
            background: var(--danger-gradient);
            color: white;
            border-color: #dc3545;
        }

        .deleted-item {
            background: #fff;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 4px solid #dc3545;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .deleted-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .item-header {
            display: flex;
            justify-content: between;
            align-items: start;
            margin-bottom: 0.75rem;
        }

        .item-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.25rem;
        }

        .item-meta {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .item-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn-restore {
            background: var(--success-gradient);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-restore:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
            color: white;
        }

        .btn-force-delete {
            background: var(--danger-gradient);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-force-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
            color: white;
        }

        .bulk-actions {
            background: rgba(255, 255, 255, 0.95);
            padding: 1rem;
            border-radius: var(--border-radius);
            margin-bottom: 1rem;
            box-shadow: var(--card-shadow);
            display: none;
        }

        .bulk-actions.show {
            display: block;
        }

        .bulk-action-row {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .bulk-select-all {
            margin-right: 1rem;
        }

        .bulk-btn {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .bulk-btn-restore {
            background: var(--success-gradient);
            color: white;
        }

        .bulk-btn-delete {
            background: var(--danger-gradient);
            color: white;
        }

        .bulk-btn:hover {
            transform: translateY(-2px);
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .item-checkbox {
            margin-right: 0.5rem;
        }

        .quick-actions-sidebar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .quick-action-btn {
            display: block;
            width: 100%;
            margin-bottom: 0.5rem;
            padding: 0.75rem;
            border-radius: 0.375rem;
            border: none;
            font-weight: 500;
            transition: var(--transition);
            text-align: left;
        }

        .quick-action-btn i {
            width: 1.25rem;
            text-align: center;
            margin-right: 0.5rem;
        }

        @media (max-width: 992px) {
            .search-filter-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }

        @media (max-width: 768px) {
            .category-tabs {
                flex-direction: column;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* RTL Support for Arabic */
        [dir="rtl"] .deleted-item {
            border-left: none;
            border-right: 4px solid #dc3545;
        }

        [dir="rtl"] .deleted-item:hover {
            transform: translateX(-5px);
        }

        [dir="rtl"] .search-input-group .search-icon {
            left: auto;
            right: 0.75rem;
        }

        [dir="rtl"] .search-input-group .form-control {
            padding-left: 0.75rem;
            padding-right: 2.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="modern-page-header">
        <div class="container-fluid">
            <h1>
                <i class="fas fa-trash-restore"></i>
                {{ __('deleted_items.management') }}
            </h1>
            <p>{{ __('deleted_items.page_description') }}</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search and Filters -->
    <div class="search-filter-section">
        <div class="search-filter-row">
            <div class="search-input-group">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="form-control" id="searchInput"
                    placeholder="{{ __('deleted_items.search_deleted_items') }}">
            </div>
            <select class="form-select filter-select" id="dateFilter">
                <option value="">{{ __('deleted_items.filter_by_date') }}</option>
                <option value="7">{{ __('deleted_items.last_7_days') }}</option>
                <option value="30">{{ __('deleted_items.last_30_days') }}</option>
                <option value="90">{{ __('deleted_items.last_90_days') }}</option>
            </select>
            <select class="form-select filter-select" id="typeFilter">
                <option value="">{{ __('deleted_items.all_items') }}</option>
                <option value="users">{{ __('deleted_items.users') }}</option>
                <option value="products">{{ __('deleted_items.products') }}</option>
                <option value="categories">{{ __('deleted_items.categories') }}</option>
                <option value="owners">{{ __('deleted_items.owners') }}</option>
                <option value="sold_products">{{ __('deleted_items.sold_products') }}</option>
            </select>
            <button class="btn btn-clear-filters" id="clearFilters">
                <i class="fas fa-times me-1"></i>{{ __('deleted_items.clear_filter') }}
            </button>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card danger">
                    <i class="fas fa-trash stat-icon"></i>
                    <div class="stat-value">{{ $statistics['total'] }}</div>
                    <div class="stat-label">{{ __('deleted_items.total_deleted_items') }}</div>
                </div>
                <div class="stat-card warning">
                    <i class="fas fa-users stat-icon"></i>
                    <div class="stat-value">{{ $statistics['users'] }}</div>
                    <div class="stat-label">{{ __('deleted_items.deleted_users') }}</div>
                </div>
                <div class="stat-card info">
                    <i class="fas fa-box stat-icon"></i>
                    <div class="stat-value">{{ $statistics['products'] }}</div>
                    <div class="stat-label">{{ __('deleted_items.deleted_products') }}</div>
                </div>
                <div class="stat-card success">
                    <i class="fas fa-user-friends stat-icon"></i>
                    <div class="stat-value">{{ $statistics['owners'] }}</div>
                    <div class="stat-label">{{ __('deleted_items.deleted_owners') }}</div>
                </div>
            </div>

            <!-- Category Tabs -->
            <div class="category-tabs">
                <a href="{{ route('admin.deleted-items.index', ['category' => 'all']) }}"
                    class="category-tab {{ $category === 'all' ? 'active' : '' }}">
                    <i class="fas fa-list me-2"></i>{{ __('deleted_items.all_items') }} ({{ $statistics['total'] }})
                </a>
                <a href="{{ route('admin.deleted-items.index', ['category' => 'users']) }}"
                    class="category-tab {{ $category === 'users' ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i>{{ __('deleted_items.users') }} ({{ $statistics['users'] }})
                </a>
                <a href="{{ route('admin.deleted-items.index', ['category' => 'products']) }}"
                    class="category-tab {{ $category === 'products' ? 'active' : '' }}">
                    <i class="fas fa-box me-2"></i>{{ __('deleted_items.products') }} ({{ $statistics['products'] }})
                </a>
                <a href="{{ route('admin.deleted-items.index', ['category' => 'product_categories']) }}"
                    class="category-tab {{ $category === 'product_categories' ? 'active' : '' }}">
                    <i class="fas fa-tags me-2"></i>{{ __('deleted_items.categories') }}
                    ({{ $statistics['product_categories'] }})
                </a>
                <a href="{{ route('admin.deleted-items.index', ['category' => 'owners']) }}"
                    class="category-tab {{ $category === 'owners' ? 'active' : '' }}">
                    <i class="fas fa-user-friends me-2"></i>{{ __('deleted_items.owners') }} ({{ $statistics['owners'] }})
                </a>
                <a href="{{ route('admin.deleted-items.index', ['category' => 'sold_products']) }}"
                    class="category-tab {{ $category === 'sold_products' ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart me-2"></i>{{ __('deleted_items.sold_products') }}
                    ({{ $statistics['sold_products'] }})
                </a>
            </div>

            <!-- Bulk Actions -->
            <div class="bulk-actions" id="bulkActions">
                <div class="bulk-action-row">
                    <div class="bulk-select-all">
                        <input type="checkbox" id="selectAll" class="form-check-input">
                        <label for="selectAll" class="form-check-label ms-1">{{ __('deleted_items.select_all') }}</label>
                    </div>
                    <button type="button" class="bulk-btn bulk-btn-restore" id="bulkRestore">
                        <i class="fas fa-undo me-1"></i>{{ __('deleted_items.restore_selected') }}
                    </button>
                    <button type="button" class="bulk-btn bulk-btn-delete" id="bulkDelete">
                        <i class="fas fa-trash me-1"></i>{{ __('deleted_items.delete_selected') }}
                    </button>
                    <span id="selectedCount" class="text-muted ms-2"></span>
                </div>
            </div>

            <!-- Deleted Items Display -->
            @if ($category === 'all' || $category === 'users')
                @if ($deletedData['users']->count() > 0)
                    <div class="modern-card">
                        <div class="card-header bg-warning text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-users me-2"></i>
                                {{ __('deleted_items.category_users') }} ({{ $deletedData['users']->count() }})
                            </h5>
                        </div>
                        <div class="card-body">
                            @foreach ($deletedData['users'] as $user)
                                <div class="deleted-item" data-type="users" data-id="{{ $user->id }}">
                                    <div class="item-header">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="item-checkbox form-check-input"
                                                value="users:{{ $user->id }}">
                                            <div class="flex-grow-1">
                                                <div class="item-title">{{ $user->name }}</div>
                                                <div class="item-meta">
                                                    <strong>{{ __('deleted_items.email') }}:</strong> {{ $user->email }}
                                                    |
                                                    <strong>{{ __('deleted_items.role') }}:</strong>
                                                    {{ ucfirst($user->role) }} |
                                                    <strong>{{ __('deleted_items.deleted_at') }}:</strong>
                                                    {{ $user->deleted_at->diffForHumans() }}
                                                    @if ($user->createdBy)
                                                        | <strong>{{ __('deleted_items.created_by') }}:</strong>
                                                        {{ $user->createdBy->name }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-actions">
                                        <form method="POST"
                                            action="{{ route('admin.deleted-items.restore', ['type' => 'users', 'id' => $user->id]) }}"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-restore">
                                                <i class="fas fa-undo me-1"></i>{{ __('deleted_items.restore') }}
                                            </button>
                                        </form>
                                        <form method="POST"
                                            action="{{ route('admin.deleted-items.force-delete', ['type' => 'users', 'id' => $user->id]) }}"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-force-delete"
                                                onclick="return confirm('{{ __('deleted_items.confirm_delete_forever') }}')">
                                                <i class="fas fa-trash me-1"></i>{{ __('deleted_items.delete_forever') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            @if ($category === 'all' || $category === 'products')
                @if ($deletedData['products']->count() > 0)
                    <div class="modern-card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-box me-2"></i>
                                {{ __('deleted_items.category_products') }} ({{ $deletedData['products']->count() }})
                            </h5>
                        </div>
                        <div class="card-body">
                            @foreach ($deletedData['products'] as $product)
                                <div class="deleted-item" data-type="products" data-id="{{ $product->id }}">
                                    <div class="item-header">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="item-checkbox form-check-input"
                                                value="products:{{ $product->id }}">
                                            <div class="flex-grow-1">
                                                <div class="item-title">{{ $product->model_name }}</div>
                                                <div class="item-meta">
                                                    <strong>{{ __('deleted_items.line') }}:</strong> {{ $product->line }}
                                                    |
                                                    <strong>{{ __('deleted_items.type') }}:</strong> {{ $product->type }}
                                                    |
                                                    @if ($product->category)
                                                        <strong>{{ __('deleted_items.category') }}:</strong>
                                                        {{ $product->category->name }} |
                                                    @endif
                                                    <strong>{{ __('deleted_items.deleted_at') }}:</strong>
                                                    {{ $product->deleted_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-actions">
                                        <form method="POST"
                                            action="{{ route('admin.deleted-items.restore', ['type' => 'products', 'id' => $product->id]) }}"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-restore">
                                                <i class="fas fa-undo me-1"></i>{{ __('deleted_items.restore') }}
                                            </button>
                                        </form>
                                        <form method="POST"
                                            action="{{ route('admin.deleted-items.force-delete', ['type' => 'products', 'id' => $product->id]) }}"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-force-delete"
                                                onclick="return confirm('{{ __('deleted_items.confirm_delete_forever') }}')">
                                                <i class="fas fa-trash me-1"></i>{{ __('deleted_items.delete_forever') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            @if ($category === 'all' || $category === 'product_categories')
                @if ($deletedData['product_categories']->count() > 0)
                    <div class="modern-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-tags me-2"></i>
                                {{ __('deleted_items.category_product_categories') }}
                                ({{ $deletedData['product_categories']->count() }})
                            </h5>
                        </div>
                        <div class="card-body">
                            @foreach ($deletedData['product_categories'] as $category_item)
                                <div class="deleted-item" data-type="product_categories"
                                    data-id="{{ $category_item->id }}">
                                    <div class="item-header">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="item-checkbox form-check-input"
                                                value="product_categories:{{ $category_item->id }}">
                                            <div class="flex-grow-1">
                                                <div class="item-title">{{ $category_item->name }}</div>
                                                <div class="item-meta">
                                                    @if ($category_item->description)
                                                        <strong>{{ __('deleted_items.description') }}:</strong>
                                                        {{ Str::limit($category_item->description, 100) }} |
                                                    @endif
                                                    <strong>{{ __('deleted_items.deleted_at') }}:</strong>
                                                    {{ $category_item->deleted_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-actions">
                                        <form method="POST"
                                            action="{{ route('admin.deleted-items.restore', ['type' => 'product_categories', 'id' => $category_item->id]) }}"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-restore">
                                                <i class="fas fa-undo me-1"></i>{{ __('deleted_items.restore') }}
                                            </button>
                                        </form>
                                        <form method="POST"
                                            action="{{ route('admin.deleted-items.force-delete', ['type' => 'product_categories', 'id' => $category_item->id]) }}"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-force-delete"
                                                onclick="return confirm('{{ __('deleted_items.confirm_delete_forever') }}')">
                                                <i class="fas fa-trash me-1"></i>{{ __('deleted_items.delete_forever') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            @if ($category === 'all' || $category === 'owners')
                @if ($deletedData['owners']->count() > 0)
                    <div class="modern-card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-user-friends me-2"></i>
                                {{ __('deleted_items.category_owners') }} ({{ $deletedData['owners']->count() }})
                            </h5>
                        </div>
                        <div class="card-body">
                            @foreach ($deletedData['owners'] as $owner)
                                <div class="deleted-item" data-type="owners" data-id="{{ $owner->id }}">
                                    <div class="item-header">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="item-checkbox form-check-input"
                                                value="owners:{{ $owner->id }}">
                                            <div class="flex-grow-1">
                                                <div class="item-title">{{ $owner->name }}</div>
                                                <div class="item-meta">
                                                    @if ($owner->email)
                                                        <strong>{{ __('deleted_items.email') }}:</strong>
                                                        {{ $owner->email }} |
                                                    @endif
                                                    @if ($owner->phone_number)
                                                        <strong>{{ __('deleted_items.phone') }}:</strong>
                                                        {{ $owner->phone_number }} |
                                                    @endif
                                                    <strong>{{ __('deleted_items.deleted_at') }}:</strong>
                                                    {{ $owner->deleted_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-actions">
                                        <form method="POST"
                                            action="{{ route('admin.deleted-items.restore', ['type' => 'owners', 'id' => $owner->id]) }}"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-restore">
                                                <i class="fas fa-undo me-1"></i>{{ __('deleted_items.restore') }}
                                            </button>
                                        </form>
                                        <form method="POST"
                                            action="{{ route('admin.deleted-items.force-delete', ['type' => 'owners', 'id' => $owner->id]) }}"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-force-delete"
                                                onclick="return confirm('{{ __('deleted_items.confirm_delete_forever') }}')">
                                                <i class="fas fa-trash me-1"></i>{{ __('deleted_items.delete_forever') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            @if ($category === 'all' || $category === 'sold_products')
                @if ($deletedData['sold_products']->count() > 0)
                    <div class="modern-card">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-shopping-cart me-2"></i>
                                {{ __('deleted_items.category_sold_products') }}
                                ({{ $deletedData['sold_products']->count() }})
                            </h5>
                        </div>
                        <div class="card-body">
                            @foreach ($deletedData['sold_products'] as $soldProduct)
                                <div class="deleted-item" data-type="sold_products" data-id="{{ $soldProduct->id }}">
                                    <div class="item-header">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="item-checkbox form-check-input"
                                                value="sold_products:{{ $soldProduct->id }}">
                                            <div class="flex-grow-1">
                                                <div class="item-title">{{ __('deleted_items.serial') }}:
                                                    {{ $soldProduct->serial_number }}</div>
                                                <div class="item-meta">
                                                    @if ($soldProduct->product)
                                                        <strong>{{ __('deleted_items.product') }}:</strong>
                                                        {{ $soldProduct->product->model_name }} |
                                                    @endif
                                                    @if ($soldProduct->owner)
                                                        <strong>{{ __('deleted_items.owner') }}:</strong>
                                                        {{ $soldProduct->owner->name }} |
                                                    @endif
                                                    @if ($soldProduct->user)
                                                        <strong>{{ __('deleted_items.sold_by') }}:</strong>
                                                        {{ $soldProduct->user->name }} |
                                                    @endif
                                                    <strong>{{ __('deleted_items.sale_date') }}:</strong>
                                                    {{ $soldProduct->sale_date->format('Y-m-d') }} |
                                                    <strong>{{ __('deleted_items.deleted_at') }}:</strong>
                                                    {{ $soldProduct->deleted_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-actions">
                                        <form method="POST"
                                            action="{{ route('admin.deleted-items.restore', ['type' => 'sold_products', 'id' => $soldProduct->id]) }}"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-restore">
                                                <i class="fas fa-undo me-1"></i>{{ __('deleted_items.restore') }}
                                            </button>
                                        </form>
                                        <form method="POST"
                                            action="{{ route('admin.deleted-items.force-delete', ['type' => 'sold_products', 'id' => $soldProduct->id]) }}"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-force-delete"
                                                onclick="return confirm('{{ __('deleted_items.confirm_delete_forever') }}')">
                                                <i class="fas fa-trash me-1"></i>{{ __('deleted_items.delete_forever') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            <!-- Empty State -->
            @if ($statistics['total'] == 0)
                <div class="empty-state">
                    <i class="fas fa-trash-alt"></i>
                    <h3>{{ __('deleted_items.no_deleted_items') }}</h3>
                    <p>{{ __('deleted_items.no_deleted_items_description') }}</p>
                </div>
            @elseif($category !== 'all' && $deletedData[$category]->count() == 0)
                <div class="empty-state">
                    <i class="fas fa-trash-alt"></i>
                    <h3>{{ __('deleted_items.no_deleted_category', ['category' => __('deleted_items.' . $category)]) }}
                    </h3>
                    <p>{{ __('deleted_items.no_deleted_category_description', ['category' => __('deleted_items.' . $category)]) }}
                    </p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-3">
            <div class="quick-actions-sidebar">
                <h6 class="text-uppercase fw-bold mb-3">{{ __('deleted_items.quick_actions') }}</h6>

                <button class="quick-action-btn btn-outline-success" onclick="restoreAllCategory('users')">
                    <i class="fas fa-users"></i>{{ __('deleted_items.restore_all_users') }}
                </button>

                <button class="quick-action-btn btn-outline-info" onclick="restoreAllCategory('products')">
                    <i class="fas fa-box"></i>{{ __('deleted_items.restore_all_products') }}
                </button>

                <button class="quick-action-btn btn-outline-warning" onclick="cleanOldItems()">
                    <i class="fas fa-broom"></i>{{ __('deleted_items.clean_old_items') }}
                </button>

                <button class="quick-action-btn btn-outline-danger" onclick="emptyTrash()">
                    <i class="fas fa-trash-alt"></i>{{ __('deleted_items.empty_trash') }}
                </button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);

            // Search functionality
            const searchInput = document.getElementById('searchInput');
            const dateFilter = document.getElementById('dateFilter');
            const typeFilter = document.getElementById('typeFilter');
            const clearFilters = document.getElementById('clearFilters');

            function applyFilters() {
                const searchTerm = searchInput.value.toLowerCase();
                const dateValue = dateFilter.value;
                const typeValue = typeFilter.value;
                const deletedItems = document.querySelectorAll('.deleted-item');

                deletedItems.forEach(item => {
                    let show = true;

                    // Search filter
                    if (searchTerm) {
                        const itemText = item.textContent.toLowerCase();
                        show = show && itemText.includes(searchTerm);
                    }

                    // Type filter
                    if (typeValue) {
                        const itemType = item.getAttribute('data-type');
                        show = show && itemType === typeValue;
                    }

                    // Date filter
                    if (dateValue) {
                        const deletedAt = item.querySelector('.item-meta').textContent;
                        const daysAgo = parseInt(dateValue);
                        const now = new Date();
                        const itemDate = new Date(now - (daysAgo * 24 * 60 * 60 * 1000));

                        // This is a simplified date check - in real implementation you'd parse the actual date
                        show = show && deletedAt.includes('day') || deletedAt.includes('hour') || deletedAt
                            .includes('minute');
                    }

                    item.style.display = show ? 'block' : 'none';

                    // Hide parent card if no items are visible
                    const parentCard = item.closest('.modern-card');
                    if (parentCard) {
                        const visibleItems = parentCard.querySelectorAll(
                            '.deleted-item[style="display: block"], .deleted-item:not([style*="display: none"])'
                            );
                        parentCard.style.display = visibleItems.length > 0 ? 'block' : 'none';
                    }
                });
            }

            searchInput.addEventListener('input', applyFilters);
            dateFilter.addEventListener('change', applyFilters);
            typeFilter.addEventListener('change', applyFilters);

            clearFilters.addEventListener('click', function() {
                searchInput.value = '';
                dateFilter.value = '';
                typeFilter.value = '';
                applyFilters();
            });

            // Bulk selection functionality
            const selectAllCheckbox = document.getElementById('selectAll');
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');
            const bulkRestore = document.getElementById('bulkRestore');
            const bulkDelete = document.getElementById('bulkDelete');

            function updateBulkActions() {
                const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
                const count = checkedBoxes.length;

                if (count > 0) {
                    bulkActions.classList.add('show');
                    selectedCount.textContent = `${count} {{ __('deleted_items.items') }} selected`;
                } else {
                    bulkActions.classList.remove('show');
                }
            }

            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                itemCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                updateBulkActions();
            });

            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkActions);
            });

            // Bulk restore functionality
            bulkRestore.addEventListener('click', function() {
                const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
                const items = [];

                checkedBoxes.forEach(checkbox => {
                    items.push(checkbox.value);
                });

                if (items.length === 0) {
                    alert('{{ __('deleted_items.no_items_selected') }}');
                    return;
                }

                if (confirm('{{ __('deleted_items.confirm_bulk_restore') }}')) {
                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('admin.deleted-items.bulk-restore') }}';

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    const itemsInput = document.createElement('input');
                    itemsInput.type = 'hidden';
                    itemsInput.name = 'items';
                    itemsInput.value = JSON.stringify(items);
                    form.appendChild(itemsInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            });

            // Bulk delete functionality
            bulkDelete.addEventListener('click', function() {
                const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
                const items = [];

                checkedBoxes.forEach(checkbox => {
                    items.push(checkbox.value);
                });

                if (items.length === 0) {
                    alert('{{ __('deleted_items.no_items_selected') }}');
                    return;
                }

                if (confirm('{{ __('deleted_items.confirm_bulk_delete') }}')) {
                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('admin.deleted-items.bulk-force-delete') }}';

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);

                    const itemsInput = document.createElement('input');
                    itemsInput.type = 'hidden';
                    itemsInput.name = 'items';
                    itemsInput.value = JSON.stringify(items);
                    form.appendChild(itemsInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });

        // Quick action functions
        function restoreAllCategory(category) {
            if (confirm(`{{ __('deleted_items.confirm_restore') }}`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('admin.deleted-items.restore-all') }}';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                const categoryInput = document.createElement('input');
                categoryInput.type = 'hidden';
                categoryInput.name = 'category';
                categoryInput.value = category;
                form.appendChild(categoryInput);

                document.body.appendChild(form);
                form.submit();
            }
        }

        function cleanOldItems() {
            if (confirm('Are you sure you want to permanently delete items older than 90 days?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('admin.deleted-items.clean-old') }}';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                document.body.appendChild(form);
                form.submit();
            }
        }

        function emptyTrash() {
            if (confirm('{{ __('deleted_items.confirm_bulk_delete') }}')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('admin.deleted-items.empty-trash') }}';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endpush
