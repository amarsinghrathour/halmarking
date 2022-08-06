@if ($paginator->hasPages())

        <ul class="pagination text-center justify-content-center">
                                    <li class="page-item"><a class="page-link" href="javascript:void(0);"><i class="fal fa-arrow-left"></i></a></li>
                                    <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
                                    <li class="page-item active"><a class="page-link" href="javascript:void(0);">2</a></li>
                                    <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                                    <li class="page-item"><a class="page-link" href="javascript:void(0);"><i class="fal fa-arrow-right"></i></a></li>
                                </ul>
                        @if ($paginator->onFirstPage())
                        <li class="page-item"><a class="page-link" href="javascript:void(0);"><i class="fal fa-arrow-left"></i></a></li>
                        @else
                        <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}"><i class="fal fa-arrow-left"></i></a>
                        </li>
                        @endif
                        {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                ......
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                <li>
                                <span class="cur-page"><span>{{ $page }}</span></span></li>
                                @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                         @if ($paginator->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}"><i class="fal fa-arrow-right"></i></a></li>
                        @else
                        <li class="page-item"><a class="page-link" href="javascript:void(0);"><i class="fal fa-arrow-right"></i></a></li>
                        @endif
                   </ul>
                    <p class="akasha-result-count">Showing {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} of {{ $paginator->total() }} results</p>

                    @endif
