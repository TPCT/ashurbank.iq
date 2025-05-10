@extends('layouts.main')

@section('title', __('site.Shareholders'))
@section('id', 'ShareHolder')

@section('content')
    <x-layout.header-image title="{{__('site.Shareholders')}}"></x-layout.header-image>

    @if ($shareholders_first_section)
        <section class="financialInformation-1stsection">
            <div class="container">
                <img src="{{asset('/storage/' . $shareholders_first_section->image)}}" alt="" srcset="">
                <div>
                    <h2>{{$shareholders_first_section->title}}</h2>
                    {!! $shareholders_first_section->description !!}
                </div>
            </div>
        </section>
    @endif

    <form method="get" id="search-form">
        <input type="hidden" name="show_all" value="0" id="show-all"/>
    </form>

    <section id="items-section">
        <div class="container d-flex flex-column justify-content-center align-items-center">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">@lang('site.Shareholder name')</th>
                    <th scope="col">@lang('site.Number of shares owned')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($shareholders as $shareholder)
                    <tr>
                        <td>
                            <div class="ShareHolder-table-item">
                                <img src="{{asset('/storage/' . $shareholder->image)}}" alt="">
                                <div class="d-inline-block">
                                    <h5>{{$shareholder->name}}</h5>
                                    <p class="opacity-03">{{$shareholder->title}}</p>
                                </div>
                            </div>
                        </td>
                        <td><p>{{$shareholder->shares}}</p></td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            @if (!request('show_all'))
                <button id="view-all" class="secondry-btn mb-4">@lang('site.View all')</button>
            @endif
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(function(){
            $("#search-form").on('submit', function (e){
                e.preventDefault();
                $("#items-section").load('{{route('investor-relations.shareholders')}}' + "?" + $(this).serialize() + " " + "#items-section");
            });


            $("#view-all").on('click', function(){
               $("#show-all").val(1)
                $("#search-form").submit();
            });
        })

    </script>
@endpush

