<div class="firstnav">
    <div class="container">
        <ul class="social-links">
            @if (app(\App\Settings\Site::class)->facebook_link)
                <li>
                    <a href="{{app(\App\Settings\Site::class)->facebook_link}}">
                        <img src="{{asset('/images/icons/facebook.svg')}}" alt="@lang('site.facebook')" srcset="" />
                    </a>
                </li>
            @endif

            @if(app(\App\Settings\Site::class)->instagram_link)
                <li>
                    <a href="{{app(\App\Settings\Site::class)->instagram_link}}">
                        <img src="{{asset('/images/icons/instagram.svg')}}" alt="@lang('site.instagram')" srcset="" />
                    </a>
                </li>
            @endif

            @if (app(\App\Settings\Site::class)->twitter_link)
                <li>
                    <a href="{{app(\App\Settings\Site::class)->twitter_link}}">
                        <img src="{{asset('/images/icons/twitter.svg')}}" alt="" srcset="" />
                    </a>
                </li>
            @endif

            @if (app(\App\Settings\Site::class)->linkedin_link)
                <li>
                    <a href="{{app(\App\Settings\Site::class)->linkedin_link}}">
                        <img src="{{asset('/images/icons/linkedin.svg')}}" alt="" srcset="" />
                    </a>
                </li>
            @endif
        </ul>

        <div class="upper-header-nav-second">
           @if ($menu)
                <ul>
                    @foreach($menu->links as $link)
                        <li>
                            <a href="{{$link['link'][$language]}}">
                                @if (isset($link['image']) && is_string($link['image']))
                                    <img src="{{asset('/storage/' . $link['image'])}}" />
                                @endif
                                {{$link['title'][$language]}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
            <x-layout.language-switcher></x-layout.language-switcher>
        </div>
    </div>
</div>