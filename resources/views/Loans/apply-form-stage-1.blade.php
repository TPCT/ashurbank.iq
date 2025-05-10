@extends('layouts.main')

@section('title', $loan->title . " " . __("site.Apply Form"))
@section('id', 'employment-request')

@section('content')
    <x-layout.header-image last_title="{{__('site.Loan Request')}}" title="{{__('site.Loan Request')}}"></x-layout.header-image>

    <section class="mt-5 container as-multi-steps-form-container">
        <div class="d-flex justify-content-center">
            @if($success_message = session('success'))
                <div class="my-3 alert alert-success">
                    <span class="">{{$success_message}}</span>
                </div>
            @endif
        </div>

        <form method="post" action="" class="py-5 px-2 px-md-4">
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
                        <p class="as-mobile-current-step">@lang('site.LOAN_REQ_STEP_1')</p>
                        <p class="as-mobile-next-step">
                            @lang('site.Next Step'): @lang('site.LOAN_REQ_STEP_2')
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
                    <p>@lang('site.LOAN_REQ_STEP_1')</p>
                </div>
                <div class="as-single-circle-container">
                    <span class="as-circle"> </span>
                    <p>@lang('site.LOAN_REQ_STEP_2')</p>
                </div>
                <div class="as-single-circle-container">
                    <span class="as-circle"> </span>
                    <p>@lang('site.LOAN_REQ_STEP_3')</p>
                </div>
            </div>

            <div class="row w-100 px-2 px-sm-4 px-lg-4 gy-4 gx-3 gx-xl-4">
                <div class="col-12 col-sm-6 form-group">
                    <label for="name_ar" class="pb-1">@lang('site.Full Name') <span>*</span> <span class="as-label-gray">(@lang('site.In Arabic'))</span> </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('name_ar') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR NAME IN ARABIC')"
                            id="name_ar"
                            name="name_ar"
                            value="{{old('name_ar', $name_ar)}}"
                            required
                        />
                        @error('name_ar')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 form-group">
                    <label for="name_en" class="pb-1">@lang('site.Full Name') <span>*</span> <span class="as-label-gray">(@lang('site.In English'))</span> </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('name_en') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR NAME IN ENGLISH')"
                            id="name_en"
                            name="name_en"
                            value="{{old('name_en', $name_en)}}"
                            required
                        />
                        @error('name_en')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="nationality" class="pb-1"
                    >@lang('site.Nationality') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('nationality') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR NATIONALITY')"
                            id="nationality"
                            name="nationality"
                            value="{{old('nationality', $nationality)}}"
                            required
                        />
                        @error('nationality')
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
                    <label for="address" class="pb-1"
                    >@lang('site.Address') <span>*</span>
                    </label>
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


                <div class="col-12 col-sm-6 col-lg-4 d-flex flex-column form-group">
                    <label for="phone_number" class="pb-1"
                    >@lang('site.Phone Number') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            required
                            class="form-control"
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

                <div class="col-12 col-sm-6 col-lg-4 d-flex flex-column form-group">
                    <label for="preferred_method_of_communication" class="pb-1"
                    >@lang('site.Preferred Method Of Communication') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            required
                            class="form-control @error('preferred_method_of_communication') is-invalid @enderror"
                            placeholder="@lang('site.Enter Preferred Method Of Communication')"
                            id="preferred_method_of_communication"
                            name="preferred_method_of_communication"
                            value="{{old('preferred_method_of_communication', $preferred_method_of_communication)}}"
                        />
                        @error('preferred_method_of_communication')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 d-flex flex-column form-group">
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
