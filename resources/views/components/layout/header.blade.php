<nav class="header-panel-btm">
    <div class="row">
        <x-layout.top-header-menu></x-layout.top-header-menu>
        <div class="hewader-panel-main">
            <div
                class="header-logo container d-flex flex-column flex-lg-row align-items-start align-items-lg-center"
            >
                <a href="{{route('site.index')}}">
                    <img src="{{asset('/storage/' . app(\App\Settings\Site::class)->translate('logo'))}}" />
                </a>
                <form class="d-flex ms-lg-auto" method="post" action="{{route('site.filter')}}">
                    @csrf
                    <input
                        class="form-control me-2 search-input"
                        type="search"
                        placeholder="@lang('site.Search')"
                        aria-label="@lang('site.Search')"
                    />
                    @if ($menu->buttons)
                        <li class="nav-item dropdown signin-btn">
                            <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    id="navbarScrollingDropdown"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                            >
                                @lang('site.Sign in')
                            </a>
                            <ul
                                    class="dropdown-menu dropdown-menu-small"
                                    aria-labelledby="navbarScrollingDropdown"
                            >
                                @foreach($menu->buttons ?? [] as $button)
                                    <li><a class="dropdown-item" href="{{$button['link'][$language]}}">{{$button['title'][$language]}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </form>
            </div>
        </div>

        <div class="px-0">
            <div class="header-menu container px-0">
                <nav id="cssmenu" class="head_btm_menu">
                    <ul class=" ">
                        @foreach($menu?->links ?? [] as $link_id => $link)
                            @continue(isset($link['inactive']) && $link['inactive'])
                            <li>
                                @if (isset($link['children']) && count($link['children']))
                                    <a href="{{$link['link'][$language]}}" class="{{\App\Helpers\Utilities::getActiveLink($link)}}">
                                        <i class="fa-solid fa-chevron-down"></i>
                                        {{$link['title'][$language]}}
                                    </a>
                                    <ul>
                                        @foreach($link['children'] as $child)
                                            @continue(!isset($child['link'], $child['title']))
                                            @continue(isset($child['inactive']) && $child['inactive'])
                                            @if (isset($child['children']) && count($child['children']))
                                                <li class="grandson-menu">
                                                    <a href="{{$child['link'][$language]}}" >
                                                        <i class="fa-solid fa-chevron-right"></i>
                                                        {{$child['title'][$language]}}
                                                    </a>
                                                    <ul class="grandson">
                                                        @foreach($child['children'] as $subChild)
                                                            @continue(!isset($subChild['link'], $subChild['title']))
                                                            @continue(isset($subChild['inactive']) && $subChild['inactive'])
                                                            <li>
                                                                <a href="{{$subChild['link'][$language]}}" >
                                                                    {{$subChild['title'][$language]}}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                <li>
                                                    <a href="{{$child['link'][$language]}}">{{$child['title'][$language]}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @else
                                    <a class="{{\App\Helpers\Utilities::getActiveLink($link)}}" href="{{$link['link'][$language]}}">{{$link['title'][$language]}}</a>
                                @endif
                            </li>
                        @endforeach

                        <x-layout.mobile-language-switcher></x-layout.mobile-language-switcher>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</nav>
