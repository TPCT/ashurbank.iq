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
        <div class="d-flex justify-content-center">
            @if($success_message = session('success'))
                <div class="my-3 alert alert-success">
                    <span class="">{{$success_message}}</span>
                </div>
            @endif
        </div>

        <form method="post" action="" class="py-5 px-2 px-md-4 careers-first-form">
            @csrf
            <div class="d-block w-100 d-lg-none">
                <div
                    class="d-flex justify-content-center align-items-center as-mobile-custom-gap"
                >
                    <label class="as-mobile-current-progress">
                        1 @lang('site.of') 3
                        <progress
                            class="as-mobile-progress"
                            max="100"
                            value="33"
                            style="--p: 33%"
                        ></progress
                        ></label>
                    <div class="">
                        <p class="as-mobile-current-step">@lang('site.EMP_REQ_STEP_1')</p>
                        <p class="as-mobile-next-step">
                            @lang('site.Next Step'): @lang('site.EMP_REQ_STEP_2')
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="as-progress-container employment-request d-none d-lg-flex"
            >
                <div class="as-desktop-progress" id="as-desktop-progress"></div>
                    <div class="as-single-circle-container">
                        <span class="as-circle current"> </span>
                        <p>@lang('site.EMP_REQ_STEP_1')</p>
                    </div>
                    <div class="as-single-circle-container">
                        <span class="as-circle"> </span>
                        <p>@lang('site.EMP_REQ_STEP_2')</p>
                    </div>
                    <div class="as-single-circle-container">
                        <span class="as-circle"> </span>
                        <p>@lang('site.EMP_REQ_STEP_3')</p>
                    </div>
{{--                    <div class="as-single-circle-container">--}}
{{--                        <span class="as-circle"> </span>--}}
{{--                        <p>@lang('site.EMP_REQ_STEP_3')</p>--}}
{{--                    </div>--}}
                </div>

            <div class="row w-100 px-2 px-sm-4 px-lg-4 gy-4 gx-3 gx-xl-4">
                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="name" class="pb-1">@lang('site.Name') <span>*</span> </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR NAME')"
                            id="name"
                            name="name"
                            value="{{old('name', $name)}}"
                            required
                        />
                        @error('name')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="place_date_of_birth" class="pb-1"
                    >@lang('site.Place/Date of birth') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('place_date_of_birth') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR PLACE/DATE OF BIRTH')"
                            id="place_date_of_birth"
                            name="place_date_of_birth"
                            value="{{old('place_date_of_birth', $place_date_of_birth)}}"
                            required
                        />
                        @error('place_date_of_birth')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="gender" class="pb-1">@lang('site.Gender') <span>*</span></label>
                    <div class="has-validation input-group">
                        <select
                            id="gender"
                            name="gender"
                            class="form-select @error('gender') is-invalid @enderror"
                            aria-label="gender select"
                            required
                        >
                            <option value="" disabled selected hidden>@lang('site.SELECT GENDER')</option>
                            <option @selected(old('gender', $gender) == "male") value="male">@lang('site.Male')</option>
                            <option @selected(old('gender', $gender) == "female") value="female">@lang('site.Female')</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 d-flex flex-column form-group">
                    <label for="phone_number" class="pb-1"
                    >@lang('site.Phone Number') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            required
                            class="form-control @error('phone_number') is-invalid @enderror"
                            placeholder="@lang('site.Enter Phone Number')"
                            id="phone_number"
                            name="phone_number"
                            value="{{old('phone_number', $phone_number)}}"
                        />
                        @error('phone_number')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 form-group">
                    <label for="email" class="pb-1"
                    >@lang('site.Email') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="email"
                            required
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="@lang('site.Enter Email')"
                            id="email"
                            name="email"
                            value="{{old('email', $email)}}"
                        />
                        @error('email')
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

@push('script')
    <script>
        $(function(){
            window.intlTelInput($('#phone_number').get(0))
        })
    </script>
@endpush
