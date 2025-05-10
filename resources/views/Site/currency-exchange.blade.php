@extends('layouts.main')

@section('title', 'Currency Exchange')
@section('id', 'Currency Exchange')

@section('content')
    <x-layout.header-image last_title="{{ __('site.Currency Exchanget') }}"
        title="{{ __('site.Currency Exchange') }}"></x-layout.header-image>

    <section class="mt-5 container as-multi-steps-form-container">
        <div class="d-flex justify-content-center">
            @if ($success_message = session('success'))
                <div class="my-3 alert alert-success">
                    <span class="">{{ $success_message }}</span>
                </div>
            @endif
        </div>

        <form method="post" action="" class="py-5 px-2 px-md-4">
            @csrf
            <div class="row w-100 px-2 px-sm-4 px-lg-4 gy-4 gx-3 gx-xl-4">
                <div class="col-12 col-sm-6 col-lg-4 form-group">
                    <label for="amount" class="pb-1">@lang('site.Amount') <span>*</span></label>
                    <div class="has-validation input-group">
                        <input type="number" class="form-control" placeholder="amount" id="amount"
                            name="amount" value="{{old('amount', $amount)}}" />
                        @error('amount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 form-group">
                    <label for="form-currency" class="pb-1">@lang('site.From Currency') <span>*</span></label>
                    <div class="has-validation input-group">
                        <select id="from-currency" name="from_currency"
                            class="form-select currency-from @error('from') is-invalid @enderror"
                            aria-label="@lang('site.SELECT FROM CURRENCY')">
                            <option value="" disabled selected hidden>@lang('site.SELECT FROM CURRENCY')</option>
                            @foreach ($currencies as $currency)
                                <option @if($currency->id == old('from_currency', $from_currency)) selected @endif  value="{{ $currency->id }}">
                                    {{ $currency->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('from')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-xs-12 col-sm col-lg-2 d-flex justify-content-center align-items-end">
                    <button class="main-btn w-100 currency-exchange-btn d-flex justify-content-center align-items-center"
                        id="currency-switch" type="button">
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                    </button>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 form-group">
                    <label for="to" class="pb-1">@lang('site.TO CURRENCY') <span>*</span></label>
                    <div class="has-validation input-group">
                        <select id="to-currency" name="to_currency"
                            class="form-select currency-to @error('to') is-invalid @enderror" aria-label="@lang('site.SELECT TO CURRENCY')"
                            >
                            <option value="" disabled selected hidden>@lang('site.SELECT TO CURRENCY')</option>
                            @foreach ($currencies as $currency)
                                <option @if($currency->id == old('to_currency', $to_currency)) selected @endif value="{{ $currency->id }}">
                                    {{ $currency->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('to')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                @if (app(\App\Settings\Site::class)->enable_captcha)
                    <div class="form-group mb-2">
                        {!! \Anhskohbo\NoCaptcha\Facades\NoCaptcha::display() !!}
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="text-danger">
                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                            </span>
                        @endif
                    </div>
                @endif

                @if ($from_currency && $to_currency)
                    <div class="d-flex align-items-center justify-content-start">
                        <h4 class="text-success text-align-start">{{$amount}} {{\App\Models\Currency::find($from_currency)->title}} = {{Number::format($total, 2)}} {{\App\Models\Currency::find($to_currency)->title}}</h4>
                    </div>
                @endif
            </div>

            <div class="d-flex px-2 px-sm-5 px-lg-5 justify-content-end w-100">
                <a href="">
                    <button type="submit">@lang('site.Calculate')</button>
                </a>
            </div>
        </form>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $("#currency-switch").on('click', function() {
                const from_currency_input = $(".currency-from");
                const to_currency_input = $(".currency-to");

                const to_value = to_currency_input.val();
                const from_value = from_currency_input.val()

                from_currency_input.val(to_value);
                to_currency_input.val(from_value);
            })
        });
    </script>
@endpush