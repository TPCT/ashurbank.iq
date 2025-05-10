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
                            style="--p: 84%"
                            max="100"
                            value="84"
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
                <div class="as-single-circle-container">
                    <span class="as-circle current"> </span>
                    <p>@lang('site.ACC_REQ_STEP_5')</p>
                </div>
                <div class="as-single-circle-container">
                    <span class="as-circle"> </span>
                    <p>@lang('site.ACC_REQ_STEP_6')</p>
                </div>
            </div>

            <div class="row w-100 px-2 px-sm-4 px-lg-4 gy-4 gx-3 gx-xl-4">
                <div class="col-12 col-sm-6 col-lg-6 form-group">
                    <label for="labor_sector_id" class="pb-1">@lang('site.Labour Sector') <span>*</span></label>
                    <div class="has-validation input-group">
                        <select
                            id="labor_sector_id"
                            name="labor_sector_id"
                            class="form-select @error('labor_sector_id') is-invalid @enderror"
                            aria-label="branch select"
                            required
                        >
                            <option value="" disabled selected hidden>@lang('site.SELECT LABOR SECTOR')</option>
                            @foreach($labor_sectors as $labor_sector)
                                <option @selected(old('labor_sector_id', $labor_sector_id) == $labor_sector->id) value="{{$labor_sector->id}}">
                                    {{$labor_sector->title}}
                                </option>
                            @endforeach
                        </select>
                        @error('labor_sector_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-6 form-group">
                    <label for="company_name" class="pb-1"
                    >@lang('site.Employer/Company') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('area') is-invalid @enderror"
                            placeholder="@lang('site.ENTER COMPANY NAME')"
                            id="company_name"
                            name="company_name"
                            value="{{old('company_name', $company_name)}}"
                            required
                        />
                        @error('company_name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-6 form-group">
                    <label for="institution_activity" class="pb-1"
                    >@lang('site.The nature of the institution\'s activity') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('institution_activity') is-invalid @enderror"
                            placeholder="@lang('site.ENTER INSTITUTION ACTIVITY')"
                            id="institution_activity"
                            name="institution_activity"
                            value="{{old('institution_activity', $institution_activity)}}"
                            required
                        />
                        @error('institution_activity')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                {{-- residence id --}}

                <div class="col-12 col-sm-6 col-lg-6 form-group">
                    <label for="institution_nationality" class="pb-1"
                    >@lang('site.Nationality of the institution') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('institution_nationality') is-invalid @enderror"
                            placeholder="@lang('site.ENTER INSTITUTION NATIONALITY')"
                            id="institution_nationality"
                            name="institution_nationality"
                            value="{{old('institution_nationality', $institution_nationality)}}"
                            required
                        />
                        @error('institution_nationality')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="occupation" class="pb-1"
                    >@lang('site.Occupation') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('occupation') is-invalid @enderror"
                            placeholder="@lang('site.ENTER OCCUPATION')"
                            id="occupation"
                            name="occupation"
                            value="{{old('occupation', $occupation)}}"
                            required
                        />
                        @error('occupation')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="job_title" class="pb-1"
                    >@lang('site.Job title within the organization') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('job_title') is-invalid @enderror"
                            placeholder="@lang('site.ENTER JOB TITLE')"
                            id="job_title"
                            name="job_title"
                            value="{{old('job_title', $job_title)}}"
                            required
                        />
                        @error('nearest_point')
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
