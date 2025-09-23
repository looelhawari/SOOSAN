@if ($paginator->hasPages())
    <nav aria-label="Pagination Navigation" class="pagination-nav d-flex justify-content-center">
        <ul class="pagination pagination-modern mb-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">
                        <i class="fas fa-chevron-left"></i>
                        <span class="d-none d-sm-inline ms-1">@lang('pagination.previous')</span>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <i class="fas fa-chevron-left"></i>
                        <span class="d-none d-sm-inline ms-1">@lang('pagination.previous')</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link dots">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link current">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link number" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <span class="d-none d-sm-inline me-1">@lang('pagination.next')</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">
                        <span class="d-none d-sm-inline me-1">@lang('pagination.next')</span>
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>

    <style>
        .pagination-nav {
            margin: 1.5rem 0;
        }

        .pagination-modern {
            gap: 0.25rem;
        }

        .pagination-modern .page-link {
            background: #ffffff;
            border: 2px solid #e3e6f0;
            color: #5a5c69;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            min-width: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .pagination-modern .page-link:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
        }

        .pagination-modern .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            transform: translateY(-1px);
        }

        .pagination-modern .page-item.active .page-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(102, 126, 234, 0.5);
        }

        .pagination-modern .page-item.disabled .page-link {
            background: #f8f9fc;
            border-color: #e3e6f0;
            color: #a8a8a8;
            cursor: not-allowed;
            box-shadow: none;
        }

        .pagination-modern .page-item.disabled .page-link:hover {
            background: #f8f9fc;
            border-color: #e3e6f0;
            color: #a8a8a8;
            transform: none;
            box-shadow: none;
        }

        .pagination-modern .page-link.dots {
            background: transparent;
            border-color: transparent;
            color: #a8a8a8;
            cursor: default;
            font-weight: bold;
        }

        .pagination-modern .page-link.dots:hover {
            background: transparent;
            border-color: transparent;
            color: #a8a8a8;
            transform: none;
            box-shadow: none;
        }

        /* Enhanced responsive design */
        @media (max-width: 576px) {
            .pagination-modern .page-link {
                padding: 0.5rem 0.75rem;
                font-size: 0.8rem;
                min-width: 40px;
            }

            .pagination-modern {
                gap: 0.15rem;
            }
        }

        /* RTL Support */
        [dir="rtl"] .pagination-modern .page-link {
            direction: rtl;
        }

        /* Animation for page transitions */
        .pagination-modern .page-link {
            position: relative;
            overflow: hidden;
        }

        .pagination-modern .page-link:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .pagination-modern .page-link:hover:before {
            left: 100%;
        }
    </style>
@endif
