@extends('layouts.main')

@section('title', __('site.Offers'))
@section('id', 'Corporate')

@section('content')
    <x-layout.header-image title="{{__('site.Offers')}}"></x-layout.header-image>

    <section>
        <div class="corporate-content">
            <p>@lang('site.OFFERS_INDEX_TITLE')</p>
            <h3>@lang('site.OFFERS_INDEX_BRIEF')</h3>
        </div>
        <div class="container corporate-card-container mb-3">
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
        </div>
    </section>
@endsection
