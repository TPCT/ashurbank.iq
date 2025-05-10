<footer class="footer-container">
    <div class="container footer-section border-bottom-0">
        @foreach($menu->links as $link_id => $link)
            <div class="footer-item wow slideInRight">
                <div
                    class="d-flex align-items-center justify-content-between footer-item-header"
                >
                    <h4>{{$link['title'][$language]}}</h4>
                    <button
                        class="toggleButton mobile-responsive"
                        data-target="footer-menu-item-{{$link_id}}"
                    >
                        <i class="fa-solid fa-plus"></i>
                        <i class="fa-solid fa-minus"></i>
                    </button>
                </div>
                <ul id="footer-menu-item-{{$link_id}}">
                    @foreach($link['children'] as $child)
                        <li>
                            <a href="{{$child['link'][$language]}}"> {{$child['title'][$language]}} </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    <div class="container">
        <div class="footer-item flex-grow-0 w-15 wow slideInLeft footer-contact-us">
            <div
                class="d-flex align-items-center justify-content-between footer-item-header"
            >
                <h4>@lang('site.Quick contact')</h4>
{{--                <button--}}
{{--                    class="toggleButton mobile-responsive"--}}
{{--                    data-target="quick-contact"--}}
{{--                >--}}
{{--                    <i class="fa-solid fa-plus"></i>--}}
{{--                    <i class="fa-solid fa-minus"></i>--}}
{{--                </button>--}}
            </div>
            <ul id="quick-contact">
                @if (app(\App\Settings\Site::class)->email)
                    <div class="footer-contact-content">
                        <img src="{{asset('/images/icons/footer-email.svg')}}" alt="" srcset="" />
                        <p class="d-inline-block opacity-07">
                            <a class="text-dark text-decoration-none" href="mailto:{{app(\App\Settings\Site::class)->email}}">
                                {{app(\App\Settings\Site::class)->email}}
                            </a>
                        </p>
                    </div>
                @endif

                @if (app(\App\Settings\Site::class)->phone)
                    <div class="footer-contact-content">
                        <img src="{{asset('/images/icons/footer-phone.svg')}}" alt="" srcset="" />
                        <p class="d-inline-block opacity-07">
                            <a class="text-decoration-none text-dark site-phone" href="tel:{{app(\App\Settings\Site::class)->phone}}">
                                {{app(\App\Settings\Site::class)->phone}}
                            </a>
                        </p>
                    </div>
                @endif
                <div class="footer-social-icons">
                    @if(app(\App\Settings\Site::class)->facebook_link)
                        <li>
                            <a href="{{app(\App\Settings\Site::class)->facebook_link}}">
                                <img
                                    src="{{asset('/images/icons/Social Icons.png')}}"
                                    alt=""
                                    srcset=""
                                />
                            </a>
                        </li>
                    @endif
                    @if(app(\App\Settings\Site::class)->twitter_link)
                        <li>
                            <a href="{{app(\App\Settings\Site::class)->twitter_link}}">
                                <img
                                    src="{{asset('/images/icons/Social Icons (1).png')}}"
                                    alt=""
                                    srcset=""
                                />
                            </a>
                        </li>
                    @endif

                    @if(app(\App\Settings\Site::class)->instagram_link)
                        <li>
                            <a href="{{app(\App\Settings\Site::class)->instagram_link}}">
                                <img
                                    src="{{asset('/images/icons/Social Icons (2).png')}}"
                                    alt=""
                                    srcset=""
                                />
                            </a>
                        </li>
                    @endif

                    @if(app(\App\Settings\Site::class)->linkedin_link)
                        <li>
                            <a href="{{app(\App\Settings\Site::class)->linkedin_link}}">
                                <img
                                    src="{{asset('/images/icons/Social Icons (3).png')}}"
                                    alt=""
                                    srcset=""
                                />
                            </a>
                        </li>
                    @endif
                </div>
            </ul>
        </div>
    </div>
    <div class="copyrights-section">
        <div class="backtotop-box">
            <img src="{{asset('/images/icons/right arrow.png')}}" alt="" srcset="" />
            <p>@lang('site.Back to top')</p>
        </div>
        <div class="container pt-5">
           <div class="row">
               <div class="col-md-3 col-12">
                   <a href="/privacy-policy">
                       @lang('site.Privacy Policy')
                   </a>
                   <span>-</span>
                   <a href="/terms-and-conditions">
                       @lang('site.Terms and conditions')
                   </a>
               </div>
               <div class="col-12 col-md-6 d-flex justify-content-center">
                   <p>
                       @lang('site.Copyright') &copy; {{date('Y')}} @lang('site.Ashur Bank - All Rights Reserved'). @lang('Developed By') <span><a href="https://dot.jo">@lang('site.dot jo').</a> </span>
                   </p>
               </div>
               <div class="col-12 col-md-3"></div>
           </div>
        </div>
    </div>

    <x-accessibility></x-accessibility>
</footer>
