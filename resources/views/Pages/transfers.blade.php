@extends('layouts.main')

@section('title', $page->title)
@section('id', 'BankTransfer')

@section('content')
    <x-layout.header-image title="{{$page->title}}"></x-layout.header-image>
    <div class="main-sections-2 mb-3">
        <section>
            <div class="container">
                <h2>{{$page->title}}</h2>
                {!! $page->description !!}
            </div>
        </section>
        <section>
            {!! $page->content !!}
        </section>
    </div>

@endsection
