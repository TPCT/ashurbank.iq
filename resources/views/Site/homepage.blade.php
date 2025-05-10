@extends('layouts.main')

@section('title', '')

@section('id', 'Home')
@section('class', 'overflow-hidden')

@section('content')
    <section class="home-slider1-section">
        <x-layout.homepage-banner></x-layout.homepage-banner>
    </section>


    @if (isset($banking_services_slider))
        <section class="home-slider2-section text-center">
            <p class="primary-paragraph">{{$banking_services_slider->title}}</p>
            <h3>{{$banking_services_slider->second_title}}</h3>
            <div class="container home-slider2-container home-slider2">
                @foreach($banking_services_slider->slides as $slide)
                    <a href="{{$slide['link'] ? $slide['link'][$language] : ''}}">
                        <div class="home-slider2-card">
                            <img src="{{asset('/storage/' . $slide['image'])}}"/>
                            <p class="primary-color">{{$slide['title'][$language]}}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
    
    @if(isset($homepage_first_section))
        <section class="Home-1st-section wow slideInLeft">
            <section>
                <div class="container">
                    <div class="Home-1st-section-content">
                        <p class="primary-color primary-paragraph">{{$homepage_first_section->title}}</p>
                        <h3>{{$homepage_first_section->second_title}}</h3>
                        {!! $homepage_first_section->description !!}
                        <div class="opacity-07">
                            {!! $homepage_first_section->content !!}
                        </div>
                        @if ($homepage_first_section->buttons)
                            <a class="main-btn" href="{{$homepage_first_section->buttons[0]['url'][$language]}}">{{$homepage_first_section->buttons[0]['text'][$language]}}</a>
                        @endif
                    </div>
                </div>
            </section>
            <style >
                :root {
                    --first-section-background-image:url("  {{asset('/storage/' . $homepage_first_section->image)}} ");
                    /* {{ Storage::url($homepage_first_section->image) }} */
                }
            </style>
            <section class="first-section-background"> 
                @if(isset($homepage_first_section->features) && count($homepage_first_section->features))
                    <img src="{{asset('/images/icons/Logo 3.png')}}" alt="" srcset="">
                    <div class="Home-1st-section-orange-box">
                        <h3>{{$homepage_first_section->features[0]['title'][$language]}}</h3>
                        {!! $homepage_first_section->features[0]['description'][$language] !!}
                    </div>
                @endif
            </section>
        </section>
    @endif

    @if ($homepage_second_section)
        <section class="Home-2nd-section wow slideInRight">
            <div class="Home-2nd-container container">
                <div class="Home-2nd-section-content">
                    <h3>{{$homepage_second_section->title}}</h3>
                    {!! $homepage_second_section->description !!}
                    @if ($homepage_second_section->buttons && count($homepage_second_section->buttons))
                        <a href="{{$homepage_second_section->buttons[0]['url'][$language]}}">
                            <button class="main-btn">{{$homepage_second_section->buttons[0]['text'][$language]}}</button>
                        </a>
                    @endif

                </div>
                @if ($homepage_second_section->features)
                    <div class="Home-2nd-section-cards">
                        @foreach($homepage_second_section->features ?? [] as $index => $feature)
                            @break($index > 2)
                            <div class="Home-2nd-section-card">
                                <img src="{{asset('/storage/' . $feature['image'])}}" alt="">
                                <h3>{{$feature['title'][$language]}}</h3>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </section>
    @endif

    @if($homepage_third_section)
        <section class="Home-3rd-section wow slideInLeft">
            <div class="Home-3rd-container container">
                <div class="Home-3rd-section-mainimg">
                    <img src="{{asset('/storage/' . $homepage_third_section->image)}}" alt="" srcset="">
                </div>
                <div>
                    <div class="Home-3rd-section-content">
                        <p class="primary-color primary-paragraph">{{$homepage_third_section->title}}</p>
                        <h3>{{$homepage_third_section->second_title}}</h3>
                        <div class="opacity-07">
                            {!! $homepage_third_section->description !!}
                        </div>
                    </div>

                    @if ($homepage_third_section->features)
                        <div>
                            @foreach($homepage_third_section->features ?? [] as $index => $feature)
                                @break($index > 2)
                                <div class="Home-3rd-section-blueBox">
                                    <div>
                                        <img src="{{asset('/storage/' . $feature['image'])}}" alt="" srcset="">
                                    </div>
                                    <p class="primary-color">{{$feature['title'][$language]}}</p>
                                </div>
                            @endforeach
                            @if($homepage_third_section->buttons)
                                <a href="{{$homepage_third_section->buttons[0]['url'][$language]}}">
                                    <button class="main-btn">{{$homepage_third_section->buttons[0]['text'][$language]}}</button>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    @if ($homepage_fourth_section)
        <section class="Home-4th-section wow slideInRight">
            <div class="Home-4th-container-img container">
                <img src="{{asset('/storage/' . $homepage_fourth_section->image)}}" alt="" srcset="">
            </div>
            <div class="container Home-4th-container">
                <div class="Home-4th-container-content">
                    <p class="primary-paragraph">{{$homepage_fourth_section->title}}</p>
                    <h3>{{$homepage_fourth_section->second_title}}</h3>
                    {!! $homepage_fourth_section->description !!}
                </div>

                @if ($homepage_fourth_section->features)
                    <div class="Home-4th-section-cards">
                        @foreach($homepage_fourth_section->features ?? [] as $index => $feature)
                            @break($index > 2)
                            <div class="Home-4th-section-card shadow">
                                <div class="Home-4th-section-card-content">
                                    <img src="{{asset('/storage/' . $feature['image'])}}" alt="">
                                    <h3 class="primary-color">{{$feature['title'][$language]}}</h3>
                                </div>
                                {!! $feature['description'][$language] !!}
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </section>
    @endif

    @if ($homepage_fifth_section)
        <section class="Home-5th-section wow slideInLeft">
            <div class="container Home-5th-container">
                <div class="Home-5th-container-content">
                    <h3>{{$homepage_fifth_section->title}}</h3>
                    @if ($homepage_fifth_section->features)
                        <div class="Home-5th-section-cards">
                            @foreach($homepage_fifth_section->features ?? [] as $index => $feature)
                                @break($index > 2)
                                <div class="Home-5th-section-card">
                                    <div class="Home-5th-section-card-icon">
                                        <img src="{{asset('/storage/' . $feature['image'])}}" alt="" srcset="">
                                    </div>
                                    <p>{{$feature['title'][$language]}}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="Home-5th-container-text">
                        {!! $homepage_fifth_section->description !!}
                    </div>
                    @if ($homepage_fifth_section->buttons)
                        <a href="{{$homepage_fifth_section->buttons[0]['url'][$language]}}">
                            <button class="main-btn">{{$homepage_fifth_section->buttons[0]['text'][$language]}}</button>
                        </a>
                    @endif
                </div>
            </div>
            <div class="Home-5th-container-white-box">
                <img src="{{asset('/images/icons/moneygram_logo-freelogovectors.net_.png')}}" alt="" srcset="">
                <h3>@lang('site.MoneyGram')</h3>
                <p>@lang('site.Money transfer')</p>
                <h3>@lang('site.Main partner')</h3>
            </div>
        </section>
    @endif

    @if ($homepage_sixth_section && $homepage_faqs)
        <section class="Home-6th-section wow slideInRight">
            <div class="container Home-6th-container">
                <div>
                    <p class="Home-6th-container-heading primary-paragraph">{{$homepage_sixth_section->title}}</p>
                    <h3>{{$homepage_sixth_section->second_title}}</h3>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        @foreach($homepage_faqs as $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-{{$faq->id}}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#flush-collapse-{{$faq->id}}" aria-expanded="false"
                                            aria-controls="flush-collapseOne">
                                        {{$faq->title}}
                                    </button>
                                </h2>
                                <div id="flush-collapse-{{$faq->id}}" class="accordion-collapse collapse"
                                     aria-labelledby="flush-{{$faq->id}}" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        {!! $faq->description !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <div class="Home-6th-container-content">
                        {!! $homepage_sixth_section->description !!}
                        <a href="{{route('site.faqs')}}">
                            <button>@lang('site.View all')
                                <img src="{{asset('/images/icons/right arrow.png')}}" alt="" srcset="" class="none-on-hover">
                                <img src="{{asset('/images/icons/nextwhite.png')}}" alt="" srcset="" class="display-on-hover">
                            </button>
                        </a>
                    </div>
                    <div class="d-flex flex-column">
                        @foreach($homepage_faqs_videos as $faq_video)
                            <a class="d-flex flex-column text-decoration-none" href="{{$faq_video->video_url}}">
                                <img src="{{asset('/storage/' . $faq_video->image)}}" alt="">
                                <p>{{$faq_video->title}}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($homepage_seventh_section)
        <section class="Home-7th-section wow slideInLeft">
            <div class="container Home-7th-container">
                <div class=" Home-7th-container-content">
                    <p class="primary-paragraph">{{$homepage_seventh_section->title}}</p>
                    {!! $homepage_seventh_section->description !!}
                    <div class="opacity-07 mt-3">
                        {!! $homepage_seventh_section->content !!}
                    </div>
                    <div class="Home-7th-container-cards">
                        @foreach($homepage_seventh_section->features ?? [] as $feature)
                            <div class="Home-7th-container-card">
                                <div class="Home-7th-container-icon">
                                    <img src="{{asset('/storage/' . $feature['image'])}}" alt="" srcset="">
                                </div>
                                <p>{{$feature['title'][$language]}}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="Home-7th-container-downloadStores">
                        @if(app(\App\Settings\Site::class)->app_store_link)
                            <a href="{{app(\App\Settings\Site::class)->app_store_link}}">
                                <img src="{{asset('/images/icons/Apple Store.png')}}" alt="">
                            </a>
                        @endif

                        @if (app(\App\Settings\Site::class)->play_store_link)
                            <a href="{{app(\App\Settings\Site::class)->play_store_link}}">
                                <img src="{{asset('/images/icons/Google Store.png')}}" alt="">
                            </a>
                        @endif
                    </div>
                </div>
                <div class="Home-7th-container-img">
                    <img src="{{asset('/storage/' . $homepage_seventh_section->image)}}" alt="" srcset="">
                </div>
            </div>
        </section>
    @endif

@endsection



@push('script')
    <script>
        $('.home-slider2').slick({
            arrows: false,
            speed: 700,
            dots: true,
            infinite: true,
            autoplay: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            rtl: {{$rtl}},
            responsive: [
                {
                    breakpoint: 990,
                    settings: {
                        slidesToShow: 2,
                    }
                },

                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    }
                }
            ]
        });
    </script>
@endpush
