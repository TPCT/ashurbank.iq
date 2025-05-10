@extends('layouts.main')

@section('title', $account->title . " " . __("site.Apply Form"))
@section('id', 'open-new-account')

@section('content')
    <x-layout.header-image last_title="{{__('site.Open New Account')}}"
                           title="{{__('site.Open New Account')}}"></x-layout.header-image>

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
                        1 @lang('site.of') 6
                        <progress
                            class="as-mobile-progress"
                            max="100"
                            value="16"
                            style="--p: 16%"
                        ></progress
                        >
                    </label>
                    <div class="">
                        <p class="as-mobile-current-step">@lang('site.ACC_REQ_STEP_1')</p>
                        <p class="as-mobile-next-step">
                            @lang('site.Next Step'): @lang('site.ACC_REQ_STEP_2')
                        </p>
                    </div>
                </div>
            </div>

            <div class="as-progress-container d-none d-lg-flex">

                <div class="as-desktop-progress" id="as-desktop-progress"></div>
                <div class="as-single-circle-container">
                    <span class="as-circle current"> </span>
                    <p>@lang('site.ACC_REQ_STEP_1')</p>
                </div>
                <div class="as-single-circle-container">
                    <span class="as-circle"> </span>
                    <p>@lang('site.ACC_REQ_STEP_2')</p>
                </div>
                <div class="as-single-circle-container">
                    <span class="as-circle"> </span>
                    <p>@lang('site.ACC_REQ_STEP_3')</p>
                </div>
                <div class="as-single-circle-container">
                    <span class="as-circle"> </span>
                    <p>
                        @lang('site.ACC_REQ_STEP_4')
                        <span>@lang('site.ACC_REQ_STEP_4_NOTE')</span>
                    </p>
                </div>
                <div class="as-single-circle-container">
                    <span class="as-circle"> </span>
                    <p>@lang('site.ACC_REQ_STEP_5')</p>
                </div>
                <div class="as-single-circle-container">
                    <span class="as-circle"> </span>
                    <p>@lang('site.ACC_REQ_STEP_6')</p>
                </div>
            </div>

            <div class="row w-100 px-2 px-sm-4 px-lg-4 gy-4 gx-3 gx-xl-4">
{{--                <div class="col-12 col-sm-6 col-lg-4 form-group">--}}
{{--                    <label for="branch_id" class="pb-1">@lang('site.Branch') <span>*</span></label>--}}
{{--                    <div class="has-validation input-group">--}}
{{--                        <select--}}
{{--                            id="branch_id"--}}
{{--                            name="branch_id"--}}
{{--                            class="form-select @error('branch_id') is-invalid @enderror"--}}
{{--                            aria-label="branch select"--}}
{{--                            required--}}
{{--                        >--}}
{{--                            <option value="" disabled selected hidden>@lang('site.SELECT BRANCH')</option>--}}
{{--                            @foreach($branches as $branch)--}}
{{--                                <option @selected(old('branch_id', $branch_id) == $branch->id) value="{{$branch->id}}">--}}
{{--                                    {{$branch->name}}--}}
{{--                                </option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                        @error('branch_id')--}}
{{--                        <div class="invalid-feedback">--}}
{{--                            {{$message}}--}}
{{--                        </div>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="account_id" class="pb-1">@lang('site.Account') <span>*</span></label>
                    <div class="has-validation input-group">
                        <select
                            id="account_id"
                            name="account_id"
                            class="form-select @error('account_id') is-invalid @enderror"
                            aria-label="account select"
                            required
                        >
                            <option value="" disabled selected hidden>@lang('site.SELECT ACCOUNT')</option>
                            @foreach($accounts as $account)
                                <option
                                    @selected(old('account_id', $account_id) == $account->id) value="{{$account->id}}">
                                    {{$account->title}}
                                </option>
                            @endforeach
                        </select>
                        @error('account_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="currency_id" class="pb-1">@lang('site.Currency') <span>*</span></label>
                    <div class="has-validation input-group">
                        <select
                            id="currency_id"
                            name="currency_id"
                            class="form-select @error('currency_id') is-invalid @enderror"
                            aria-label="currency select"
                            required
                        >
                            <option value="" disabled selected hidden>@lang('site.SELECT CURRENCY')</option>
                            @foreach($currencies as $currency)
                                <option
                                    @selected(old('currency_id', $currency_id) == $currency->id) value="{{$currency->id}}">
                                    {{$currency->title}}
                                </option>
                            @endforeach
                        </select>
                        @error('currency_id')
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
