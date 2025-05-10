@extends('layouts.main')

@section('title', $page->title)
@section('id', 'Fees-Charge')

@section('content')
    <x-layout.header-image title="{{$page->title}}"></x-layout.header-image>
    <section class="mb-3">
        <div id="Compliance">
            <div class="corporate-content">
                <p>{{$page->title}}</p>
                {!! $page->description !!}
            </div>
            <div class="container d-flex justify-content-center mb-5">
                {!! $page->content !!}
            </div>
        </div>
    </section>
@endsection
