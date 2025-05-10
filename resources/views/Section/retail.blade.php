@extends('layouts.main')

@section('title', __('site.Retail'))
@section('id', 'Retail')

@section('content')
    <x-layout.header-image title="{{__('site.Retail')}}"></x-layout.header-image>
    <div class="main-sections-1">
        @if($first_section)
            <section>
                <div class="container retail-container ">
                    <div class="retail-content">
                        <h3>{{{$first_section->title}}}</h3>
                        <h4>{{$first_section->second_title}}</h4>
                        {!! $first_section->description !!}
                        @if (count($first_section->buttons))
                            <a href="{{$first_section->buttons[0]['url'][$language]}}">
                                <button class="main-btn">{{$first_section->buttons[0]['text'][$language]}}</button>
                            </a>
                        @endif
                    </div>
                    <div class="img-div">
                        <img class="" src="{{asset('/storage/' . $first_section->image)}}" alt="" srcset="">
                    </div>
                </div>
            </section>
        @endif

        @if ($second_section)
                <section>
                    <div class="retail-container container">
                        <div class="retail-content">
                            <h3>{{$second_section->title}}</h3>
                            <h4>{{$second_section->second_title}}</h4>
                            {!! $second_section->description !!}
                            @if (count($second_section->buttons))
                                <a href="{{$second_section->buttons[0]['url'][$language]}}">
                                    <button class="main-btn">{{$second_section->buttons[0]['text'][$language]}}</button>
                                </a>
                            @endif
                        </div>
                        <div class="img-div">
                            <img src="{{asset('/storage/' . $second_section->image)}}" alt="" srcset="">
                        </div>
                    </div>
                </section>
        @endif

        @if ($third_section)
                <section>
                    <div class="container retail-container">
                        <div class="retail-content">
                            <h3>{{$third_section->title}}</h3>
                            <h4>{{$third_section->second_title}}</h4>
                            {!! $third_section->description !!}
                            @if (count($third_section->buttons))
                                <a href="{{$third_section->buttons[0]['url'][$language]}}">
                                    <button class="main-btn">{{$third_section->buttons[0]['text'][$language]}}</button>
                                </a>
                            @endif
                        </div>
                        <div class="img-div">
                            <img src="{{asset('/storage/' . $third_section->image)}}" alt="" srcset="">
                        </div>
                    </div>
                </section>
        @endif

        @if($fourth_section)
                <section>
                    <div class="retail-container container">
                        <div class="retail-content">
                            <h3>{{$fourth_section->title}}</h3>
                            <h4>{{$fourth_section->second_title}}</h4>
                            {!! $fourth_section->description !!}

                            @if (count($fourth_section->buttons))
                                <a href="{{$fourth_section->buttons[0]['url'][$language]}}">
                                    <button class="main-btn">{{$fourth_section->buttons[0]['text'][$language]}}</button>
                                </a>
                            @endif
                        </div>
                        <div class="img-div">
                            <img src="{{asset('/storage/' . $fourth_section->image)}}" alt="" srcset="">
                        </div>
                    </div>
                </section>
        @endif

    </div>

    @if ($fifth_section)
        <div>
            <div class="last-container" style="background-image: url('{{asset('/storage/' . $fifth_section->image)}}')">
                <h5>{{$fifth_section->title}}</h5>
                <p>{{$fifth_section->second_title}}</p>
            </div>
        </div>
    @endif
@endsection
