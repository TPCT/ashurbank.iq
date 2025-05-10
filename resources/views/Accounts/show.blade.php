@extends('layouts.main')

@section('title', $account->title)
@section('id', 'CurrentAccount')

@section('content')
    <x-layout.header-image title="{{$account->title}}"></x-layout.header-image>
    <section class="main-sections-2">
        <section>
            <div class="container">
                <h2>{{$account->title}}</h2>
                {!! $account->description !!}
                <div class="opacity-07">
                    {!! $account->content !!}
                </div>
            </div>
        </section>
        <section>
            <div class="container mb-5">
                <img class="saving-img" src="{{asset('/storage/' . $account->inner_image)}}" alt="">
                <div class="saving-listed-content">
                    @if ($account->features)
                        <h2>@lang('site.Features'):</h2>
                        @foreach($account->features ?? [] as $feature)
                            <div class="saving-listed-item">
                                <div class="orange-check">
                                    <img src="{{asset('/images/icons/true white.png')}}" alt="">
                                </div>
                                <p>{{$feature['title'][$language]}}</p>
                            </div>
                        @endforeach
                    @endif

                    @if ($account->conditions)
                        <h2>@lang('site.Conditions'):</h2>
                        @foreach($account->conditions ?? [] as $condition)
                            <div class="saving-listed-item">
                                <div class="orange-check">
                                    <img src="{{asset('/images/icons/true white.png')}}" alt="">
                                </div>
                                <p>{{$condition['title'][$language]}}</p>
                            </div>
                        @endforeach
                    @endif

                    <a href="{{route('accounts.apply-step-1', ['section' => $section, 'account' => $account])}}">
                        <button class="main-btn">@lang('site.Open an account')</button>
                    </a>
                </div>
            </div>
        </section>
    </section>

@endsection
