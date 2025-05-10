@extends('layouts.main')

@section('title', __('site.Faqs'))
@section('id', 'Faqs')

@section('content')
    <x-layout.header-image title="{{__('site.Faqs')}}"></x-layout.header-image>
    <section>
        <form class="corporate-content container">
            <p>@lang('site.FAQS_SEARCH_FORM_TITLE')</p>
            <h3>@lang('site.FAQS_SEARCH_FORM_SUB_TITLE')</h3>
            <div class="corporate-content-input-container">

                <input
                    class="form-control me-2 search-input"
                    name="search"
                    type="search"
                    value="{{request('search')}}"
                    placeholder="@lang('site.Search')"
                    aria-label="Search"
                />
                <button type="submit">
                    <img src="{{asset('/images/icons/search.png')}}" alt="" />
                </button>
            </div>
        </form>
    </section>

    @if(isset($faqs) && count($faqs))
        <section class="mb-2">
            <div class="container faqs-container">
                <div>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        @foreach($faqs as $index => $faq)
                            @continue($index % 2 == 1)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-{{$index}}">
                                    <button
                                        class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapse-{{$index}}"
                                        aria-expanded="false"
                                        aria-controls="flush-collapse-{{$index}}"
                                    >
                                        {{$faq->title}}
                                    </button>
                                </h2>
                                <div
                                    id="flush-collapse-{{$index}}"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="flush-{{$index}}"
                                    data-bs-parent="#accordionFlushExample"
                                >
                                    <div class="accordion-body">
                                        {!! $faq->description !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <div class="accordion accordion-flush" id="accordionFlushExample2">
                        @foreach($faqs as $index => $faq)
                            @continue($index % 2 == 0)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-{{$index}}">
                                    <button
                                        class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapse-{{$index}}"
                                        aria-expanded="false"
                                        aria-controls="flush-collapse-{{$index}}"
                                    >
                                        {{$faq->title}}
                                    </button>
                                </h2>
                                <div
                                    id="flush-collapse-{{$index}}"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="flush-{{$index}}"
                                    data-bs-parent="#accordionFlushExample2"
                                >
                                    <div class="accordion-body">
                                        {!! $faq->description !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="d-flex justify-content-center p-5">
            <h2 class="text-danger">@lang('site.No Records')</h2>
        </section>
    @endif

    @if (isset($videos) && count($videos))
        <section class="faqs-slide-section">
            <div class="container position-relative">
                <h2>@lang('site.FAQS_VIDEO_TITLE')</h2>
                <div class="home-slider2-container home-slider2">
                    @foreach($videos as $video)
                        <div class="home-slider2-card">
                            <a href="{{$video->video_url}}">
                                <img src="{{asset('/storage/' . $video->image)}}" alt="" />
                                <p>{{$video->title}}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="sliderArrow">
                    <img class="prev" src="{{asset('/images/icons/arrow-left-black.png')}}" />
                    <img class="next" src="{{asset('/images/icons/arrow-right-black.png')}}" />
                </div>
            </div>
        </section>
    @endif
@endsection

@push('script')
    <script>
        $(".home-slider2").slick({
            prevArrow: $(".prev"),
            nextArrow: $(".next"),
            rtl: {{$rtl}},
            arrows: true,
            speed: 700,
            dots: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 990,
                    settings: {
                        slidesToShow: 2,
                    },
                },

                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    },
                },
            ],
        });
    </script>
@endpush
