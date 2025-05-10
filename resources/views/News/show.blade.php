@extends('layouts.main')

@section('title', $news->title)
@section('id', 'NewsDetails')


@section('content')
    <x-layout.header-image title="{!! $news->title!!}" image="{{$news->imagePath}}"></x-layout.header-image>
    <section class="pt-5 pb-3 pb-sm-5  container news-details-container">
        <div class="recent-news-details-body">
            <div class="recent-news-details-body--header">
                <img
                    src="{{asset('/storage/' . $news->imagePath)}}"
                    alt=""
                />
                <div class="recent-news-details-meta">
                    <span class="colored">{{$news->category->title}}</span>
                    <span>{{$news->author->name}}</span>
                    <span>{{$news->publishedAtForHumans()}}</span>
                </div>
                <h2>
                    {{$news->title}}
                </h2>
                @if($news->description)
                    <div class="p--1">
                        {!! $news->description !!}
                    </div>
                @endif
                <div class="d-flex flex-column flex-sm-row custom-gap">
                    @foreach($news->slider ?? [] as $image)
                        <img src="{{asset('/storage/' . $image['image'])}}"/>
                    @endforeach
                </div>
                @if($news->content)
                    <div class="p--2">
                        {!! $news->content!!}
                    </div>
                @endif
                <hr />
                <x-layout.share route="{{route('news.show', ['locale' => $language, 'news' => $news])}}"></x-layout.share>

                <div class="news-details-body-pagination">
                    @if($prev_post)
                        <a href="{{route('news.show', ['news' => $prev_post])}}" class="">
                            <div class="">
                                <img src="{{asset('/images/icons/news-left-arrow.svg')}}" alt="" />
                            </div>
                            @lang('site.Prev Post')
                        </a>
                    @endif

                    @if($next_post)
                        <a href="{{route('news.show', ['news' => $next_post])}}" class="">
                            <div class="">
                                <img src="{{asset('/images/icons/news-right-arrow.svg')}}" alt="" />
                            </div>
                            @lang('site.Next Post')
                        </a>
                    @endif

                </div>
            </div>
        </div>
        <div class="recent-news-details-container-card shadow">
            <h6>@lang('site.Recent News')</h6>
            <div class="recent-news-details-flex">
                @foreach($recent_news ?? [] as $news_piece)
                    <a href="{{route('news.show', ['news' => $news_piece])}}" class="single-recent-news-details-card">
                        <img
                            src="{{asset('/storage/' . $news_piece->imagePath)}}"
                            alt=""
                        />
                        <div class="recent-news-content">
                            <span>{{$news_piece->publishedAtForHumans2()}}</span>
                            <p> {{$news_piece->title}} </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection
