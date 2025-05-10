@extends('layouts.main')

@section('title', $loan->title . " " . __("site.Apply Form"))
@section('id', 'employment-request')

@section('content')
    <x-layout.header-image last_title="{{__('site.Loan Request')}}" title="{{__('site.Loan Request')}}"></x-layout.header-image>

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
                        <p class="as-mobile-current-step">@lang('site.LOAN_REQ_STEP_2')</p>
                        <p class="as-mobile-next-step">
                            @lang('site.Next Step'): @lang('site.LOAN_REQ_STEP_3')
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="as-progress-container employment-request d-none d-lg-flex"
            >
                <div class="as-desktop-progress" id="as-desktop-progress"></div>
                <a href="{{route('loans.apply-step-1', ['section' => $section, 'loan' => $loan])}}" class="as-single-circle-container">
                    <span class="as-circle current"> </span>
                    <p>@lang('site.LOAN_REQ_STEP_1')</p>
                </a>
                <div class="as-single-circle-container">
                    <span class="as-circle current"> </span>
                    <p>@lang('site.LOAN_REQ_STEP_2')</p>
                </div>
                <div class="as-single-circle-container">
                    <span class="as-circle"> </span>
                    <p>@lang('site.LOAN_REQ_STEP_3')</p>
                </div>
            </div>

            <div class="row w-100 px-2 px-sm-4 px-lg-4 gy-4 gx-3 gx-xl-4">
                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="workplace" class="pb-1">@lang('site.Workplace') <span>*</span> </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('workplace') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR WORKPLACE')"
                            id="workplace"
                            name="workplace"
                            value="{{old('workplace', $workplace)}}"
                            required
                        />
                        @error('workplace')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="current_position" class="pb-1"
                    >@lang('site.Current Position') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('current_position') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR CURRENT POSITION')"
                            id="current_position"
                            name="current_position"
                            value="{{old('current_position', $current_position)}}"
                            required
                        />
                        @error('current_position')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="work_start_date" class="pb-1"
                    >@lang('site.Work Start Date') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('work_start_date') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR WORK START DATE')"
                            id="work_start_date"
                            name="work_start_date"
                            value="{{old('work_start_date', $work_start_date)}}"
                            required
                        />
                        @error('work_start_date')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="monthly_salary" class="pb-1"
                    >@lang('site.Monthly Salary') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('monthly_salary') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR MONTHLY SALARY')"
                            id="monthly_salary"
                            name="monthly_salary"
                            value="{{old('monthly_salary', $monthly_salary)}}"
                            required
                        />
                        @error('monthly_salary')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="extra_work" class="pb-1"
                    >@lang('site.Extra Work') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('extra_work') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR EXTRA WORK')"
                            id="extra_work"
                            name="extra_work"
                            value="{{old('extra_work', $extra_work)}}"
                            required
                        />
                        @error('extra_work')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="other_sources_of_income" class="pb-1"
                    >@lang('site.Other Sources Of Income') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('other_sources_of_income') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR EXTRA WORK')"
                            id="other_sources_of_income"
                            name="other_sources_of_income"
                            value="{{old('other_sources_of_income', $other_sources_of_income)}}"
                            required
                        />
                        @error('other_sources_of_income')
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
    <script>

    </script>
@endsection
