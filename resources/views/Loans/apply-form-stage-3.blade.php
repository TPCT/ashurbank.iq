@extends('layouts.main')

@section('title', $loan->title . " " . __("site.Apply Form"))
@section('id', 'employment-request')

@section('content')
    <x-layout.header-image last_title="{{__('site.Loan Request')}}" title="{{__('site.Loan Request')}}"></x-layout.header-image>

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
                        <p class="as-mobile-current-step">@lang('site.LOAN_REQ_STEP_3')</p>
                    </div>
                </div>
            </div>

            <div
                class="as-progress-container employment-request d-none d-lg-flex"
            >
                <div class="as-desktop-progress" id="as-desktop-progress"></div>
                <a href="{{route('loans.apply-step-1', ['loan' => $loan, 'section' => $section])}}" class="as-single-circle-container">
                    <span class="as-circle current"> </span>
                    <p>@lang('site.LOAN_REQ_STEP_1')</p>
                </a>
                <a href="{{route('loans.apply-step-1', ['loan' => $loan, 'section' => $section])}}" class="as-single-circle-container">
                    <span class="as-circle current"> </span>
                    <p>@lang('site.LOAN_REQ_STEP_2')</p>
                </a>
                <div class="as-single-circle-container">
                    <span class="as-circle current"> </span>
                    <p>@lang('site.LOAN_REQ_STEP_3')</p>
                </div>
            </div>

            <div class="row w-100 px-2 px-sm-4 px-lg-4 gy-4 gx-3 gx-xl-4">
                <div class="col-12 col-sm-6 form-group">
                    <label for="loan_amount" class="pb-1">@lang('site.The Amount Of The Requests Loan') <span>*</span> </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('loan_amount') is-invalid @enderror"
                            placeholder="@lang('site.ENTER LOAN AMOUNT')"
                            id="loan_amount"
                            name="loan_amount"
                            value="{{old('loan_amount', $loan_amount)}}"
                            required
                        />
                        @error('loan_amount')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-sm-6 form-group">
                    <label for="payment_period" class="pb-1"
                    >@lang('site.Required Payment Period') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('payment_period') is-invalid @enderror"
                            placeholder="@lang('site.ENTER PAYMENT PERIOD')"
                            id="payment_period"
                            name="payment_period"
                            value="{{old('payment_period', $payment_period)}}"
                            required
                        />
                        @error('payment_period')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
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
