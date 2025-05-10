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
                            style="--p: 32%"
                            max="100"
                            value="32"
                        ></progress
                        >
                    </label>
                    <div class="">
                        <p class="as-mobile-current-step">@lang('site.ACC_REQ_STEP_2')</p>
                        <p class="as-mobile-next-step">
                            @lang('site.Next Step'): @lang('site.ACC_REQ_STEP_3')
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
                <div class="as-single-circle-container">
                    <span class="as-circle current"> </span>
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
                <div class="col-12 col-sm-6 form-group">
                    <label for="name_ar" class="pb-1">@lang('site.Name On Card') <span>*</span> <span class="as-label-gray">(@lang('site.In Arabic'))</span> </label>
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
                    <label for="name_en" class="pb-1">@lang('site.Name On Card') <span>*</span> <span class="as-label-gray">(@lang('site.In English'))</span> </label>
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
                    <label for="document_type_id" class="pb-1"
                    >@lang('site.Document Type') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <select
                                id="document_type_id"
                                name="document_type_id"
                                class="form-select @error('document_type_id') is-invalid @enderror"
                                aria-label="document type select"
                                required
                        >
                            <option value="" disabled selected hidden>@lang('site.SELECT DOCUMENT TYPE')</option>
                            @foreach($document_types as $document_type)
                                <option
                                        @selected(old('document_type_id', $document_type_id) == $document_type->id) value="{{$document_type->id}}">
                                    {{$document_type->title}}
                                </option>
                            @endforeach
                        </select>
                        @error('document_type_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="document_number" class="pb-1"
                    >@lang('site.Document Number') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('document_number') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR DOCUMENT NUMBER')"
                            id="document_number"
                            name="document_number"
                            value="{{old('document_number', $document_number)}}"
                            required
                        />
                        @error('document_number')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="document_place_of_issue" class="pb-1"
                    >@lang('site.Place Of Issue') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('document_place_of_issue') is-invalid @enderror"
                            placeholder="@lang('site.DOCUMENT PLACE OF ISSUE')"
                            id="document_place_of_issue"
                            name="document_place_of_issue"
                            value="{{old('document_place_of_issue', $document_place_of_issue)}}"
                            required
                        />
                        @error('document_place_of_issue')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="document_release_date" class="pb-1"
                    >@lang('site.Release Date') <span>*</span>
                    </label>
                    <div class="has-validation input-group">
                        <input
                            type="date"
                            class="form-control @error('document_release_date') is-invalid @enderror"
                            placeholder="@lang('site.DOCUMENT RELEASE DATE')"
                            id="document_release_date"
                            name="document_release_date"
                            value="{{old('document_release_date', $document_release_date)}}"
                            required
                        />
                        @error('document_release_date')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 form-group"></div>


                <div class="col-12 col-sm-6 form-group">
                    <label for="scientific_status_id" class="pb-1">@lang('site.Scientific Status') <span>*</span></label>
                    <div class="has-validation input-group">
                        <select
                                id="scientific_status_id"
                                name="scientific_status_id"
                                class="form-select @error('scientific_status_id') is-invalid @enderror"
                                aria-label="scientific status select"
                                required
                        >
                            <option value="" disabled selected hidden>@lang('site.SELECT SCIENTIFIC STATUS')</option>
                            @foreach($scientific_statuses as $scientific_status)
                                <option
                                        @selected(old('scientific_status_id', $scientific_status_id) == $scientific_status->id) value="{{$scientific_status->id}}">
                                    {{$scientific_status->title}}
                                </option>
                            @endforeach
                        </select>
                        @error('scientific_status_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 form-group">
                    <label for="mother_name" class="pb-1">@lang('site.Mother\'s Full Name') <span>*</span></label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('mother_name') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR MOTHER\' FULL NAME')"
                            id="mother_name"
                            name="mother_name"
                            value="{{old('mother_name', $mother_name)}}"
                            required
                        />
                        @error('mother_name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-6 form-group">
                    <label for="martial_status_id" class="pb-1">@lang('site.Martial Status') <span>*</span></label>
                    <div class="has-validation input-group">
                        <select
                                id="martial_status_id"
                                name="martial_status_id"
                                class="form-select @error('martial_status_id') is-invalid @enderror"
                                aria-label="martial status select"
                                required
                        >
                            <option value="" disabled selected hidden>@lang('site.SELECT MARTIAL STATUS')</option>
                            @foreach($martial_statuses as $martial_status)
                                <option data-has-partner="{{$martial_status->validations['has_partner'] ?? 0 }}"
                                        @selected(old('martial_status_id', $martial_status_id) == $martial_status->id) value="{{$martial_status->id}}">
                                    {{$martial_status->title}}
                                </option>
                            @endforeach
                        </select>
                        @error('martial_status_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-6 form-group">
                    <label for="partner_name" class="pb-1">@lang('site.Partner Name')  <span class="has-partner">*</span></label>
                    <div class="has-validation input-group">
                        <input
                            type="text"
                            class="form-control @error('partner_name') is-invalid @enderror"
                            placeholder="@lang('site.ENTER YOUR PARTNER NAME')"
                            id="partner_name"
                            name="partner_name"
                            value="{{old('partner_name', $partner_name)}}"
                        />
                        @error('partner_name')
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
        $("#martial_status_id").on('change', function (){
            if ($(this).find(":selected").data('has-partner') === 1)
                $(".has-partner").show();
            else
                $(".has-partner").hide();
        });
    </script>
@endpush