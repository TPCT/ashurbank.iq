@if($paginator->hasPages())
    <div class="pagination mb-3">
        <span class="arrows @if($paginator->onFirstPage()) opacity-03 @endif">
            @if ($paginator->onFirstPage())
                <span class="fw-bold">
                    <i class="fa-solid fa-arrow-left px-2"></i>
                    @lang('site.Previous')
                </span>
            @else
                <a href="{{$paginator->previousPageUrl()}}" class="text-bold">
                    <i class="fa-solid fa-arrow-left px-2"></i>
                    @lang('site.Previous')
                </a>
            @endif

        </span>

        @foreach ($elements as $index => $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage() - 3)
                        <span class="page active">
                                    <a href="{{$url}}">
                                        ...
                                    </a>
                                </span>
                    @elseif($page == $paginator->currentPage() + 3)
                        <span class="page active">
                                <a href="{{$url}}">
                                        ...
                                    </a>
                                </span>
                    @endif
                    @continue($page < $paginator->currentPage() - 2)
                    @break($page > $paginator->currentPage() + 2)
                    @if ($page == $paginator->currentPage())
                        <span class="page active disabled">
                            {{$page}}
                        </span>
                    @else
                        <span class="page">
                            <a href="{{$url}}">{{$page}}</a>
                        </span>
                    @endif
                @endforeach
            @endif
        @endforeach

        <span class="arrows @if(!$paginator->hasMorePages()) opacity-03 @endif">
            @if ($paginator->hasMorePages())
                <a href="{{$paginator->nextPageUrl()}}" class="fw-bold">
                    @lang('site.Next')
                    <i class="fa-solid fa-arrow-right px-2"></i>
                </a>
            @else
                <span class="text-bold">
                    @lang('site.Next')
                    <i class="fa-solid fa-arrow-right px-2"></i>
                </span>
            @endif

        </span>
    </div>
@endif
