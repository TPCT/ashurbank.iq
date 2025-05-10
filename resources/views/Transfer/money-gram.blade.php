@extends('layouts.main')

@section('title', $transfer->title)
@section('id', 'BankTransfer')

@section('content')
    <x-layout.header-image title="{{$transfer->title}}"></x-layout.header-image>
    <section>
        <div class="container Loans-subs">
            <h2>{{$transfer->title}}</h2>
            {!! $transfer->description !!}
            <img src="{{asset('/storage/' . $transfer->inner_image)}}" alt="">
            @if ($transfer->button_url)
                <div class="d-flex justify-content-center">
                    <a href="{{$transfer->button_url}}">
                        <button class="main-btn ">@lang('site.Locate the branch')</button>
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection
