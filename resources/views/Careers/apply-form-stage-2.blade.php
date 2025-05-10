@extends('layouts.main')

@section('title', $career->title . " " . __("site.Apply Form"))
@section('id', 'employment-request')

@section('content')
    <x-layout.header-image last_title="{{__('site.Employment Request')}}" title="{{__('site.Employment Request')}}"></x-layout.header-image>

    <div class="as-employment-request-header-warning w-100">
        <div class="container flex-column flex-sm-row d-flex align-items-center w-100">
            <img src="{{asset('/images/icons/warning.png')}}" alt="" />
            <p>
                @lang('site.EMPLOYMENT_REQUEST_WARNING')
            </p>
        </div>
    </div>


    <section class="mt-5 container as-multi-steps-form-container">
        <form method="post" action="" class="py-5 px-2 px-md-4">
            @csrf
            <div class="d-block w-100 d-lg-none">
                <div
                    class="d-flex justify-content-center align-items-center as-mobile-custom-gap"
                >
                    <label class="as-mobile-current-progress">
                        2 @lang('site.of') 3
                        <progress
                            class="as-mobile-progress"
                            max="100"
                            value="66"
                            style="--p: 66%"
                        ></progress
                        ></label>
                    <div class="">
                        <p class="as-mobile-current-step">@lang('site.EMP_REQ_STEP_2')</p>
                        <p class="as-mobile-next-step">
                            @lang('site.Next Step'): @lang('site.EMP_REQ_STEP_3')
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="as-progress-container employment-request d-none d-lg-flex"
            >
                <div class="as-desktop-progress" id="as-desktop-progress"></div>
                <a href="{{route('careers.apply-step-1', ['career' => $career])}}" class="as-single-circle-container">
                    <span class="as-circle current"> </span>
                    <p>@lang('site.EMP_REQ_STEP_1')</p>
                </a>
                <div class="as-single-circle-container">
                    <span class="as-circle current"> </span>
                    <p>@lang('site.EMP_REQ_STEP_2')</p>
                </div>
                <div class="as-single-circle-container">
                    <span class="as-circle"> </span>
                    <p>@lang('site.EMP_REQ_STEP_3')</p>
                </div>
{{--                <div class="as-single-circle-container">--}}
{{--                    <span class="as-circle"> </span>--}}
{{--                    <p>@lang('site.EMP_REQ_STEP_3')</p>--}}
{{--                </div>--}}
            </div>

            <div class="row w-100 px-2 px-sm-4 px-lg-4 gy-4 gx-3 gx-xl-4">
                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="address" class="pb-1">@lang('site.Address') <span>*</span> </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('address') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR ADDRESS')"
                            id="address"
                            name="address"
                            value="{{old('address', $address)}}"
                            required
                        />
                        @error('address')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="country" class="pb-1"
                    >@lang('site.Country') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('country') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR COUNTRY')"
                            id="country"
                            name="country"
                            value="{{old('country', $country)}}"
                            required
                        />
                        @error('country')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="city" class="pb-1"
                    >@lang('site.City') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('city') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR CITY')"
                            id="city"
                            name="city"
                            value="{{old('city', $city)}}"
                            required
                        />
                        @error('city')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="d-flex px-2 px-sm-5 px-lg-5 justify-content-end w-100">
                <a href="">
                    <button type="submit">@lang('site.Next')</button>
                </a>
            </div>
        </form>
    </section>
@endsection
