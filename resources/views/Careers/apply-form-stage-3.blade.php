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
        <form method="post" action="" class="py-5 px-2 px-md-4" enctype="multipart/form-data">
            @csrf
            <div class="d-block w-100 d-lg-none">
                <div
                    class="d-flex justify-content-center align-items-center as-mobile-custom-gap"
                >
                    <label class="as-mobile-current-progress">
                        3 @lang('site.of') 3
                        <progress
                            class="as-mobile-progress"
                            max="100"
                            value="100"
                            style="--p: 100%"
                        ></progress
                        ></label>
                    <div class="">
                        <p class="as-mobile-current-step">@lang('site.EMP_REQ_STEP_3')</p>
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
                <a href="{{route('careers.apply-step-2', ['career' => $career])}}" class="as-single-circle-container">
                    <span class="as-circle current"> </span>
                    <p>@lang('site.EMP_REQ_STEP_2')</p>
                </a>
                <div class="as-single-circle-container">
                    <span class="as-circle current"> </span>
                    <p>@lang('site.EMP_REQ_STEP_3')</p>
                </div>
                {{--                <div class="as-single-circle-container">--}}
                {{--                    <span class="as-circle"> </span>--}}
                {{--                    <p>@lang('site.EMP_REQ_STEP_3')</p>--}}
                {{--                </div>--}}
            </div>

            <div class="row w-100 px-2 px-sm-4 px-lg-4 gy-4 gx-3 gx-xl-4">
                <div class="col-12 col-sm-6 form-group">
                    <label for="qualifications" class="pb-1">@lang('site.Qualifications') <span>*</span> </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('qualifications') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR QUALIFICATIONS')"
                            id="qualifications"
                            name="qualifications"
                            value="{{old('qualifications', $qualifications)}}"
                            required
                        />
                        @error('qualifications')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-sm-6 form-group">
                    <label for="specialization" class="pb-1"
                    >@lang('site.Specialization') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('specialization') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR SPECIALIZATION')"
                            id="specialization"
                            name="specialization"
                            value="{{old('specialization', $specialization)}}"
                            required
                        />
                        @error('specialization')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-sm-6 form-group">
                    <label for="scientific_expertise" class="pb-1"
                    >@lang('site.Scientific Expertise') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('scientific_expertise') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR SCIENTIFIC EXPERTISE')"
                            id="scientific_expertise"
                            name="scientific_expertise"
                            value="{{old('scientific_expertise', $scientific_expertise)}}"
                            required
                        />
                        @error('scientific_expertise')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-sm-6 form-group">
                    <label for="years_of_experience" class="pb-1"
                    >@lang('site.Years Of Experience') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('years_of_experience') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR YEARS OF EXPERIENCE')"
                            id="years_of_experience"
                            name="years_of_experience"
                            value="{{old('years_of_experience', $years_of_experience)}}"
                            required
                        />
                        @error('years_of_experience')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 w-100 px-2 px-sm-4 px-lg-3">
                    <div class="d-flex flex-column w-100">
                        <label for="document">@lang('site.CV') <span>*</span></label>
                        <label for="document" class="as-open-new-account-documents">
                            <img src="{{asset('/images/icons/upload-document.png')}}" alt="" />
                            <span class="bold">
                                @lang('site.Drop your CV here or click to upload')
                            </span>
                            <span class="light">@lang('site.Maximum upload size: 5MB')</span>
                        </label>
                        <div class="has-validation input-group">
                            <input class="form-control @error('cv') is-invalid @enderror" type="file" name="cv" hidden id="document" />
                            @error('cv')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-start">
                            <div class="my-1 alert alert-warning">
                                <p class="text-dark file_name" id="file_name">  </p>
                                <p class="text-dark file_size" id="file_size">  </p>
                            </div>
                        </div>
                    </div>
                </div>

                @if (app(\App\Settings\Site::class)->enable_captcha)
                    <div class="col-12 w-100 px-2 px-sm-4 px-lg-3">
                        <div class="form-group">
                            {!! \Anhskohbo\NoCaptcha\Facades\NoCaptcha::display() !!}
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="text-danger">
                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                @endif

            </div>

            <div class="d-flex px-2 px-sm-5 px-lg-5 justify-content-end w-100">
                <a href="">
                    <button type="submit">@lang('site.Submit')</button>
                </a>
            </div>
        </form>
    </section>
@endsection
