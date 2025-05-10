@extends('layouts.main')

@section('title', __('site.Annual Generals'))
@section('id', 'AnnualGeneral')

@section('content')
    <x-layout.header-image title="{{__('site.Annual Generals')}}"></x-layout.header-image>

    @if($annual_generals_first_section)
        <section class="financialInformation-1stsection">
            <div class="container">
                <img src="{{asset('/storage/' . $annual_generals_first_section->image)}}" alt="" srcset="">
                <div>
                    <h2>{{$annual_generals_first_section->title}}</h2>
                    {!! $annual_generals_first_section->description !!}
                </div>
            </div>
        </section>
    @endif

    <form method="get" id="search-form">
        <input type="hidden" name="year" id="year"/>
        <input type="hidden" name="search" id="search"/>
    </form>

    <div class="container financialInformation-Searchbox years-filter">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="years-dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{asset('/images/icons/setting-4.png')}}" alt="" srcset="">
                <span>@lang('site.Filter by year')</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="years-dropdown">
                @foreach(\Illuminate\Support\Arr::sortDesc(range(
                        \Carbon\Carbon::parse(\App\Models\FinancialStatement::active()->pluck('published_at')->min())->year,
                        \Carbon\Carbon::today()->year)) as $year)
                    <li class="dropdown-item">{{$year}}</li>
                @endforeach
            </ul>
        </li>
        <input class="form-control me-2 search-input" type="search" placeholder="@lang('site.Search')" aria-label="Search">
        <button type="submit" class="main-btn" form="search-form">@lang('site.Search')</button>
    </div>

    <div id="items-section" class="mb-3">
        <section class="financialInformation-2ndsection">
            <div class="container ">
                @forelse ($annual_generals as $annual_general)
                    <div class="financialInformation-card">
                        <h2>{{$annual_general->title}}</h2>
                        <div>
                            <img src="{{asset('/images/icons/calendar.png')}}" alt="">
                            <p>{{\Carbon\Carbon::parse($annual_general->published_at)->format('m / Y')}}</p>
                        </div>
                        <a class="d-flex justify-content-center testing" href="{{ asset('/storage/' . $annual_general->link) }}" target="_blank" role="link">
                            <button class="secondry-btn">
                                <img src="{{ asset('/images/icons/Pdf File.png') }}" alt="" srcset="">
                                @lang('site.Download')
                            </button>
                        </a>

                    </div>
                @empty
                    <h4 class="text-danger">@lang('site.Noting Found')</h4>
                @endforelse

            </div>
        </section>
        <div class="mb-5">
            {{$annual_generals->links()}}
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function(){
            $("#search-form").on('submit', function (e){
                e.preventDefault();
                $("#items-section").load('{{route('investor-relations.annual-generals')}}' + "?" + $(this).serialize() + " " + "#items-section");
            });

            $(".search-input").on('change', function (){
                $("#search").val($(this).val())
            });

            $(".years-filter .dropdown-item").on('click', function(){
                $("#years-dropdown span").text($(this).text());
                $("#year").val($(this).text());
            });
        })

        $(document).ready(function(){
            $('.financialInformation-card a.testing').attr('target', '_blank');
        });

    </script>
@endpush

