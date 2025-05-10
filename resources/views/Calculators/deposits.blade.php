@extends('layouts.main')

@section('title', __('site.Deposits Calculator'))
@section('id', 'DepositCalculator')

@section('content')
    <x-layout.header-image title="{{__('site.Deposits Calculator')}}"></x-layout.header-image>
    <section class="mb-5">
        <div class="container DepositCalculator-container">
            <div class="calc-form">
                <h2>@lang('site.Deposit Calculator')</h2>
                <form method="post" action="">
                    @csrf
                    <label for="deposit_amount">@lang('site.Deposits Amount') <span>*</span></label>
                    <div class="input-number">
                        <div class="has-validation">
                            <input class="form-control" type="number" name="deposit_amount" id="deposit_amount" placeholder="@lang('site.ENTER DEPOSIT AMOUNT')" value="{{old('deposit_amount', $deposit_amount)}}" min="0" required>
                            @error('deposit_amount')
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
                    <label for="start_date">@lang('site.Deposit Start Date') <span>*</span></label>
                    <div class="has-validation input-group">
                        <input class="form-control @error('start_date') is-invalid @enderror" type="date" name="start_date" id="start_date" value="{{old('start_date', $start_date)}}" required>
                        @error('start_date')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <label for="end_date">@lang('site.Deposit End Date') <span>*</span></label>
                    <div class="has-validation input-group">
                        <input class="form-control @error('end_date') is-invalid @enderror" type="date" name="end_date" id="end_date" value="{{old('end_date', $end_date)}}" required>
                        @error('end_date')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <button class="main-btn">@lang('site.Calculate')</button>
                </form>

            </div>
            <div class="calc-result">
                <h2>@lang('site.Final Amount')</h2>
                <h4>{{$final_amount}} {{$selected_currency}}</h4>
                <p>@lang('site.Deposits Amount')</p>
                <h4>{{$deposit_amount}} {{$selected_currency}}</h4>
                <p>@lang('site.Interest Value')</p>
                <h4>{{$interest_rate}} {{$selected_currency}}</h4>
                <p>@lang('site.Interest Amount')</p>
                <h4>{{$interest_amount}} {{$selected_currency}}</h4>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(function(){
            $(".input-number #upArrow").on('click', function(){
                let input = $(this).parent().parent().find('input');
                input.val(parseInt(input.val()) + 1);
            });
            $(".input-number #downArrow").on('click', function(){
                let input = $(this).parent().parent().find('input');
                if (parseInt(input.val()) - 1 >= 0)
                    input.val(parseInt(input.val()) - 1)
                else
                    input.val(0)
            });
        })
    </script>
@endpush