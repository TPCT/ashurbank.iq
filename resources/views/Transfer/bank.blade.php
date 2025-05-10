@extends('layouts.main')

@section('title', $transfer->title)
@section('id', 'BankTransfer')

@section('content')
    <x-layout.header-image title="{{$transfer->title}}"></x-layout.header-image>
    <div class="main-sections-2">
        <section>
            <div class="container">
                <h2>{{$transfer->title}}</h2>
                {!! $transfer->description !!}
            </div>
        </section>

        <section>
            <div class="container mb-5">
                <img class="saving-img" src="{{asset('/storage/' . $transfer->inner_image)}}" alt="">
                <div class="saving-listed-content">
                    <h2>@lang('site.Features of bank transfer'):</h2>
                    <div class="saving-listed-item">
                        <ul>
                        @foreach($transfer->features ?? [] as $feature)
                            <li>{{$feature['title'][$language]}}</li>
                        @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection
