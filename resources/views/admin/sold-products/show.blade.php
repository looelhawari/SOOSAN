@extends('layouts.admin')

@section('title', __('sold-products.sale_details'))
@section('page-title', __('sold-products.sale_details'))

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        --warning-gradient: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        --danger-gradient: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
        --info-gradient: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
        --secondary-gradient: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        --border-radius: 1rem;
        --border-radius-sm: 0.5rem;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --transition-fast: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
        --card-shadow-hover: 0 15px 40px rgba(0,0,0,0.15);
    }

    .modern-page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #ffffff;
        padding: 2rem 1.5rem;
        margin: -1rem -1rem 2rem;
        border-radius: 0 0 24px 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
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

    .modern-card {
        background: #fff;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        border: none;
        margin-bottom: 2rem;
        overflow: hidden;
        transition: var(--transition);
    }

    .modern-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--card-shadow-hover);
    }

    .modern-card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        padding: 1.5rem;
        border-bottom: 1px solid #e9ecef;
        position: relative;
    }

    .modern-card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
    }

    .modern-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #495057;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modern-card-body {
        padding: 1.5rem;
    }

    .modern-btn {
        background: var(--primary-gradient);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }

    .modern-btn:hover {
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    .modern-btn-warning {
        background: var(--warning-gradient);
    }

    .modern-btn-warning:hover {
        box-shadow: 0 8px 25px rgba(255, 193, 7, 0.3);
    }

    .modern-btn-danger {
        background: var(--danger-gradient);
    }

    .modern-btn-danger:hover {
        box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
    }

    .modern-btn-secondary {
        background: var(--secondary-gradient);
    }

    .modern-btn-secondary:hover {
        box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
    }

    /* Product Icon */
    .sale-icon {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
        margin: 0 auto 1.5rem;
        box-shadow: 0 15px 30px rgba(102, 126, 234, 0.3);
    }

    /* Info Rows */
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-row:hover {
        background-color: rgba(102, 126, 234, 0.05);
        padding-left: 1rem;
        padding-right: 1rem;
        border-radius: 8px;
    }

    .info-label {
        font-weight: 600;
        color: #4b5563;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-value {
        color: #1f2937;
        text-align: right;
        font-weight: 500;
    }

    /* Warranty Badges */
    .warranty-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .warranty-active {
        background: #10b981;
        color: white;
    }

    .warranty-expired {
        background: #ef4444;
        color: white;
    }

    /* Progress Bar */
    .progress {
        height: 12px;
        border-radius: 10px;
        background: #e5e7eb;
        overflow: hidden;
    }

    .progress-bar {
        background: #10b981;
        transition: width 0.6s ease;
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .modern-page-header {
            margin: -1rem -1rem 1.5rem;
            padding: 1.5rem;
        }

        .sale-icon {
            width: 100px;
            height: 100px;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .info-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
            padding: 0.75rem 0;
        }

        .info-value {
            text-align: left;
            margin-left: 1rem;
        }

        .modern-btn {
            width: 100%;
            justify-content: center;
            margin-bottom: 0.5rem;
        }
    }
</style>

<!-- Modern Page Header -->
<div class="modern-page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1 class="h2 mb-2">{{ __('sold-products.sale_details') }}</h1>
            <p class="mb-0 opacity-75">{{ __('sold-products.complete_information') }}</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.sold-products.edit', $soldProduct) }}" class="modern-btn modern-btn-warning">
                <i class="fas fa-edit"></i>
                <span class="d-none d-sm-inline">{{ __('sold-products.edit_sale') }}</span>
                <span class="d-sm-none">{{ __('sold-products.edit') }}</span>
            </a>
            <a href="{{ route('admin.sold-products.index') }}" class="modern-btn modern-btn-secondary">
                <i class="fas fa-arrow-left"></i>
                <span class="d-none d-sm-inline">{{ __('sold-products.back_to_sales') }}</span>
                <span class="d-sm-none">{{ __('sold-products.back') }}</span>
            </a>
        </div>
    </div>
</div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 1rem; border: none; box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="modern-card">
                <div class="modern-card-header">
                    <div class="text-center">
                        <div class="sale-icon">
                            @if($soldProduct->product && $soldProduct->product->image_url)
                                <img src="{{ $soldProduct->product->image_url }}" alt="{{ $soldProduct->product->model_name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            @else
                                <i class="fas fa-shopping-cart"></i>
                            @endif
                        </div>
                    <h3 class="mb-1">{{ __('sold-products.sale_number', ['id' => $soldProduct->id]) }}</h3>
                    <p class="text-muted mb-0">{{ $soldProduct->product->model_name ?? __('sold-products.na') }}</p>
                    <div class="mt-3">
                        @if($soldProduct->warranty_voided)
                            <span class="warranty-badge warranty-expired">
                                <i class="fas fa-ban"></i>
                                {{ __('sold-products.warranty_voided') }}
                            </span>
                        @elseif($soldProduct->isUnderWarranty())
                            <span class="warranty-badge warranty-active">
                                <i class="fas fa-shield-alt"></i>
                                {{ __('sold-products.under_warranty') }}
                            </span>
                        @else
                            <span class="warranty-badge warranty-expired">
                                <i class="fas fa-shield-alt"></i>
                                {{ __('sold-products.warranty_expired') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modern-card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-box text-primary"></i>
                                {{ __('sold-products.product') }}:
                            </span>
                            <span class="info-value">
                                @if($soldProduct->product)
                                    <a href="{{ route('admin.products.show', $soldProduct->product) }}" class="text-decoration-none">
                                        {{ $soldProduct->product->model_name }}
                                    </a>
                                @else
                                    {{ __('sold-products.na') }}
                                @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-user text-info"></i>
                                {{ __('sold-products.owner') }}:
                            </span>
                            <span class="info-value">
                                @if($soldProduct->owner)
                                    <a href="{{ route('admin.owners.show', $soldProduct->owner) }}" class="text-decoration-none">
                                        {{ $soldProduct->owner->name }}
                                    </a>
                                @else
                                    {{ __('sold-products.na') }}
                                @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-user-tie text-secondary"></i>
                                {{ __('sold-products.employee') }}:
                            </span>
                            <span class="info-value">
                                @if($soldProduct->employee)
                                    {{ $soldProduct->employee->name }} ({{ ucfirst($soldProduct->employee->role) }})
                                @else
                                    {{ __('sold-products.na') }}
                                @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-barcode text-warning"></i>
                                {{ __('sold-products.serial_number') }}:
                            </span>
                            <span class="info-value">
                                <strong>{{ $soldProduct->serial_number }}</strong>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-layer-group text-primary"></i>
                                {{ __('sold-products.quantity') }}:
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-dollar-sign text-success"></i>
                                {{ __('sold-products.purchase_price') }}:
                            </span>
                            <span class="info-value">
                                <strong class="text-success">${{ number_format($soldProduct->purchase_price ?? 0, 2) }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-calendar text-primary"></i>
                                {{ __('sold-products.sale_date') }}:
                            </span>
                            <span class="info-value">{{ $soldProduct->sale_date ? $soldProduct->sale_date->locale(app()->getLocale())->translatedFormat('j F Y') : __('sold-products.na') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-calendar-check text-success"></i>
                                {{ __('sold-products.warranty_start') }}:
                            </span>
                            <span class="info-value">{{ $soldProduct->warranty_start_date ? $soldProduct->warranty_start_date->locale(app()->getLocale())->translatedFormat('j F Y') : __('sold-products.na') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-calendar-times text-danger"></i>
                                {{ __('sold-products.warranty_end') }}:
                            </span>
                            <span class="info-value">{{ $soldProduct->warranty_end_date ? $soldProduct->warranty_end_date->locale(app()->getLocale())->translatedFormat('j F Y') : __('sold-products.na') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-clock text-info"></i>
                                {{ __('sold-products.created') }}:
                            </span>
                            <span class="info-value">{{ $soldProduct->created_at ? $soldProduct->created_at->setTimezone('Africa/Cairo')->locale(app()->getLocale())->translatedFormat('j F Y H:i') : __('sold-products.na') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-edit text-warning"></i>
                                {{ __('sold-products.updated') }}:
                            </span>
                            <span class="info-value">{{ $soldProduct->updated_at ? $soldProduct->updated_at->setTimezone('Africa/Cairo')->locale(app()->getLocale())->translatedFormat('j F Y H:i') : __('sold-products.na') }}</span>
                        </div>
                    </div>
                </div>

                @if($soldProduct->notes)
                <div class="mt-4">
                    <h6 class="info-label mb-3">
                        <i class="fas fa-sticky-note text-warning me-2"></i>
                        {{ __('sold-products.additional_notes') }}:
                    </h6>
                    <div class="p-3" style="background: #f8f9fa; border-radius: 0.75rem; border-left: 4px solid #667eea;">
                        {{ $soldProduct->notes }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

        <div class="col-lg-4">
            <div class="modern-card">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">
                        <i class="fas fa-bolt"></i>
                        {{ __('sold-products.quick_actions') }}
                    </h5>
                </div>
                <div class="modern-card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.sold-products.edit', $soldProduct) }}" class="modern-btn modern-btn-warning">
                            <i class="fas fa-edit"></i>
                            {{ __('sold-products.edit_sale') }}
                        </a>

                        @if($soldProduct->product)
                            <a href="{{ route('admin.products.show', $soldProduct->product) }}" class="modern-btn modern-btn-secondary">
                                <i class="fas fa-cube"></i>
                                {{ __('sold-products.view_product') }}
                            </a>
                        @endif

                        @if($soldProduct->owner)
                            <a href="{{ route('admin.owners.show', $soldProduct->owner) }}" class="modern-btn modern-btn-secondary">
                                <i class="fas fa-user"></i>
                                {{ __('sold-products.view_owner') }}
                            </a>
                        @endif

                        <form method="POST" action="{{ route('admin.sold-products.destroy', $soldProduct) }}" class="d-inline"
                              onsubmit="return confirm('{{ __('sold-products.confirm_delete') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="modern-btn modern-btn-danger w-100">
                                <i class="fas fa-trash"></i>
                                {{ __('sold-products.delete_sale') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            @if($soldProduct->warranty_start_date && $soldProduct->warranty_end_date)
            <div class="modern-card">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">
                        <i class="fas fa-shield-alt"></i>
                        {{ __('sold-products.warranty_information') }}
                    </h5>
                </div>
            <div class="modern-card-body">
                <div class="text-center">
                    @php
                        $warrantyStart = $soldProduct->warranty_start_date;
                        $warrantyEnd = $soldProduct->warranty_end_date;
                        $now = now()->startOfDay();
                        $isActive = $soldProduct->isUnderWarranty(); // Use the model method for consistency
                        $daysRemaining = 0;
                        $totalDays = 0;
                        $daysUsed = 0;
                        $percentage = 0;

                        if ($warrantyStart && $warrantyEnd) {
                            $startDate = $warrantyStart->startOfDay();
                            $endDate = $warrantyEnd->endOfDay();
                            $totalDays = (int) $startDate->diffInDays($endDate);

                            if ($isActive) {
                                $daysRemaining = (int) $now->diffInDays($endDate);
                                $daysUsed = (int) $startDate->diffInDays($now);
                                $percentage = $totalDays > 0 ? min(100, round(($daysUsed / $totalDays) * 100)) : 0;
                            }
                        }
                    @endphp

                    @if($isActive)
                        <div class="warranty-badge warranty-active mb-3">
                            <i class="fas fa-shield-alt"></i>
                            {{ __('sold-products.active_warranty') }}
                        </div>
                        <p class="mb-2"><strong>{{ __('sold-products.days_remaining', ['days' => $daysRemaining]) }}</strong></p>
                        <div class="progress mb-3">
                            <div class="progress-bar" style="width: {{ $percentage }}%; background: var(--success-gradient);" role="progressbar"></div>
                        </div>
                    @elseif($soldProduct->warranty_voided)
                        <div class="warranty-badge warranty-expired mb-3">
                            <i class="fas fa-ban"></i>
                            {{ __('sold-products.warranty_voided') }}
                        </div>
                        <p class="text-muted">{{ __('sold-products.warranty_voided_message') }}</p>
                    @else
                        <div class="warranty-badge warranty-expired mb-3">
                            <i class="fas fa-shield-alt"></i>
                            {{ __('sold-products.warranty_expired') }}
                        </div>
                        @if($warrantyStart && $now->lt($warrantyStart->startOfDay()))
                            <p class="text-muted">{{ __('sold-products.warranty_not_started') }}</p>
                        @elseif($warrantyEnd)
                            <p class="text-muted">{{ __('sold-products.expired_time_ago', ['time' => $warrantyEnd->diffForHumans()]) }}</p>
                        @endif
                    @endif

                    @if($warrantyStart && $warrantyEnd)
                        <small class="text-muted d-block">
                            {{ $warrantyStart->locale(app()->getLocale())->translatedFormat('j F Y') }} - {{ $warrantyEnd->locale(app()->getLocale())->translatedFormat('j F Y') }}
                        </small>
                    @endif
                </div>
            </div>
        </div>
        @endif

            @if(auth()->user()->isAdmin() || auth()->user()->isEmployee())
                <div class="modern-card">
                    <div class="modern-card-header">
                        <h5 class="modern-card-title">
                            <i class="fas fa-cog"></i>
                            {{ __('sold-products.warranty_management') }}
                        </h5>
                    </div>
                    <div class="modern-card-body">
                        @if(!$soldProduct->warranty_voided)
                            <button type="button" class="modern-btn modern-btn-danger w-100" data-bs-toggle="modal" data-bs-target="#voidWarrantyModal">
                                <i class="fas fa-ban"></i>
                                <span class="d-none d-sm-inline">{{ __('sold-products.void_sale') }}</span>
                                <span class="d-sm-none">{{ __('Void') }}</span>
                            </button>
                    @else
                        <div class="alert alert-warning" style="border-radius: 1rem; margin: 0;">
                            <div class="text-center">
                                <i class="fas fa-ban me-2"></i>
                                <strong>{{ __('sold-products.warranty_voided') }}</strong>
                            </div>
                            <hr>
                            <small>
                                <strong>{{ __('sold-products.voided_by') }}:</strong> {{ optional($soldProduct->warrantyVoidedBy)->name ?? '-' }}<br>
                                <strong>{{ __('sold-products.voided_at') }}:</strong> {{ $soldProduct->warranty_voided_at ? $soldProduct->warranty_voided_at->setTimezone('Africa/Cairo')->locale(app()->getLocale())->translatedFormat('j F Y H:i') : '-' }}<br>
                                <strong>{{ __('sold-products.voided_reason') }}:</strong> {{ $soldProduct->warranty_void_reason }}
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Void Warranty Modal -->
<div class="modal fade" id="voidWarrantyModal" tabindex="-1" aria-labelledby="voidWarrantyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: var(--border-radius);">
            <form method="POST" action="{{ route('admin.sold-products.void-warranty', $soldProduct) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="voidWarrantyModalLabel">
                        <i class="fas fa-ban me-2"></i>
                        Void Warranty
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="warranty_void_reason" class="form-label">Reason for voiding <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="warranty_void_reason" name="warranty_void_reason" rows="4" required style="border-radius: var(--border-radius-sm);"></textarea>
                    </div>
                    <div class="alert alert-warning" style="border-radius: var(--border-radius-sm);">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        This action cannot be undone. The warranty will be permanently voided for this device.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-ban me-2"></i>
                        Confirm Void
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Progress bar animation
    const progressBar = document.querySelector('.progress-bar');
    if (progressBar) {
        const targetWidth = progressBar.style.width;
        progressBar.style.width = '0%';

        setTimeout(() => {
            progressBar.style.width = targetWidth;
        }, 1000);
    }

    // Enhanced button interactions for mobile
    if (window.innerWidth <= 768) {
        const buttons = document.querySelectorAll('.modern-btn');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });
    }

    // Touch feedback for mobile devices
    if ('ontouchstart' in window) {
        document.querySelectorAll('.modern-card, .modern-btn').forEach(element => {
            element.addEventListener('touchstart', function() {
                this.style.transform = (this.style.transform || '') + ' scale(0.98)';
            });

            element.addEventListener('touchend', function() {
                this.style.transform = this.style.transform.replace(' scale(0.98)', '');
            });
        });
    }
});
</script>
@endsection
