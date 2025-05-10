@extends('layouts.main')

@section('title', __("site.Site Map"))
@section('id', 'Site-map')

@section('content')
    <x-layout.header-image title="{{__('site.Site map')}}"></x-layout.header-image>
    @if ($menu)
        <section class="footer-container">
            <div class="container footer-section border-bottom-0">
                @foreach($menu->links as $link)
                    <div class="footer-item">
                        <div
                            class="d-flex toggleButton align-items-center justify-content-between footer-item-header"
                        >
                            <h4>{{$link['title'][$language]}}</h4>
                            <button
                                class=" mobile-responsive"
                                data-target="about"
                            >
                                <i class="fa-solid fa-plus"></i>
                                <i class="fa-solid fa-minus"></i>

                            </button>
                        </div>
                        <ul id="about">
                            @foreach($link['children'] ?? [] as $child)
                                <li>
                                    <a href="{{$child['link'][$language]}}"> {{$child['title'][$language]}} </a>
                                </li>
                                @foreach($child['children'] ?? [] as $grandson)
                                    <li>
                                        <a href="{{$grandson['link'][$language]}}" class="opacity-03"> {{$grandson['title'][$language]}} </a>
                                    </li>
                                @endforeach
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
@endsection
