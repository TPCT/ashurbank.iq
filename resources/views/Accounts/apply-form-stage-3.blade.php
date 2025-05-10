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
                            style="--p: 48%"
                            max="100"
                            value="48"
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
                <div class="as-single-circle-container">
                    <span class="as-circle current"> </span>
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
                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="governorate" class="pb-1"
                    >@lang('site.Governorate') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('governorate') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR GOVERNORATE')"
                            id="governorate"
                            name="governorate"
                            value="{{old('governorate', $governorate)}}"
                            required
                        />
                        @error('governorate')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="area" class="pb-1"
                    >@lang('site.Area/Neighborhood') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('area') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR AREA')"
                            id="area"
                            name="area"
                            value="{{old('area', $area)}}"
                            required
                        />
                        @error('area')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="place" class="pb-1"
                    >@lang('site.Place') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('place') is-invalid @enderror"
                            placeholder="@lang('site.ENTER PLACE')"
                            id="place"
                            name="place"
                            value="{{old('place', $place)}}"
                            required
                        />
                        @error('place')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                {{-- residence id --}}

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="alley" class="pb-1"
                    >@lang('site.The Ally') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('alley') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR ALLEY')"
                            id="alley"
                            name="alley"
                            value="{{old('alley', $alley)}}"
                            required
                        />
                        @error('alley')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="building_number" class="pb-1"
                    >@lang('site.Building/House Number') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('building_number') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR BUILDING NUMBER')"
                            id="building_number"
                            name="building_number"
                            value="{{old('building_number', $building_number)}}"
                            required
                        />
                        @error('building_number')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="nearest_point" class="pb-1"
                    >@lang('site.The Nearest Point') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('nearest_point') is-invalid @enderror"
                            placeholder="@lang('site.ENTER THE NEAREST POINT')"
                            id="nearest_point"
                            name="nearest_point"
                            value="{{old('nearest_point', $nearest_point)}}"
                            required
                        />
                        @error('nearest_point')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="accommodation_type_id" class="pb-1">@lang('site.Accommodation Type') <span>*</span></label>
                    <div class="has-validation input-group">
                        <select
                            id="accommodation_type_id"
                            name="accommodation_type_id"
                            class="form-select @error('accommodation_type_id') is-invalid @enderror"
                            aria-label="accommodation status select"
                            required
                        >
                            <option value="" disabled selected hidden>@lang('site.SELECT ACCOMMODATION TYPE')</option>
                            @foreach($accommodation_types as $accommodation_type)
                                <option
                                    @selected(old('accommodation_type_id', $accommodation_type_id) == $accommodation_type->id) value="{{$accommodation_type->id}}">
                                    {{$accommodation_type->title}}
                                </option>
                            @endforeach
                        </select>
                        @error('accommodation_type_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="phone_number_1" class="pb-1"
                    >@lang('site.Cell Phone 1') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('phone_number_1') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR CELL PHONE 1')"
                            id="phone_number_1"
                            name="phone_number_1"
                            value="{{old('phone_number_1', $phone_number_1)}}"
                            required
                        />
                        @error('phone_number_1')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="phone_number_2" class="pb-1"
                    >@lang('site.Cell Phone 2') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('phone_number_2') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOU CELL PHONE 2')"
                            id="phone_number_2"
                            name="phone_number_2"
                            value="{{old('phone_number_2', $phone_number_2)}}"
                            required
                        />
                        @error('phone_number_2')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="email" class="pb-1"
                    >@lang('site.Email') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR EMAIL')"
                            id="email"
                            name="email"
                            value="{{old('email', $email)}}"
                            required
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
            window.intlTelInput($('#phone_number_1').get(0));
            window.intlTelInput($('#phone_number_2').get(0))

        })
    </script>
@endpush
