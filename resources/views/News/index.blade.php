@extends('layouts.main')

@section('title', __('site.News'))
@section('id', 'News')

@section('content')
    <x-layout.header-image title="{{__('site.News')}}"></x-layout.header-image>
    @if ($heading_news)
        <section class="container main-news-image-container pt-5">
            <img src="{{asset('/storage/' . $heading_news->image)}}" alt="" />
            <div
                class="main-news-image-content-container d-flex flex-column align-items-start"
            >
                <div class="main-news-content">
                    <a href="{{route('news.show', ['news' => $heading_news->slug])}}" class="">
                        <h4>
                            {{$heading_news->title}}
                        </h4>
                        <i class="fa-solid fa-arrow-up"></i>
                    </a>
                </div>

                <div class="main-news-paragraph">
                    {!! $heading_news->description !!}
                    <div class="main-news-date-container">
                        <p>@lang('site.Published on')</p>
                        <span>{{$heading_news->publishedAt()}}</span>
                    </div>
                </div>
            </div>
        </section>
    @endif


    <section class="container news-tabs-container pt-5">
        <form method="get" id="search-form">
            <input id="category_id" type="hidden" name="category_id">
        </form>

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button
                    class="nav-link active"
                    id="nav-home-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#nav-view-all"
                    type="button"
                    role="tab"
                    aria-controls="nav-view-all"
                    aria-selected="true"
                    data-category_id="{{null}}"
                >
                    @lang('site.View all')
                </button>
                @foreach($news_categories as $index => $news_category)
                    <button
                        class="nav-link"
                        id="nav-{{$index}}-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#nav-view-all"
                        type="button"
                        role="tab"
                        aria-controls="nav-view-all"
                        aria-selected="true"
                        data-category_id="{{$news_category->id}}"
                    >
                        {{$news_category->title}}
                    </button>
                @endforeach
            </div>
        </nav>
        <div class="tab-content" id="items-section">
            <div
                class="tab-pane main-news-tabs-container fade show active"
                id="nav-view-all"
                role="tabpanel"
                aria-labelledby="nav-view-all-tab"
            >
                <div class="main-news-tabs-grid-container">
                    @foreach($news as $news_piece)
                        <a href="{{route('news.show', ['news' => $news_piece->slug])}}" class="single-news-card--tab">
                            <img src="{{asset('/storage/' . $news_piece->imagePath)}}" alt="" />
                            <span>{{$news_piece->publishedAt()}}</span>
                            <div class="single-news-card--tab-flex">
                                <h3>{{$news_piece->title}}</h3>
                                <i class="fa-solid fa-arrow-up"></i>
                            </div>
                            {!! $news_piece->description !!}
                        </a>
                    @endforeach
                </div>
                <div class="main-news-pagination-container ">
                    {{$news->links()}}

                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(function(){
            $("#search-form").on('submit', function(e){
                e.preventDefault();
                $("#items-section").load('{{route('news.index')}}' + "?" + $(this).serialize() + " " + "#items-section");
            })

            $(".nav-link").on('click', function(){
                $('.nav-link').removeClass('active');
                $(this).addClass('active');
                $("#category_id").val($(this).data('category_id'))
                $("#search-form").submit();
            })
        })
    </script>
@endpush
