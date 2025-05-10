@extends('layouts.main')

@section('title', __('site.Careers'))
@section('id', 'Careers')


@section('content')
    <x-layout.header-image title="{{__('site.Careers')}}"></x-layout.header-image>

    <section>
        <form class="container careers-form-container">
            <div class="career-input-container-search">
                <input
                    name="search"
                    id="search"
                    value="{{$search}}"
                    placeholder="@lang('site.Search by: Job tittle, Position, Keyword...')"
                    type="text"
                />
            </div>

            <div class="career-input-container-location">
                <input
                    name="location"
                    id="location"
                    value="{{$location}}"
                    placeholder="@lang('site.City, state or zip code')"
                    type="text"
                />
            </div>
            <div class="career-input-container-button">
                <button type="submit" class="main-btn">@lang('site.Find Job')</button>
            </div>
        </form>
    </section>

    <section class="container">
        <div class="careers-flex-container">
            <h3>@lang('site.Featured job')</h3>
        </div>
        <div class="careers-features-jobs-container">
            @forelse($careers as $career)
                <div class="single-features-job-card">
                    <div class="">
                        <h4>{{$career->title}}</h4>
                        <div class="d-flex align-items-center pb-4 pt-3">
                            <span class="tag-badge"> {{$career->category->title}} </span>
                            <img src="{{asset('/images/icons/location-black.png')}}" alt="" />
                            <p>{{$career->location}}</p>
                        </div>
                    </div>
                    <a href="{{route('careers.show', ['career' => $career->slug])}}" class="outline-button">
                        <button>
                            <span> @lang('site.Explore') </span>
                            <img src="{{asset('/images/icons/right arrow.png')}}" alt="" />
                        </button>
                    </a>
                </div>
            @empty
                <div class="">
                    <h4 class="text-danger">@lang('site.Nothing To Show')</h4>
                </div>
            @endforelse
        </div>
    </section>

    <div class="main-news-pagination-container">
        {{$careers->links()}}
    </div>

@endsection
