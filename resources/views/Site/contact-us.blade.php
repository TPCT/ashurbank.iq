@extends('layouts.main')

@section('title', __('site.Contact Us'))
@section('id', 'Contact-us')

@section('content')
    <x-layout.header-image title="{{__('site.Contact Us')}}"></x-layout.header-image>

    <section>
        <div class="container DepositCalculator-container mb-5">
            <div class="calc-form">
                <h2>@lang('site.CONTACT_US_TITLE')</h2>
                <p class="">@lang('site.CONTACT_US_BRIEF')</p>

                @if($success_message = session('success'))
                    <div class="my-3 alert alert-success">
                        <span class="">{{$success_message}}</span>
                    </div>
                @endif

                <form method="post" >
                    @csrf
                    <div class="form-group mb-2">
                        <label for="name">@lang('site.Name') <span>*</span></label>
                        <div class="input-group has-validation">
                            <input class="form-control m-0 @error('name') is-invalid @enderror" value="{{old('name')}}" type="text" name="name" id="name" placeholder="@lang('site.Enter Your Name')">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="email">@lang('site.Email') <span>*</span></label>
                        <div class="input-group has-validation">
                            <input class="form-control m-0 @error('email') is-invalid @enderror" value="{{old('email')}}" type="email" name="email" id="email" placeholder="@lang('site.Enter Your Email')">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="subject">@lang('site.Subject') <span>*</span></label>
                        <div class="input-group has-validation">
                            <input class="form-control m-0 @error('subject') is-invalid @enderror" value="{{old('subject')}}" type="text" name="subject" id="subject" placeholder="@lang('site.Enter Message\'s Subject')">
                            @error('subject')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="message">@lang('site.Message') <span>*</span></label>
                        <div class="input-group has-validation">
                            <textarea placeholder="@lang('site.Enter Your Message')" class="form-control m-0 @error('message') is-invalid @enderror" name="message" id="message" cols="30" rows="5">{{old('message', '')}}</textarea>
                            @error('message')
                                <div class="invalid-feedback">
                                    {{$message}}
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

                    <button class="main-btn" type="submit">@lang('site.Send')</button>

                    <div class="contact-items">
                        <div class="contact-item">
                            <img src="{{asset('/images/icons/sms black.png')}}" alt="" srcset="">
                            <a href="mailto:{{app(\App\Settings\Site::class)->email}}">
                                <div class="contact-content">
                                    <p>@lang('site.E-mail')</p>
                                    <span>{{app(\App\Settings\Site::class)->email}}</span>
                                </div>
                            </a>
                        </div>
                        <div class="contact-item">
                            <img class="phone-icon" src="{{asset('/images/icons/call black.png')}}" alt="" srcset="">
                            <a href="tel:{{app(\App\Settings\Site::class)->phone}}">
                                <div class="contact-content">
                                    <p>@lang('site.phone')</p>
                                    <span>{{app(\App\Settings\Site::class)->phone}}</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </form>

            </div>
            <div class="ContactUS-map">
                <iframe src="https://maps.google.com/maps?q={{app(\App\Settings\Site::class)->headquarter_latitude}},{{app(\App\Settings\Site::class)->headquarter_longitude}}&hl=es&z=14&amp;output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
@endsection
