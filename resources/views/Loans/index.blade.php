@extends('layouts.main')

@section('title', __('site.Loans'))
@section('id', 'Loans')

@section('content')
    <x-layout.header-image title="{{__('site.Loans')}}"></x-layout.header-image>
    <div class="main-sections-1">
        @foreach($items as $item)
            <section>
                <div class="container retail-container ">
                    <div class="retail-content">
                        <h3>{{{$item->title}}}</h3>
                        <h4>{{$item->second_title}}</h4>
                        {!! $item->description !!}
                        <a href="{{route('loans.show', ['section' => $section, 'loan' => $item->slug])}}">
                            <button class="main-btn">@lang('site.Read More')</button>
                        </a>
                    </div>
                    <div class="img-div">
                        <img class="" src="{{asset('/storage/' . $item->image)}}" alt="" srcset="">
                    </div>
                </div>
            </section>
        @endforeach
    </div>

    @if ($bottom_section)
        <div>
            <div class="last-container" style="background-image: url('{{asset('/storage/' . $bottom_section->image)}}')">
                <h5>{{$bottom_section->title}}</h5>
                <p>{{$bottom_section->second_title}}</p>
            </div>
        </div>
    @endif
@endsection
