@extends('layouts.main')

@section('title', $account->title . " " . __("site.Apply Form"))
@section('id', 'open-new-account')


@section('content')
    <x-layout.header-image last_title="{{__('site.Open New Account')}}"
                           title="{{__('site.Open New Account')}}"></x-layout.header-image>

    <section class="mt-5 container as-multi-steps-form-container">
        <form method="post" action="" class="py-5 px-2 px-md-4" enctype="multipart/form-data">
            @csrf
            <div class="d-block w-100 d-lg-none">
                <div
                    class="d-flex justify-content-center align-items-center as-mobile-custom-gap"
                >
                    <label class="as-mobile-current-progress">
                        1 @lang('site.of') 6
                        <progress
                            class="as-mobile-progress"
                            style="--p: 100%"
                            max="100"
                            value="100"
                        ></progress
                        >
                    </label>
                    <div class="">
                        <p class="as-mobile-current-step">@lang('site.ACC_REQ_STEP_3')</p>
                        <p class="as-mobile-next-step">
                            @lang('site.Next Step'): @lang('site.ACC_REQ_STEP_4')
                        </p>
                    </div>
                </div>
            </div>

            <div class="as-progress-container d-none d-lg-flex">

                <div class="as-desktop-progress" id="as-desktop-progress"></div>
                <a href="{{route('accounts.apply-step-1', ['account' => $account, 'section' => $section])}}" class="as-single-circle-container">
                    <span class="as-circle current"> </span>
                    <p>@lang('site.ACC_REQ_STEP_1')</p>
                </a>
                <a href="{{route('accounts.apply-step-2', ['account' => $account, 'section' => $section])}}" class="as-single-circle-container">
                    <span class="as-circle current"> </span>
                    <p>@lang('site.ACC_REQ_STEP_2')</p>
                </a>
                <a href="{{route('accounts.apply-step-3', ['account' => $account, 'section' => $section])}}" class="as-single-circle-container">
                    <span class="as-circle current"> </span>
                    <p>@lang('site.ACC_REQ_STEP_3')</p>
                </a>
                <a href="{{route('accounts.apply-step-4', ['account' => $account, 'section' => $section])}}" class="as-single-circle-container">
                    <span class="as-circle current"> </span>
                    <p>
                        @lang('site.ACC_REQ_STEP_4')
                        <span>@lang('site.ACC_REQ_STEP_4_NOTE')</span>
                    </p>
                </a>
                <a href="{{route('accounts.apply-step-5', ['account' => $account, 'section' => $section])}}" class="as-single-circle-container">
                    <span class="as-circle current"> </span>
                    <p>@lang('site.ACC_REQ_STEP_5')</p>
                </a>
                <div class="as-single-circle-container">
                    <span class="as-circle"> </span>
                    <p>@lang('site.ACC_REQ_STEP_6')</p>
                </div>
            </div>

            <div class="row w-100 px-2 px-sm-4 px-lg-4 gy-4 gx-3 gx-xl-4">
                <div class="col-12 w-100 px-2 px-sm-4 px-lg-3">
                    <div class="d-flex flex-column w-100">
                        <label for="document">@lang('site.Documents') <span>*</span></label>
                        <label for="document" class="as-open-new-account-documents">
                            <img src="{{asset('/images/icons/upload-document.png')}}" alt="" />
                            <span class="bold">
                                @lang('site.Drop your Documents here or click to upload')
                            </span>
                            <span class="light">@lang('site.Maximum upload size: 5MB')</span>
                        </label>
                        <div class="has-validation input-group">
                            <input class="form-control @error('document') is-invalid @enderror" type="file" name="document" hidden id="document" />
                            @error('document')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <p class="text-danger file_name" id="file_name">  </p>
                        <p class="text-danger file_size" id="file_size">  </p>
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

            <div class="d-flex px-2 px-sm-5 px-lg-5 justify-content-end w-100">
                <a href="">
                    <button type="submit">@lang('site.Submit')</button>
                </a>
            </div>
        </form>
    </section>
@endsection

@push('script')
    <script>
    </script>
@endpush
