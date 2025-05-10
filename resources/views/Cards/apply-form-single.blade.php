@extends('layouts.main')

@section('title', $card->title . ' ' . __("site.Apply Form"))
@section('id', 'credit-card-request')

@section('content')
    <x-layout.header-image last_title="{{$card->title . ' ' . __('site.Request')}}"
                           title="{{$card->title . ' ' . __('site.Request')}}"></x-layout.header-image>

    <section class="mt-5 container as-multi-steps-form-container">
        <div class="d-flex justify-content-center">
            @if($success_message = session('success'))
                <div class="my-3 alert alert-success">
                    <span class="">{{$success_message}}</span>
                </div>
            @endif
        </div>

        <form action="" class="py-5 px-2 px-md-4" method="post">
            @csrf
            <div class="as-credit-card-request-title">
                <h5 class="">@lang('site.Personal Information')</h5>
            </div>
            <div class="row w-100 px-2 px-sm-4 px-lg-4 gy-4 gx-3 gx-xl-4">
                <div class="col-12 form-group">
                    <label for="name_on_card" class="pb-1">@lang('site.Name On Card') <span>*</span> </label>
                    <div class="has-validation input-group">
                        <input
                                type="text"
                                class="form-control @error('name_on_card') is-invalid @enderror"
                                placeholder="@lang('site.ENTER NAME ON CARD')"
                                id="name_on_card"
                                name="name_on_card"
                                value="{{old('name_on_card')}}"
                                required
                        />
                        @error('name_on_card')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-6 form-group">
                    <label for="branch_id" class="pb-1">@lang('site.Branch') <span>*</span></label>
                    <div class="has-validation input-group">
                        <select
                                id="branch_id"
                                name="branch_id"
                                class="form-select @error('branch_id') is-invalid @enderror"
                                aria-label="branch select"
                                required
                        >
                            <option value="" disabled selected hidden>@lang('site.SELECT BRANCH')</option>
                            @foreach($branches as $branch)
                                <option @selected(old('branch_id') == $branch->id) value="{{$branch->id}}">
                                    {{$branch->name}}
                                </option>
                            @endforeach
                        </select>
                        @error('branch_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-6 form-group">
                    <label for="date" class="pb-1">@lang('site.Date') <span>*</span> </label>
                    <div class="has-validation input-group">
                        <input
                                type="date"
                                class="form-control @error('date') is-invalid @enderror"
                                placeholder="@lang('site.ENTER DATE')"
                                id="date"
                                name="date"
                                min="{{\Carbon\Carbon::today()->toDateString()}}"
                                value="{{old('date')}}"
                                required
                        />
                        @error('date')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-6 form-group">
                    <label for="account_number" class="pb-1">@lang('site.Customer Account Number') <span>*</span> </label>
                    <div class="has-validation input-group">
                        <input
                                type="text"
                                class="form-control @error('account_number') is-invalid @enderror"
                                placeholder="@lang('site.ENTER CUSTOMER ACCOUNT NUMBER')"
                                id="account_number"
                                name="account_number"
                                value="{{old('account_number')}}"
                                required
                        />
                        @error('account_number')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-6 form-group">
                    <label for="full_name" class="pb-1">@lang('site.Customer Full Name') <span>*</span> </label>
                    <div class="has-validation input-group">
                        <input
                                type="text"
                                class="form-control @error('full_name') is-invalid @enderror"
                                placeholder="@lang('site.ENTER CUSTOMER FULL NAME')"
                                id="full_name"
                                name="full_name"
                                value="{{old('full_name')}}"
                                required
                        />
                        @error('full_name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-6 form-group">
                    <label for="date_of_birth" class="pb-1">@lang('site.Date Of Birth') <span>*</span> </label>
                    <div class="has-validation input-group">
                        <input
                                type="date"
                                class="form-control @error('date_of_birth') is-invalid @enderror"
                                placeholder="@lang('site.ENTER DATE OF BIRTH')"
                                id="date_of_birth"
                                name="date_of_birth"
                                value="{{old('date_of_birth')}}"
                                required
                        />
                        @error('date_of_birth')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-6 form-group">
                    <label for="phone_number" class="pb-1">@lang('site.Phone Number') <span>*</span> </label>
                    <div class="has-validation input-group">
                        <input
                                type="text"
                                class="form-control @error('phone_number') is-invalid @enderror"
                                placeholder="@lang('site.ENTER PHONE NUMBER')"
                                id="phone_number"
                                name="phone_number"
                                value="{{old('phone_number')}}"
                                required
                        />
                        @error('phone_number')
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
            <div class="d-flex px-2 px-sm-5 px-lg-5 justify-content-start w-100">
                <a href="">
                    <button type="submit">@lang('site.Send')</button>
                </a>
            </div>
        </form>
    </section>
@endsection

@push('script')
    <script>
        $(function(){
            window.intlTelInput($('#phone_number').get(0));
        })
    </script>
@endpush
