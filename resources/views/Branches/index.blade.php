@extends('layouts.main')

@section('title', __('site.Atm And Branches'))
@section('id', 'AtmsandBranches')

@section('content')
    <x-layout.header-image title="{{__('site.Atm And Branches')}}"></x-layout.header-image>

    <form method="get" id="search-form">
        <input type="hidden" name="city_id" id="city"/>
        <input type="hidden" name="is_atm" value="0" id="is_atm"/>
        <input type="hidden" name="is_branch" value="0" id="is_branch"/>
    </form>


    <section>
        <div class="container AtmsandBranches-container financialInformation-Searchbox d-flex flex-column">
            <div class="form-group">
                <label class="form-group-label">@lang('site.City')</label>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="city-dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span>@lang('site.Select City')</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="city-dropdown">
                        @foreach($cities as $city)
                            <li class="dropdown-item" data-city-id="{{$city->id}}">{{$city->title}}</li>
                        @endforeach
                    </ul>
                </li>
            </div>

            <div class="checkbox-box flex-wrap flex-column flex-md-row align-items-start">
                <p>@lang('site.Search For'):</p>
                <div>
                    <input id="branch" checked type="checkbox"><label for="branch">@lang('site.Branches')</label>
                </div>
                <div>
                    <input id="atm" checked type="checkbox" class="last-checkbox"><label for="atm">@lang('site.Atms')</label>
                </div>
            </div>
        </div>
    </section>

    <section id="items-section">
        <div class="container locations-container">
            <div class="location-result">
                <h3>@lang('site.Results')</h3>
                <h5>{{$branches_count}} @lang('site.Branches') @lang('and') {{$atms_count}} @lang('ATMs found')</h5>
                <div class="location-results">
                    @foreach($branches->get() as $branch)
                        <div  class="location-result-card">
                            <h4>{{$branch->name}}</h4>
                            <div class="location-card-content ">
                                <div class="location-card-details d-flex align-items-center gap-2">
                                    <img src="{{asset('/images/icons/location.png')}}" alt="">
                                    <p>{{$branch->address}}</p>
                                </div>
                                <button class="get-direction-button secondry-btn" data-longitude="{{$branch->longitude}}" data-latitude="{{$branch->latitude}}">
                                    @lang('site.Get Direction') <img src="{{asset('/images/icons/right arrow.png')}}" alt="">
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="location-iframe container">
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(function(){
            function getDirection(){
                $(".get-direction-button").on('click', function(){
                    const longitude = $(this).data('longitude');
                    const latitude = $(this).data('latitude');
                    const iframe = $(`<iframe src="https://maps.google.com/maps?q=${latitude},${longitude}&hl={{$language}}&z=14&amp;output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>`);
                    $('.location-iframe').empty().append(iframe);
                })
            }

            getDirection();

            $("#search-form").on('submit', function(e){
                e.preventDefault();
                $("#items-section").load('{{route('branches.index')}}' + "?" + $(this).serialize() + " " + "#items-section", function(){
                    getDirection();
                });
            })

            $(".dropdown-item").on('click', function(){
                $("#city").val($(this).data('city-id'))
                $("#city-dropdown span").text($(this).text())
                $("#search-form").submit();
            });

            $("#branch,#atm").on('click', function(){
                const branch = $("#branch");
                const atm = $("#atm");

                if (!atm.prop('checked') && !branch.prop('checked')){
                    atm.prop('checked', true);
                    branch.prop('checked', true);
                }

                const is_branch = branch.prop('checked');
                const is_atm = atm.prop('checked');

                $("#is_branch").val(is_branch && (is_branch ^ is_atm) ? 1 : 0)
                $("#is_atm").val(is_atm && (is_branch ^ is_atm) ? 1 : 0);
                $("#search-form").submit();
            });
        })
    </script>
@endpush
