@extends('layouts.admin')

@section('title', __('admin.notifications'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('admin.notifications') }}</h4>
                        @if ($notifications->count() > 0)
                            <form method="POST" action="{{ route('notifications.mark-all-as-read') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                    {{ __('admin.mark_all_as_read') }}
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($notifications->count() > 0)
                            <div class="list-group">
                                @foreach ($notifications as $notification)
                                    <div
                                        class="list-group-item {{ $notification->read_at ? '' : 'list-group-item-warning' }}">
                                        <div class="d-flex w-100 justify-content-between">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">
                                                    {{ $notification->data['title'] ?? __('admin.notifications') }}
                                                    @if (!$notification->read_at)
                                                        <span class="badge bg-warning ms-2">{{ __('admin.new') }}</span>
                                                    @endif
                                                </h6>
                                                <p class="mb-1">{{ $notification->data['message'] ?? '' }}</p>

                                                @if (isset($notification->data['reason']) && $notification->data['reason'])
                                                    <div class="alert alert-danger mt-2 mb-2">
                                                        <strong>{{ __('admin.reason_for_rejection') }}</strong>
                                                        {{ $notification->data['reason'] }}
                                                    </div>
                                                @endif

                                                @if (isset($notification->data['reviewed_by']))
                                                    <small class="text-muted">
                                                        {{ __('admin.reviewed_by') }}
                                                        {{ $notification->data['reviewed_by'] }}
                                                        @if (isset($notification->data['reviewed_at']))
                                                            {{ __('admin.reviewed_at') }}
                                                            {{ $notification->data['reviewed_at'] }}
                                                        @endif
                                                    </small>
                                                @endif
                                            </div>

                                            <div class="ms-3">
                                                <small
                                                    class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                @if (!$notification->read_at)
                                                    <form method="POST"
                                                        action="{{ route('notifications.mark-as-read', $notification->id) }}"
                                                        class="d-inline mt-2">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                            {{ __('admin.mark_as_read') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-3">
                                <nav aria-label="{{ __('admin.notifications_pagination_aria') }}"
                                    class="d-flex justify-content-center">
                                    <ul class="pagination pagination-modern">
                                        @if ($notifications->onFirstPage())
                                            <li class="page-item disabled"><span
                                                    class="page-link">{{ __('admin.pagination_previous') }}</span></li>
                                        @else
                                            <li class="page-item"><a class="page-link"
                                                    href="{{ $notifications->previousPageUrl() }}"
                                                    rel="prev">{{ __('admin.pagination_previous') }}</a></li>
                                        @endif

                                        @foreach ($notifications->getUrlRange(1, $notifications->lastPage()) as $page => $url)
                                            @if ($page == $notifications->currentPage())
                                                <li class="page-item active"><span
                                                        class="page-link">{{ $page }}</span></li>
                                            @elseif (
                                                $page == 1 ||
                                                    $page == $notifications->lastPage() ||
                                                    ($page >= $notifications->currentPage() - 2 && $page <= $notifications->currentPage() + 2))
                                                <li class="page-item"><a class="page-link"
                                                        href="{{ $url }}">{{ $page }}</a></li>
                                            @elseif ($page == $notifications->currentPage() - 3 || $page == $notifications->currentPage() + 3)
                                                <li class="page-item disabled"><span
                                                        class="page-link">{{ __('admin.pagination_ellipsis') }}</span></li>
                                            @endif
                                        @endforeach

                                        @if ($notifications->hasMorePages())
                                            <li class="page-item"><a class="page-link"
                                                    href="{{ $notifications->nextPageUrl() }}"
                                                    rel="next">{{ __('admin.pagination_next') }}</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled"><span
                                                    class="page-link">{{ __('admin.pagination_next') }}</span></li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">{{ __('admin.no_notifications_yet') }}</h5>
                                <p class="text-muted">{{ __('admin.notifications_help') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
