<html lang="{{app()->getLocale()}}">
<head>
    <title>
        @if (app(\App\Settings\General::class)->site_title)
            @hasSection('title')
                @yield('title') -
            @endif
            {{app(\App\Settings\General::class)->site_title[app()->getLocale()] ?? config('app.name')}}
        @endif
    </title>

    @if($google_tag_key = app(\App\Settings\Site::class)->google_tag_code)
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id={{$google_tag_key}}"
                    height="0" width="0" style="display:none;visibility:hidden">
            </iframe>
        </noscript>
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{{$google_tag_key}}');</script>
    @endif

    <link rel="icon" type="image/x-icon" href="{{asset('/storage/' . app(\App\Settings\Site::class)->fav_icon)}}"/>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <x-layout.seo></x-layout.seo>

    <link
        href="{{asset('/css/bootstrap/bootstrap.min.css')}}"
        type="text/css"
        rel="stylesheet"
    />
    <link
        rel="stylesheet"
        type="text/css"
        href="{{asset('/js/slick-1.8.1/slick/slick.css')}}"
    />
    <link rel="stylesheet" href="{{asset('/js/slick-1.8.1/slick/slick-theme.css')}}" />
    <link rel="stylesheet" href="{{asset('/css/carousel.css')}}" />
    <link rel="stylesheet" href="{{asset('/css/fancybox.css')}}" />
    <link rel="stylesheet" href="{{asset('/css/owl.carousel.css')}}" />
    <link rel="stylesheet" href="{{asset('/css/intlTelInput.css')}}" />
    <link rel="stylesheet" href="{{asset('/css/animate.css')}}" />
    <link rel="stylesheet" href="{{asset('/css/jquery-ui.css')}}" />

    <link href="{{asset('/css/menu.css')}}" rel="stylesheet" />
    <link href="{{asset('/css/regular.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/solid.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/brands.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/fontawesome.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/styles.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/arabic-styles.css')}}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{asset('css/custom.css')}}" />
    <link rel="stylesheet" href="{{asset('css/accessibility-tools.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/errors.css')}}"/>


    <script src="{{asset('/js/wow.js')}}"></script>
    <script>
        new WOW().init();
    </script>

    @stack('style')
</head>

@if (app()->getLocale() == "en")
<body>
@elseif (app()->getLocale() == "ar")
<body class="arabic-version">
@elseif (app()->getLocale() == "fa")
<body class="arabic-version kurdish-version">
@endif
    <x-layout.header></x-layout.header>
    <x-layout.side-menu></x-layout.side-menu>
    <main id="@yield('id')" class="@yield('class')">
        <span id="readspeakerDiv">
            @yield('content')
        </span>
    </main>
    <x-layout.footer></x-layout.footer>

    <script type="text/javascript" src="{{asset('/js/jquery-3.7.1.js')}}"></script>
    <script
        type="text/javascript"
        src="{{asset('/js/slick-1.8.1/slick/slick.min.js')}}"
    ></script>
    <script type="text/javascript" src="{{asset('/js/bootstrap/popper.min.js')}}"></script>
    <script
        type="text/javascript"
        src="{{asset('/js/bootstrap/bootstrap.bundle.min.js')}}"
    ></script>
    <script
            type="text/javascript"
            src="{{asset('/js/jquery-ui.js')}}"
    ></script>
    <script src="{{asset('/js/menu.js')}}"></script>
    <script src="{{asset('/js/carousel.umd.js')}}"></script>
    <script src="{{asset('/js/fancybox.umd.js')}}"></script>
    <script src="{{asset('/js/owl.carousel.js')}}"></script>
    <script src="{{asset('/js/intlTelI-nput.min.js')}}"></script>
    <script src="{{asset('/js/main.js')}}"></script>
    <script src="{{asset('js/accessibility-tools.js')}}"></script>
    @if (app(\App\Settings\Site::class)->chat_key)
        <script>
            (function(d, w, c) {
                w.BrevoConversationsID = "{{app(\App\Settings\Site::class)->chat_key}}";
                w[c] = w[c] || function() {
                    (w[c].q = w[c].q || []).push(arguments);
                };
                var s = d.createElement('script');
                s.async = true;
                s.src = 'https://conversations-widget.brevo.com/brevo-conversations.js';
                if (d.head) d.head.appendChild(s);
            })(document, window, 'BrevoConversations');
        </script>

    @endif
        {!! NoCaptcha::renderJs() !!}

    @stack('script')
</body>
</html>
