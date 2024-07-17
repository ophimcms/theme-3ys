<ul class="myui-page text-center clearfix">
    @if ($paginator->hasPages())
        @if ($paginator->onFirstPage())
        @else
            <li><a class="btn btn-default" href="{{ $paginator->previousPageUrl() }}">@lang('pagination.previous')</a>
            </li>
        @endif
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="hidden-xs"><a class="btn  btn-warm">{{ $page }}</a></li>
                    @else
                        <li class="hidden-xs"><a class="btn  btn-default" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a class="btn btn-default" href="{{ $paginator->nextPageUrl() }}">@lang('pagination.next')</a></li>
        @else
        @endif
    @endif
</ul>
