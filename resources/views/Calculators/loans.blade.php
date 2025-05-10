@extends('layouts.main')

@section('title', __('site.Loans Calculator'))
@section('id', 'DepositCalculator')

@section('content')
    <x-layout.header-image title="{{__('site.Loans Calculator')}}"></x-layout.header-image>
    <section class="mb-5">
        <div class="container DepositCalculator-container">
            <div class="calc-form">
                <h2>@lang('site.Loans Calculator')</h2>
                <form method="post" action="{{route('calculators.loans', ['section' => $section])}}">
                    @csrf
                    <label for="loan_payment_type_id">@lang('site.Select Choice') <span>*</span></label>
                    <div class="input-group has-validation">
                        <select class="form-control @error('loan_payment_type_id') is-invalid @enderror" name="loan_payment_type_id" id="loan_payment_type_id" required>
                            @foreach($loan_payment_types as $loan_payment_type)
                                <option value="{{$loan_payment_type->id}} @selected($loan_payment_type->id == old('loan_payment_type_id'))">{{$loan_payment_type->title}}</option>
                            @endforeach
                        </select>
                        @error('loan_payment_type_id')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>


                    <label for="loan_amount">@lang('site.Loan Amount') <span>*</span></label>
                    <div class="input-number">
                        <div class="has-validation input-group">
                            <input class="form-control" type="number" name="loan_amount" id="loan_amount" placeholder="@lang('site.ENTER LOAN AMOUNT')" value="{{old('loan_amount', $loan_amount)}}" min="0" required>
                            @error('loan_amount')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="input-arrows">
                            <img src="{{asset('/images/icons/input arrow - up.png')}}" id="upArrow">
                            <img src="{{asset('/images/icons/input arrow - down.png')}}" id="downArrow">
                        </div>
                    </div>

                    <label for="currency_id">@lang('site.Currency') <span>*</span></label>
                    <div class="input-group has-validation">
                        <select class="form-control @error('currency_id') is-invalid @enderror" name="currency_id" id="currency_id" required>
                            @foreach($currencies as $currency)
                                <option value="{{$currency->id}} @selected($currency->id == old('currency_id'))">{{$currency->title}}</option>
                            @endforeach
                        </select>
                        @error('currency_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <label for="duration">@lang('site.Duration In Year') <span>*</span></label>
                    <div class="input-number">
                        <div class="has-validation input-group">
                            <input class="form-control" type="number" name="duration" id="duration" placeholder="@lang('site.ENTER YEARS DURATION')" value="{{old('duration', $duration)}}" min="0" required>
                            @error('duration')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="input-arrows">
                            <img src="{{asset('/images/icons/input arrow - up.png')}}" id="upArrow">
                            <img src="{{asset('/images/icons/input arrow - down.png')}}" id="downArrow">
                        </div>
                    </div>


                    <label for="loan_id">@lang('site.Loan Type') <span>*</span></label>
                    <div class="input-group has-validation">
                        <select class="form-control @error('loan_id') is-invalid @enderror" name="loan_id" id="loan_id" required>
                            @foreach($loans as $loan)
                                <option value="{{$loan->id}} @selected($loan->id == old('loan_id'))">{{$loan->title}}</option>
                            @endforeach
                        </select>
                        @error('loan_id')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <button class="main-btn" type="submit">@lang('site.Calculate')</button>
                </form>

            </div>
            <div class="calc-result">
                <p>@lang('site.Monthly Payment')</p>
                <h4>{{$monthly_payment}} {{$selected_currency}}</h4>
                <p>@lang('site.Total Interest Amount')</p>
                <h4>{{$total_interest_amount}} {{$selected_currency}}</h4>
            </div>
        </div>
    </section>
@endsection