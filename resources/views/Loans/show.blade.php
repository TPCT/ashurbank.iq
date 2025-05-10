@extends('layouts.main')

@section('title', $loan->title)
@section('id', 'SMLoans')

@section('content')
    <x-layout.header-image title="{{$loan->title}}"></x-layout.header-image>
    <section class="mb-3">
        <div class="container Loans-subs">
            <h2>{{$loan->title}}</h2>
            {!! $loan->content !!}
            <img src="{{asset('/storage/' . $loan->inner_image)}}" alt="">
        </div>
    </section>
@endsection
