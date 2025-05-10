@extends('layouts.main')

@section('title', $career->title)
@section('id', 'CareersDetails')

@section('content')
    <x-layout.header-image title="{{__($career->title)}}"></x-layout.header-image>

    <section
        class="d-flex header-careers-details container flex-column align-items-center justify-content-center"
    >
        <h1>{{$career->title}}</h1>
        <div class="d-flex align-items-center">
            <img src="{{asset('/images/icons/location-black.png')}}" alt="" />
            <p class="mb-0 px-2">{{$career->category->title}}</p>
        </div>
    </section>
    <section class="container careers-details-inner-container">
        <h3>@lang('site.Job Description'):</h3>
        {!! $career->description !!}
        <span>@lang('site.Requirements')</span>
        {!! $career->qualifications !!}
        <span>@lang('site.Desirable'):</span>
        {!! $career->desirable !!}
        <span>@lang('site.Benefits'):</span>
        {!! $career->benefits !!}
    </section>

    <div
        class="d-flex bottom-career-details align-items-center justify-content-center"
    >
        <a href="{{route('careers.apply-step-1', ['career' => $career->slug])}}">
            <button class="main-btn">@lang('site.Apply for this role')</button>
        </a>
    </div>
@endsection
