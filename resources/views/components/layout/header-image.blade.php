<section class="pages-header {{$class}}" style="background-image: url('{{asset($image)}}') !important;">
    <div class="container pages-header-content">
        <h3>{!! $title !!}</h3>
        <p>
            @php
                $url = "";
            @endphp
            @foreach(request()->segments() as $index => $segment)
                @if ($loop->first)
                    <a class="bread-crumb-active" href="/">@lang('site.Home')</a> <span class="bread-crumb-separator">|</span>
                @elseif($loop->last)
                    <span class="bread-crumb-last">{!! $title !!}</span>
                @else
                    @php
                        $url .= "/" . $segment;
                        $route = app('router')->getRoutes()->match(app('request')->create($url));
                        if (!$route->getName())
                            continue;
                    @endphp

                    @if ($route->isFallback)
                        <span class="bread-crumb-last">@lang('site.' . ucfirst(str_replace('-', ' ', $segment)))</span> <span class="bread-crumb-separator">|</span>
                    @else
                        <a class="bread-crumb-active" href="{{$url}}">@lang('site.' . ucfirst(str_replace('-', ' ', $segment)))</a> <span class="bread-crumb-separator">|</span>
                    @endif
                @endif
            @endforeach
        </p>
    </div>
</section>
