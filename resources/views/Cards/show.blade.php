@extends('layouts.main')

@section('title', $card->title)
@section('id', 'DebitCard')

@section('content')
    <x-layout.header-image title="{{$card->title}}"></x-layout.header-image>
    <section class="mb-5">
        <div class="container Debit-Container">
            <div class="Debit-Container-content">
                <h3>{{$card->title}}</h3>
                {!! $card->description !!}
                <div class="d-flex flex-column">
                    {!! $card->content !!}
                </div>
                @if ($card->form_type == \App\Models\Card::SINGLE_FORM)
                    <a href="{{route('cards.apply', ['card' => $card, 'section' => $section])}}">
                        <button class="main-btn mt-4">@lang('site.Apply now')</button>
                    </a>
                @else
                    <a href="{{route('cards.apply-step-1', ['card' => $card, 'section' => $section])}}">
                        <button class="main-btn mt-4">@lang('site.Apply now')</button>
                    </a>
                @endif
            </div>
            <img
                    src="{{asset('/storage/' . $card->inner_image)}}"
                    alt=""
                    srcset=""
            />
        </div>
    </section>

@endsection
