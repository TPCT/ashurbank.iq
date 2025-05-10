@extends('layouts.main')

@section('title', __("site.About Us"))
@section('id', 'AboutUs')

@section('content')
    <x-layout.header-image title="{{__('site.About Us')}}"></x-layout.header-image>
    <div class="corporate-content">
        <p>@lang('site.ABOUT_US_PAGE_TITLE')</p>
        <h3>@lang('site.ABOUT_US_PAGE_SUB_TITLE')</h3>
    </div>

    @if($about_us_first_section)
        <section class="AboutUs-1st-section">
            <div class="container AboutUs-1st-container">
                <div class="AboutUs-1st-container-content">
                    <h3>{{$about_us_first_section->title}}</h3>
                    <p class="orange-border">{{$about_us_first_section->second_title}}</p>
                    {!! $about_us_first_section->description !!}
                    @foreach($about_us_first_section->features ?? [] as $feature)
                        <div class="AboutUS-bluebox">
                            <div class="AboutUS-bluebox-title">
                                <img src="{{asset('/storage/' . $feature['image'])}}" alt="" srcset="">
                                <h5>{{$feature['title'][$language]}}</h5>
                            </div>
                            {!! $feature['description'][$language] !!}
                        </div>
                        <br/>
                    @endforeach
                </div>
                <div class="AboutUs-1st-container-img">
                    <img src="{{asset('/storage/' . $about_us_first_section->image)}}" alt="" srcset="">
                    <div class="AboutUs-1st-container-floatingBox">
                        <img src="{{asset('/images/icons/medal-star.png')}}" alt="">
                        <div>
                            <h3>@lang('site.MEDAL_STAR_TITLE')</h3>
                            <p>@lang('site.MEDAL_STAR_DESCRIPTION')</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($about_us_second_section)
        <section>
            <div class="container section-2nd-heading mb-5">
                <p class="primary-color">{{$about_us_second_section->title}}</p>
                <h3>{{$about_us_second_section->second_title}}</h3>
            </div>
        </section>
        <section class="AboutUs-2nd-section">
            <div class="container AboutUs-2nd-container">
                <div class="AboutUs-2nd-container-content">
                    @foreach($about_us_second_section->features ?? [] as $feature)
                        <div>
                            <h3>{{$feature['title'][$language]}}</h3>
                            {!! $feature['description'][$language] !!}
                        </div>
                    @endforeach
                </div>
                <div class="AboutUs-2nd-container-img">
                    <img src="{{asset('/storage/' . $about_us_second_section->image)}}" alt="">
                </div>
            </div>

        </section>
    @endif

    @if($about_us_third_section)
        <section class=" AboutUs-3rd-section">
            <div class="container AboutUs-3rd-container">
                <div class="AboutUs-3rd-container-img">
                    <img src="{{asset('/storage/' . $about_us_third_section->image)}}" alt="">
                </div>
                <div class="AboutUs-3rd-container-content">

                    <div class=" mb-5">
                        <p class="primary-color">{{$about_us_third_section->title}}</p>
                        <h3>{{$about_us_third_section->second_title}}</h3>
                    </div>
                    {!! $about_us_third_section->description !!}
                </div>
            </div>

        </section>
    @endif

    @if($about_us_fourth_section)
        <section class=" AboutUs-4th-section">
            <h3 class="text-center mb-5">{{$about_us_fourth_section->title}}</h3>
            <div class="container AboutUs-4th-container">
                <div class="AboutUs-4th-container-img">
                    <img src="{{asset('/storage/' . $about_us_fourth_section->image)}}" alt="">
                    <div>
                        <img src="{{asset('/images/dots/aboutdots.png')}}" alt="" srcset="">
                    </div>
                </div>
                <div class="AboutUs-4th-container-content">

                    <div class=" mb-3">
                        <h3>{{$about_us_fourth_section->second_title}}</h3>
                        <div class="primary-color about-us-chairman-title">
                            {!! $about_us_fourth_section->description !!}
                        </div>
                    </div>
                    {!! $about_us_fourth_section->content !!}
                </div>
            </div>
        </section>
    @endif


    @if($board_of_directors)
        <section class=" AboutUs-5th-section mb-5">
            <div class="container AboutUs-5th-section-content">
                <h3 class="text-center mt-5 mb-2">@lang('site.BOARD_OF_DIRECTORS_TITLE')</h3>
                <p>@lang('site.BOARD_OF_DIRECTORS_BRIEF')</p>
            </div>
            <div class="container AboutUs-5th-container">
                @foreach($board_of_directors as $board_director)
                    <div class="AboutUs-5th-container-card">
                        <div class="AboutUs-5th-container-card-img">
                            <img src="{{asset('/storage/' . $board_director->image)}}" alt="" srcset="">
                        </div>
                        <h3>{{$board_director->name}}</h3>
                        <p class="primary-color">{{$board_director->position}}</p>
                    </div>
                @endforeach
            </div>

        </section>

    @endif


@endsection
