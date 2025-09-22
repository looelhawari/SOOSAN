@extends('layouts.admin')

@section('title', 'تفاصيل الرسالة - نظام البريد الإلكتروني')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        --warning-gradient: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        --danger-gradient: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
        --info-gradient: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
        --border-radius: 1rem;
        --border-radius-sm: 0.5rem;
        --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
        --card-shadow-hover: 0 15px 40px rgba(0,0,0,0.15);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .modern-page-header {
        background: var(--primary-gradient);
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

    .modern-page-header::after {
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

    /* Cards */
    .modern-card {
        background: #fff;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        border: none;
        margin-bottom: 2rem;
        overflow: hidden;
        transition: var(--transition);
        position: relative;
    }

    .modern-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
        transform: scaleX(0);
        transition: var(--transition);
    }

    .modern-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--card-shadow-hover);
    }

    .modern-card:hover::before {
        transform: scaleX(1);
    }

    .admin-card {
        background: #fff;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        border: none;
        overflow: hidden;
        transition: var(--transition);
        position: relative;
    }

    .admin-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
        transform: scaleX(0);
        transition: var(--transition);
    }

    .admin-card:hover::before {
        transform: scaleX(1);
    }

    /* Message Avatar */
    .message-avatar-large {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: var(--primary-gradient);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 700;
        margin: 0 auto;
        position: relative;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    /* Message Content */
    .message-content {
        background: #f8f9fa;
        border-radius: var(--border-radius);
        padding: 2rem;
        margin: 1.5rem 0;
        border-left: 4px solid var(--primary-gradient);
        position: relative;
        overflow: hidden;
        line-height: 1.8;
        font-size: 1.05rem;
    }

    .message-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.02), rgba(118, 75, 162, 0.02));
        z-index: 1;
    }

    .message-content > * {
        position: relative;
        z-index: 2;
    }

    /* Buttons */
    .modern-btn {
        background: var(--primary-gradient);
        border: none;
        color: white;
        padding: 0.875rem 2rem;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .modern-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .modern-btn:hover::before {
        left: 100%;
    }

    .modern-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .modern-btn-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    }

    .modern-btn-secondary:hover {
        box-shadow: 0 10px 25px rgba(108, 117, 125, 0.4);
    }

    .modern-btn-success {
        background: var(--success-gradient);
    }

    .modern-btn-success:hover {
        box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3);
    }

    .modern-btn-danger {
        background: var(--danger-gradient);
    }

    .modern-btn-danger:hover {
        box-shadow: 0 10px 25px rgba(220, 53, 69, 0.3);
    }

    .modern-btn-info {
        background: var(--info-gradient);
    }

    .modern-btn-info:hover {
        box-shadow: 0 10px 25px rgba(23, 162, 184, 0.3);
    }

    /* Info Rows */
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #e9ecef;
        transition: var(--transition);
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-row:hover {
        background: rgba(102, 126, 234, 0.03);
        padding-left: 1rem;
        padding-right: 1rem;
        margin-left: -1rem;
        margin-right: -1rem;
        border-radius: var(--border-radius-sm);
    }

    .info-label {
        font-weight: 600;
        color: #495057;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-value {
        font-weight: 500;
        color: #6c757d;
        text-align: end;
    }

    /* Badges */
    .badge-modern {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: var(--transition);
    }

    .badge-modern:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* Attachments */
    .attachment-card {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius);
        padding: 1rem;
        transition: var(--transition);
        text-decoration: none;
        color: inherit;
        display: block;
        position: relative;
        overflow: hidden;
    }

    .attachment-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--info-gradient);
        transform: scaleX(0);
        transition: var(--transition);
    }

    .attachment-card:hover {
        border-color: #17a2b8;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(23, 162, 184, 0.15);
        color: inherit;
        text-decoration: none;
    }

    .attachment-card:hover::before {
        transform: scaleX(1);
    }

    .attachment-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--border-radius-sm);
        background: var(--info-gradient);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .attachment-name {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.25rem;
    }

    .attachment-size {
        font-size: 0.875rem;
        color: #6c757d;
    }

    /* Table Enhancements */
    .table-borderless td {
        padding: 0.75rem 0;
        border: none;
        transition: var(--transition);
    }

    .table-borderless tr:hover td {
        background-color: #f8f9fa;
        border-radius: var(--border-radius-sm);
        transform: translateX(5px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .modern-page-header {
            padding: 2rem 0;
            margin: -1rem -1rem 1.5rem;
        }

        .modern-page-header h1 {
            font-size: 1.5rem;
        }

        .modern-page-header .row > div {
            text-align: center;
            margin-bottom: 1rem;
        }

        .modern-page-header .col-md-4 {
            text-align: center !important;
        }

        .message-avatar-large {
            width: 100px;
            height: 100px;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .admin-card .card-body,
        .admin-card .card-header {
            padding: 1rem;
        }

        .modern-btn {
            width: 100%;
            justify-content: center;
            margin-bottom: 0.5rem;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }

        .d-flex.justify-content-between {
            gap: 1rem;
        }

        .d-flex.justify-content-end {
            flex-direction: column;
            gap: 0.5rem;
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

        .message-content {
            padding: 1.5rem;
            margin: 1rem 0;
        }

        .table-borderless td {
            padding: 0.5rem 0;
        }

        .row .col-md-6 {
            margin-bottom: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .modern-page-header {
            margin: -0.5rem -0.5rem 1rem;
            padding: 1.5rem 0;
        }

        .message-avatar-large {
            width: 80px;
            height: 80px;
            font-size: 2rem;
        }

        .admin-card {
            margin-bottom: 1rem;
        }

        .admin-card .card-body,
        .admin-card .card-header {
            padding: 0.75rem;
        }

        .modern-btn {
            padding: 0.625rem 1rem;
            font-size: 0.8rem;
        }

        .message-content {
            padding: 1rem;
            font-size: 0.9rem;
        }

        .info-row {
            padding: 0.5rem 0;
        }

        .badge-modern {
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
        }
    }

    @media (max-width: 375px) {
        .modern-page-header {
            padding: 1rem 0;
        }

        .message-avatar-large {
            width: 70px;
            height: 70px;
            font-size: 1.75rem;
        }

        .admin-card .card-body,
        .admin-card .card-header {
            padding: 0.5rem;
        }

        .modern-btn {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
        }

        .message-content {
            padding: 0.75rem;
            font-size: 0.85rem;
        }
    }

    /* Animation utilities */
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Focus indicators for accessibility */
    .modern-btn:focus-visible {
        outline: 2px solid #667eea;
        outline-offset: 2px;
    }

    /* Print styles */
    @media print {
        .modern-page-header {
            background: white !important;
            color: black !important;
            box-shadow: none !important;
        }

        .modern-btn {
            display: none !important;
        }

        .modern-card,
        .admin-card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
    }
</style>

<!-- Page Header -->
<div class="modern-page-header animate-fade-in-up">
    <div class="container-fluid position-relative">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="h3 mb-2">تفاصيل الرسالة</h1>
                <p class="mb-0 opacity-90">عرض تفاصيل ومحتوى الرسالة الإلكترونية</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('admin.mails.inbox') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    العودة للصندوق
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <!-- Message Header Card -->
        <div class="col-12">
            <div class="admin-card animate-fade-in-up">
                <div class="card-header bg-transparent p-4">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center">
                            <div class="message-avatar-large">
                                {{ strtoupper(substr($mail['from_name'] ?: $mail['from'], 0, 2)) }}
                            </div>
                            <p class="text-muted mb-3" style="text-transform: capitalize; font-size: 1.25rem; font-weight: bold;">
                                {{ $mail['from_name'] ?: $mail['from'] }}
                            </p>
                            <span class="badge-modern bg-{{ $mail['is_seen'] ? 'success' : 'warning' }}">
                                <i class="fas fa-{{ $mail['is_seen'] ? 'envelope-open' : 'envelope' }} me-1"></i>
                                {{ $mail['is_seen'] ? 'مقروءة' : 'غير مقروءة' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="fw-bold mb-3" style="color: var(--bs-secondary-color);">
                                <i class="fas fa-info-circle me-2" style="color: var(--primary-gradient);"></i>
                                معلومات الرسالة
                            </h5>
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td><strong>من:</strong></td>
                                        <td>{{ $mail['from'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>الموضوع:</strong></td>
                                        <td>{{ $mail['subject'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>التاريخ:</strong></td>
                                        <td>{{ \Carbon\Carbon::parse($mail['date'])->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>الحجم:</strong></td>
                                        <td>{{ round($mail['size'] / 1024, 2) }} KB</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold mb-3" style="color: var(--bs-secondary-color);">
                                <i class="fas fa-cog me-2" style="color: var(--primary-gradient);"></i>
                                تفاصيل إضافية
                            </h5>
                            <table class="table table-borderless">
                                <tbody>
                                    @if($mail['to'])
                                        <tr>
                                            <td><strong>إلى:</strong></td>
                                            <td>{{ $mail['to'] }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td><strong>المرفقات:</strong></td>
                                        <td>
                                            @if(count($mail['attachments']) > 0)
                                                <span class="badge-modern bg-success">
                                                    <i class="fas fa-paperclip me-1"></i>
                                                    {{ count($mail['attachments']) }} مرفق
                                                </span>
                                            @else
                                                <span class="badge-modern bg-secondary">لا توجد مرفقات</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>الحالة:</strong></td>
                                        <td>
                                            <span class="badge-modern bg-{{ $mail['is_seen'] ? 'success' : 'warning' }}">
                                                <i class="fas fa-{{ $mail['is_seen'] ? 'envelope-open' : 'envelope' }} me-1"></i>
                                                {{ $mail['is_seen'] ? 'مقروءة' : 'غير مقروءة' }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message Content -->
        <div class="col-12">
            <div class="modern-card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3" style="font-size: 1.3rem; color: var(--bs-secondary-color);">
                        <i class="fas fa-comment-dots me-2" style="color: var(--primary-gradient);"></i>
                        محتوى الرسالة
                    </h5>
                    <div class="message-content">
                        @if($mail['body_html'])
                            {!! $mail['body_html'] !!}
                        @else
                            {!! nl2br(e($mail['body_text'])) !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Attachments -->
        @if(count($mail['attachments']) > 0)
            <div class="col-12">
                <div class="modern-card">
                    <div class="card-header bg-transparent border-0 p-4">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-paperclip me-2 text-primary"></i>
                            المرفقات ({{ count($mail['attachments']) }})
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            @foreach($mail['attachments'] as $attachment)
                                <div class="col-md-6 col-lg-4">
                                    <a href="{{ route('admin.mails.downloadAttachment', [$mail['uid'], $loop->index]) }}" 
                                       class="attachment-card">
                                        <div class="attachment-icon">
                                            <i class="fas fa-file"></i>
                                        </div>
                                        <div class="attachment-name">{{ $attachment->getName() ?? 'مرفق_' . ($loop->index + 1) }}</div>
                                        <div class="attachment-size">{{ round(($attachment->getSize() ?? 0) / 1024, 2) }} KB</div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="col-12">
            <div class="modern-card">
                <div class="card-body p-4">
                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                        <div class="d-flex flex-wrap gap-2">
                            @if(!$mail['is_seen'])
                                <form action="{{ route('admin.mails.markAsRead', $mail['uid']) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="modern-btn modern-btn-success">
                                        <i class="fas fa-check me-2"></i>
                                        تحديد كمقروءة
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('admin.mails.markAsSpam', $mail['uid']) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="modern-btn modern-btn-danger" 
                                        onclick="return confirm('هل أنت متأكد من تحديد هذه الرسالة كرسالة مزعجة؟')">
                                    <i class="fas fa-ban me-2"></i>
                                    تحديد كرسالة مزعجة
                                </button>
                            </form>

                            <form action="{{ route('admin.mails.archive', $mail['uid']) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="modern-btn modern-btn-info">
                                    <i class="fas fa-archive me-2"></i>
                                    أرشفة
                                </button>
                            </form>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.mails.inbox') }}" class="modern-btn modern-btn-secondary">
                                <i class="fas fa-list me-2"></i>
                                قائمة الرسائل
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Auto-mark as read when viewing
    @if(!$mail['is_seen'])
        setTimeout(function() {
            fetch('{{ route("admin.mails.markAsRead", $mail["uid"]) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(response => {
                if (response.ok) {
                    // Update the badge to show as read
                    const badge = document.querySelector('.badge-modern');
                    if (badge) {
                        badge.className = 'badge-modern bg-success';
                        badge.innerHTML = '<i class="fas fa-envelope-open me-1"></i>مقروءة';
                    }
                    
                    // Update status in table
                    const statusCells = document.querySelectorAll('td:contains("الحالة:")');
                    statusCells.forEach(cell => {
                        const nextCell = cell.nextElementSibling;
                        if (nextCell) {
                            nextCell.innerHTML = '<span class="badge-modern bg-success"><i class="fas fa-envelope-open me-1"></i>مقروءة</span>';
                        }
                    });
                }
            }).catch(error => {
                console.log('Auto-mark as read failed:', error);
            });
        }, 2000); // Mark as read after 2 seconds of viewing
    @endif

    // Smooth scroll for long content
    document.addEventListener('DOMContentLoaded', function() {
        const messageContent = document.querySelector('.message-content');
        if (messageContent && messageContent.scrollHeight > messageContent.clientHeight) {
            messageContent.style.maxHeight = '500px';
            messageContent.style.overflowY = 'auto';
            messageContent.style.scrollBehavior = 'smooth';
        }
    });

    // Enhanced attachment preview
    document.querySelectorAll('.attachment-card').forEach(card => {
        card.addEventListener('click', function(e) {
            const fileName = this.querySelector('.attachment-name').textContent;
            const fileSize = this.querySelector('.attachment-size').textContent;
            
            // Show loading state
            const icon = this.querySelector('.attachment-icon i');
            const originalClass = icon.className;
            icon.className = 'fas fa-spinner fa-spin';
            
            // Reset icon after download starts
            setTimeout(() => {
                icon.className = originalClass;
            }, 1000);
        });
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey || e.metaKey) {
            switch(e.key) {
                case 'r':
                    e.preventDefault();
                    const markReadBtn = document.querySelector('button:contains("تحديد كمقروءة")');
                    if (markReadBtn) markReadBtn.click();
                    break;
                case 'b':
                    e.preventDefault();
                    window.location.href = '{{ route("admin.mails.inbox") }}';
                    break;
            }
        }
    });
</script>
@endpush