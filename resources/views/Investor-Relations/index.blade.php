@extends('layouts.main')

@section('title', __('site.Investor Relations'))
@section('id', 'Retail')

@section('content')
    <x-layout.header-image title="{{__('site.Investor Relations')}}"></x-layout.header-image>
    <section>
        <div class="corporate-content container">
            <p>@lang('site.INVESTOR_RELATIONS_TITLE')</p>
            <h3>@lang('site.INVESTOR_RELATIONS_SUB_TITLE')</h3>
        </div>
    </section>
    <div class="main-sections-1 mb-5">
        @if($investor_relations_first_section)
            <section>
                <div class="container retail-container ">
                    <div class="retail-content">
                        <h3>{{$investor_relations_first_section->title}}</h3>
                        <h4>{{$investor_relations_first_section->second_title}}</h4>
                        {!! $investor_relations_first_section->description !!}
                        @if($investor_relations_first_section->buttons)
                            <a href="{{$investor_relations_first_section->buttons[0]['url'][$language]}}">
                                <button class="main-btn">{{$investor_relations_first_section->buttons[0]['text'][$language]}}</button>
                            </a>
                        @endif

                    </div>
                    <div class="img-div">
                        <img class="" src="{{asset('/storage/' . $investor_relations_first_section->image)}}" alt="" srcset="">
                    </div>
                </div>
            </section>
        @endif
        @if($investor_relations_second_section)
            <section>
                <div class="retail-container container">
                    <div class="retail-content">
                        <h3>{{$investor_relations_second_section->title}}</h3>
                        <h4>{{$investor_relations_second_section->second_title}}</h4>
                        {!! $investor_relations_second_section->description !!}
                        <a href="{{$investor_relations_second_section->buttons[0]['url'][$language]}}">
                            <button class="main-btn">{{$investor_relations_second_section->buttons[0]['text'][$language]}}</button>
                        </a>
                    </div>
                    <div class="img-div">
                        <img class="" src="{{asset('/storage/' . $investor_relations_second_section->image)}}" alt="" srcset="">
                    </div>
                </div>
            </section>
        @endif
        @if($investor_relations_third_section)
            <section>
                <div class="container retail-container ">
                    <div class="retail-content">
                        <h3>{{$investor_relations_third_section->title}}</h3>
                        <h4>{{$investor_relations_third_section->second_title}}</h4>
                        {!! $investor_relations_third_section->description !!}
                        @if($investor_relations_third_section->buttons)
                            <a href="{{$investor_relations_third_section->buttons[0]['url'][$language]}}">
                                <button class="main-btn">{{$investor_relations_third_section->buttons[0]['text'][$language]}}</button>
                            </a>
                        @endif

                    </div>
                    <div class="img-div">
                        <img class="" src="{{asset('/storage/' . $investor_relations_third_section->image)}}" alt="" srcset="">
                    </div>
                </div>
            </section>
        @endif
    </div>
@endsection
