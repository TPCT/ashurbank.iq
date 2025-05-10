@extends('layouts.main')

@section('title', $account->title . " " . __("site.Apply Form"))
@section('id', 'open-new-account')


@section('content')
    <x-layout.header-image last_title="{{__('site.Open New Account')}}"
                           title="{{__('site.Open New Account')}}"></x-layout.header-image>

    <section class="mt-5 container as-multi-steps-form-container">
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
                            style="--p: 64%"
                            max="100"
                            value="64"
                        ></progress
                        >
                    </label>
                    <div class="">
                        <p class="as-mobile-current-step">@lang('site.ACC_REQ_STEP_4')</p>
                        <p class="as-mobile-next-step">
                            @lang('site.Next Step'): @lang('site.ACC_REQ_STEP_5')
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
                <div class="as-single-circle-container">
                    <span class="as-circle current"> </span>
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
                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="foreign_country" class="pb-1"
                    >@lang('site.Country')
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('foreign_country') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR COUNTRY')"
                            id="foreign_country"
                            name="foreign_country"
                            value="{{old('foreign_country', $foreign_country)}}"

                        />
                        @error('foreign_country')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="foreign_city" class="pb-1"
                    >@lang('site.City')
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('foreign_city') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR CITY')"
                            id="foreign_city"
                            name="foreign_city"
                            value="{{old('foreign_city', $foreign_city)}}"

                        />
                        @error('foreign_city')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="foreign_region" class="pb-1"
                    >@lang('site.Region')
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('foreign_region') is-invalid @enderror"
                            placeholder="@lang('site.ENTER REGION')"
                            id="foreign_region"
                            name="foreign_region"
                            value="{{old('foreign_region', $foreign_region)}}"

                        />
                        @error('foreign_region')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                {{-- residence id --}}

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="foreign_street_name" class="pb-1"
                    >@lang('site.Street Name')
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('foreign_street_name') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR STREET NAME')"
                            id="foreign_street_name"
                            name="foreign_street_name"
                            value="{{old('foreign_street_name', $foreign_street_name)}}"

                        />
                        @error('foreign_street_name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="foreign_building_number" class="pb-1"
                    >@lang('site.Building/House Number')
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('foreign_building_number') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR BUILDING NUMBER')"
                            id="foreign_building_number"
                            name="foreign_building_number"
                            value="{{old('foreign_building_number', $foreign_building_number)}}"

                        />
                        @error('foreign_building_number')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="foreign_nearest_point" class="pb-1"
                    >@lang('site.The Nearest Insight')
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('foreign_nearest_point') is-invalid @enderror"
                            placeholder="@lang('site.ENTER THE NEAREST INSIGHT')"
                            id="foreign_nearest_point"
                            name="foreign_nearest_point"
                            value="{{old('foreign_nearest_point', $foreign_nearest_point)}}"

                        />
                        @error('foreign_nearest_point')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="foreign_phone_number" class="pb-1"
                    >@lang('site.Phone')
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('foreign_phone_number') is-invalid @enderror"
                            placeholder="@lang('site.ENTER THE PHONE')"
                            id="foreign_phone_number"
                            name="foreign_phone_number"
                            value="{{old('foreign_phone_number', $foreign_phone_number)}}"

                        />
                        @error('foreign_phone_number')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="foreign_mailbox" class="pb-1"
                    >@lang('site.Mail Box')
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('foreign_mailbox') is-invalid @enderror"
                            placeholder="@lang('site.ENTER THE MAILBOX')"
                            id="foreign_mailbox"
                            name="foreign_mailbox"
                            value="{{old('foreign_mailbox', $foreign_mailbox)}}"

                        />
                        @error('foreign_mailbox')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="foreign_postal_code" class="pb-1"
                    >@lang('site.Postal Code')
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('foreign_postal_code') is-invalid @enderror"
                            placeholder="@lang('site.ENTER THE POSTAL CODE')"
                            id="foreign_postal_code"
                            name="foreign_postal_code"
                            value="{{old('foreign_postal_code', $foreign_postal_code)}}"

                        />
                        @error('foreign_postal_code')
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
            window.intlTelInput($('#foreign_phone_number').get(0));
        })
    </script>
@endpush
