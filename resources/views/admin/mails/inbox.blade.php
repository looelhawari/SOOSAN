@extends('layouts.admin')

@section('title', __('admin.email_inbox'))

@section('content')
<style>
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
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
        background-size: cover;
    }
    .modern-card {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: none;
        margin-bottom: 2rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .modern-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 1rem;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
        transform: rotate(45deg);
        animation: shimmer 3s ease-in-out infinite;
    }
    @keyframes shimmer {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
    }
    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        display: block;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }
    .stat-label {
        font-size: 1rem;
        opacity: 0.9;
        font-weight: 500;
        position: relative;
        z-index: 2;
    }
    .modern-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 0.875rem 2rem;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }
    .modern-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        color: white;
    }
    .modern-btn-warning {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
    }
    .modern-btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }
    .modern-btn-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    }
    .action-btn {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid;
        background: transparent;
        transition: all 0.3s ease;
        margin: 0 0.25rem;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
    }
    .action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        background: var(--bs-gray-50);
    }
    .action-btn.border-info:hover {
        background: rgba(13, 202, 240, 0.1);
        border-color: #0dcaf0;
    }
    .action-btn.border-success:hover {
        background: rgba(25, 135, 84, 0.1);
        border-color: #198754;
    }
    .action-btn.border-danger:hover {
        background: rgba(220, 53, 69, 0.1);
        border-color: #dc3545;
    }
    .badge-modern {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6c757d;
    }
    .empty-state i {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }
    .table-responsive {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .table {
        margin-bottom: 0;
    }
    .table thead th {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 1.25rem 1rem;
        color: #495057;
    }
    .table tbody tr {
        transition: all 0.3s ease;
        border: none;
    }
    .table tbody tr:hover {
        background: #f8f9fa;
        transform: scale(1.01);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .table tbody td {
        padding: 1rem;
        border: none;
        vertical-align: middle;
    }
    .mail-subject {
        font-weight: 600;
        color: #495057;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .mail-subject:hover {
        color: #667eea;
    }
    .mail-from {
        font-weight: 500;
        color: #6c757d;
    }
    .mail-date {
        font-size: 0.875rem;
        color: #6c757d;
    }
    .unread-mail {
        background: rgba(102, 126, 234, 0.05);
        border-left: 4px solid #667eea;
    }
    .mail-attachment {
        color: #28a745;
        font-size: 0.875rem;
    }
    .refresh-btn {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        font-size: 1.5rem;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        transition: all 0.3s ease;
        z-index: 1000;
    }
    .refresh-btn:hover {
        transform: translateY(-3px) rotate(180deg);
        box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
    }
    
    /* Search and Filter Styles */
    .search-filter-section {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .search-input {
        border: 2px solid #e9ecef;
        border-radius: 0.75rem;
        padding: 0.875rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    .search-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }
    .filter-btn {
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        color: #495057;
        padding: 0.875rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .filter-btn.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        color: white;
    }
    .filter-btn:hover {
        background: #e9ecef;
        transform: translateY(-1px);
    }
    .filter-btn.active:hover {
        background: linear-gradient(135deg, #5a6fd8 0%, #6b4190 100%);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        .stat-card {
            padding: 1.5rem;
        }
        .table-responsive {
            font-size: 0.875rem;
        }
        .modern-page-header {
            padding: 1.5rem 1rem;
            margin: -0.5rem -0.5rem 1.5rem;
        }
        .search-filter-section {
            padding: 1rem;
        }
        .refresh-btn {
            bottom: 1rem;
            right: 1rem;
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }
    }
</style>

<!-- Page Header -->
<div class="modern-page-header animate-fade-in-up">
    <div class="container-fluid position-relative">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="h3 mb-2">
                    <i class="fas fa-inbox me-2"></i>
                    {{ __('admin.email_inbox') }}
                </h1>
                <p class="mb-0 opacity-90">{{ __('admin.direct_server_messages') }}</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('admin.dashboard') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    {{ __('admin.back_to_dashboard') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Statistics Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-number">{{ $stats['total_messages'] ?? 0 }}</span>
            <span class="stat-label">{{ __('admin.total_messages') }}</span>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
            <span class="stat-number">{{ $stats['unread_messages'] ?? 0 }}</span>
            <span class="stat-label">{{ __('admin.unread_emails') }}</span>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
            <span class="stat-number">{{ $stats['today_messages'] ?? 0 }}</span>
            <span class="stat-label">{{ __('admin.todays_messages') }}</span>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);">
            <span class="stat-number">{{ $stats['messages_with_attachments'] ?? 0 }}</span>
            <span class="stat-label">{{ __('admin.messages_with_attachments') }}</span>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="search-filter-section">
        <form method="GET" action="{{ route('admin.mails.inbox') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="search" class="form-label fw-semibold">{{ __('admin.search_in_messages') }}</label>
                <input type="text" id="search" name="search" class="form-control search-input" 
                       placeholder="{{ __('admin.search_placeholder') }}" 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label for="folder" class="form-label fw-semibold">{{ __('admin.folder') }}</label>
                <select name="folder" id="folder" class="form-select search-input">
                    <option value="INBOX" {{ request('folder') == 'INBOX' ? 'selected' : '' }}>{{ __('admin.inbox') }}</option>
                    <option value="SENT" {{ request('folder') == 'SENT' ? 'selected' : '' }}>{{ __('admin.sent') }}</option>
                    <option value="SPAM" {{ request('folder') == 'SPAM' ? 'selected' : '' }}>{{ __('admin.spam') }}</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label fw-semibold">{{ __('admin.status') }}</label>
                <select name="status" id="status" class="form-select search-input">
                    <option value="">{{ __('admin.all_messages') }}</option>
                    <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>{{ __('admin.unread') }}</option>
                    <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>{{ __('admin.read_messages') }}</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn modern-btn w-100">
                    <i class="fas fa-search me-2"></i>
                    {{ __('admin.search_btn') }}
                </button>
            </div>
        </form>
    </div>

    <!-- Messages Table -->
    <div class="modern-card">
        <div class="card-header bg-transparent border-0 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-envelope me-2 text-primary"></i>
                    {{ __('admin.incoming_messages') }}
                </h5>
                <div class="d-flex gap-2">
                    <button type="button" class="action-btn border-success" onclick="refreshInbox()" title="{{ __('admin.refresh_inbox') }}">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <a href="{{ route('admin.mails.inbox', ['status' => 'unread']) }}" 
                       class="action-btn border-warning" title="{{ __('admin.unread_messages_filter') }}">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
        </div>

        @if(isset($mails) && $mails->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%"></th>
                            <th width="25%">{{ __('admin.email_from') }}</th>
                            <th width="40%">{{ __('admin.email_subject') }}</th>
                            <th width="15%">{{ __('admin.email_date') }}</th>
                            <th width="15%">{{ __('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mails as $mail)
                            <tr class="{{ $mail['is_seen'] ? '' : 'unread-mail' }}">
                                <td>
                                    <i class="fas fa-{{ $mail['is_seen'] ? 'envelope-open' : 'envelope' }} 
                                              {{ $mail['is_seen'] ? 'text-muted' : 'text-primary' }}"></i>
                                    @if($mail['has_attachments'])
                                        <i class="fas fa-paperclip mail-attachment ms-1" title="{{ __('admin.contains_attachments') }}"></i>
                                    @endif
                                </td>
                                <td>
                                    <div class="mail-from">
                                        {{ $mail['from_name'] ?: $mail['from'] }}
                                    </div>
                                    <small class="text-muted">{{ $mail['from'] }}</small>
                                </td>
                                <td>
                                    <a href="{{ route('admin.mails.show', $mail['uid']) }}" 
                                       class="mail-subject">
                                        {{ Str::limit($mail['subject'], 60) }}
                                    </a>
                                    <div class="small text-muted mt-1">
                                        {{ Str::limit(strip_tags($mail['body_text']), 100) }}
                                    </div>
                                </td>
                                <td>
                                    <div class="mail-date">
                                        {{ \Carbon\Carbon::parse($mail['date'])->format('Y-m-d') }}
                                    </div>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($mail['date'])->format('H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.mails.show', $mail['uid']) }}" 
                                           class="action-btn border-info text-info" title="{{ __('admin.view_message') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if(!$mail['is_seen'])
                                            <form action="{{ route('admin.mails.markAsRead', $mail['uid']) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="action-btn border-success text-success" 
                                                        title="{{ __('admin.mark_as_read_action') }}">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.mails.markAsSpam', $mail['uid']) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="action-btn border-danger text-danger" 
                                                    title="{{ __('admin.mark_as_spam_action') }}"
                                                    onclick="return confirm('{{ __('admin.mark_spam_confirm') }}')">>
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination would go here if implementing pagination -->
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h4 class="mt-3">{{ __('admin.no_messages') }}</h4>
                <p class="text-muted">{{ __('admin.no_messages_found') }}</p>
                <button onclick="refreshInbox()" class="modern-btn">
                    <i class="fas fa-sync-alt me-2"></i>
                    {{ __('admin.refresh_now') }}
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Floating Refresh Button -->
<button class="refresh-btn" onclick="refreshInbox()" title="{{ __('admin.refresh_messages') }}">
    <i class="fas fa-sync-alt"></i>
</button>

@endsection

@push('scripts')
<script>
    function refreshInbox() {
        const refreshBtn = document.querySelector('.refresh-btn');
        const icon = refreshBtn.querySelector('i');
        
        // Add loading state
        icon.style.animation = 'spin 1s linear infinite';
        refreshBtn.disabled = true;
        
        // Reload the page to fetch fresh emails
        setTimeout(() => {
            window.location.reload();
        }, 500);
    }

    // Auto-refresh every 30 seconds
    setInterval(function() {
        const currentTime = new Date().getTime();
        const lastRefresh = localStorage.getItem('lastEmailRefresh');
        
        if (!lastRefresh || currentTime - lastRefresh > 30000) {
            localStorage.setItem('lastEmailRefresh', currentTime);
            
            // Subtle background refresh without full page reload
            fetch('{{ route("admin.mails.inbox") }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(response => {
                if (response.ok) {
                    // Update the unread count badge if exists
                    console.log('Background refresh completed');
                }
            }).catch(error => {
                console.log('Background refresh failed:', error);
            });
        }
    }, 30000);

    // Add spin animation for refresh button
    const style = document.createElement('style');
    style.textContent = `
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);

    // Form validation for search
    document.addEventListener('DOMContentLoaded', function() {
        const searchForm = document.querySelector('form[method="GET"]');
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                const searchInput = this.querySelector('input[name="search"]');
                if (searchInput && searchInput.value.trim() === '' && 
                    !this.querySelector('select[name="folder"]').value && 
                    !this.querySelector('select[name="status"]').value) {
                    e.preventDefault();
                    alert('{{ __('admin.search_validation') }}');
                    searchInput.focus();
                }
            });
        }
    });

    // Show notification function
    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }
</script>
@endpush