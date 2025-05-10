@extends('layouts.main')

@section('title', __('site.Calculators'))
@section('id', 'Corporate')

@section('content')
    <x-layout.header-image title="{{__('site.Calculators')}}"></x-layout.header-image>

    <section>
        <div class="corporate-content">
            <p>@lang('site.Calculators_INDEX_TITLE')</p>
            <h3>@lang('site.Calculators_INDEX_BRIEF')</h3>
        </div>
        <div class="container corporate-card-container mb-3">
            @foreach ($calculators as $calculator)
                <div class="corporate-card col-6">
                    <img src="{{asset('/storage/' . $calculator->image)}}" alt="">
                    <div class="corporate-card-content">
                        <h3>{{$calculator->title}}</h3>
                        {!! $calculator->description !!}
                        @if ($calculator->buttons)
                            <a href="{{$calculator->buttons[0]['url'][$language]}}">
                                <button class="main-btn">{{$calculator->buttons[0]['text'][$language]}}</button>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach

        </div>
    </section>
@endsection
