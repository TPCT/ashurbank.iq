@extends('layouts.main')

@section('title', $page->title)
@section('id', 'Compliance')

@section('content')
    <x-layout.header-image title="{{$page->title}}"></x-layout.header-image>
    <section class="mb-3">
        {!! $page->content !!}
    </section>
@endsection
