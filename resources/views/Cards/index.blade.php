@extends('layouts.main')

@section('title', __('site.Cards'))
@section('id', 'Cards')

@section('content')
    <x-layout.header-image title="{{__('site.Cards')}}"></x-layout.header-image>
    <div class="cards-main-content">
        <h2>@lang('site.CARDS_INDEX_PAGE_TITLE')</h2>
        <p>@lang('site.CARDS_INDEX_PAGE_BRIEF')</p>
    </div>
    <section class="Cards-1st-section mb-5">
        <div class="container cards-container">
            <div class="CardsCards">
                @foreach ($cards as $card)
                    <div class="single-card">
                        <h3>{{$card->title}}</h3>
                        <img src="{{asset('/storage/' . $card->image)}}" alt="">
                        <div class="single-card-content">
                            @foreach($card->features ?? [] as $feature)
                                <div>
                                    <img src="{{asset('/images/icons/true green.png')}}" alt="">
                                    <p>{{$feature['title'][$language]}}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="single-card-btns d-flex flex-column gap-2 mt-4 mb-4">
                            @if ($card->form_type == \App\Models\Card::SINGLE_FORM)
                                <a href="{{route('cards.apply', ['card' => $card, 'section' => $section])}}">
                                    <button class="main-btn mt-4">@lang('site.Apply now')</button>
                                </a>
                            @else
                                <a href="{{route('cards.apply-step-1', ['card' => $card, 'section' => $section])}}">
                                    <button class="main-btn mt-4">@lang('site.Apply now')</button>
                                </a>
                            @endif
                            <a href="{{route('cards.show', ['section' => $section, 'card' => $card])}}">
                                <button class="secondry-btn">@lang('site.Read More')</button>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @if ($bottom_section)
        <section class="Cards-2nd-section mb-5">
            <div class="container cards-2nd-container">
                <img src="{{asset('/storage/' . $bottom_section->image)}}" alt="">
                <div class="cards-2nd-container-content">
                    <h2>
                        {{$bottom_section->title}}
                    </h2>
                    {!! $bottom_section->description !!}
                    {!! $bottom_section->content !!}
                    @if ($bottom_section->buttons)
                        <a href="{{$bottom_section->buttons[0]['url'][$language]}}">
                            <button class="main-btn">{{$bottom_section->buttons[0]['text'][$language]}}</button>
                        </a>
                    @endif
                </div>
            </div>
        </section>
    @endif
@endsection
