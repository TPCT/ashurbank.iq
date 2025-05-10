@extends('layouts.main')

@section('title', __('site.Corporate'))
@section('id', 'Corporate')

@section('content')
    <x-layout.header-image title="{{__('site.Corporate')}}"></x-layout.header-image>

    <section>
        <div class="corporate-content">
            <p>@lang('site.CORPORATE_INDEX_TITLE')</p>
            <h3>@lang('site.CORPORATE_INDEX_BRIEF')</h3>
        </div>
        <div class="container corporate-card-container">
            @if ($first_section)
                <div class="corporate-card col-6">
                    <img src="{{asset('/storage/' . $first_section->image)}}" alt="">
                    <div class="corporate-card-content">
                        <h3>{{$first_section->title}}</h3>
                        {!! $first_section->description !!}
                        @if ($first_section->buttons)
                            <a href="{{$first_section->buttons[0]['url'][$language]}}">
                                <button class="main-btn">{{$first_section->buttons[0]['text'][$language]}}</button>
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            @if ($second_section)
                <div class="corporate-card col-6">
                    <img src="{{asset('/storage/' . $second_section->image)}}" alt="">
                    <div class="corporate-card-content">
                        <h3>{{$second_section->title}}</h3>
                        {!! $second_section->description !!}
                        @if ($second_section->buttons)
                            <a href="{{$second_section->buttons[0]['url'][$language]}}">
                                <button class="main-btn">{{$second_section->buttons[0]['text'][$language]}}</button>
                            </a>
                        @endif
                    </div>
                </div>
            @endif


            @if ($third_section)
                <div class="corporate-card col-6">
                    <img src="{{asset('/storage/' . $third_section->image)}}" alt="">
                    <div class="corporate-card-content">
                        <h3>{{$third_section->title}}</h3>
                        {!! $third_section->description !!}
                        @if ($third_section->buttons)
                            <a href="{{$third_section->buttons[0]['url'][$language]}}">
                                <button class="main-btn">{{$third_section->buttons[0]['text'][$language]}}</button>
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            @if ($fourth_section)
                <div class="corporate-card col-6">
                    <img src="{{asset('/storage/' . $fourth_section->image)}}" alt="">
                    <div class="corporate-card-content">
                        <h3>{{$fourth_section->title}}</h3>
                        {!! $fourth_section->description !!}
                        @if ($fourth_section->buttons)
                            <a href="{{$fourth_section->buttons[0]['url'][$language]}}">
                                <button class="main-btn">{{$fourth_section->buttons[0]['text'][$language]}}</button>
                            </a>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </section>

    @if ($fifth_section)
        <div>
            <div class="last-container" style="background-image: url('{{asset('/storage/' . $fifth_section->image)}}')">
                <h5>{{$fifth_section->title}}</h5>
                <p>{{$fifth_section->second_title}}</p>
            </div>
        </div>
    @endif
@endsection
