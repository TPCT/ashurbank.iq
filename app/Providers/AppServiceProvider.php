<?php

namespace App\Providers;

use App\Models\Language;
use App\Settings\General;
use App\Settings\Site;
use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use Carbon\Carbon;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        FilamentShield::configurePermissionIdentifierUsing(function ($resource){
            return Str::of($resource)
                   ->afterLast('\\')
                    ->before('Resource')
                    ->snake()
                    ->replace('_', '-')
                    ->toString();
        });

        \Config::set('app.timezone', app(General::class)->site_timezone);
        \Config::set('captcha.secret', app(Site::class)->captcha_secret_key);
        \Config::set('captcha.sitekey', app(Site::class)->captcha_site_key);
        \Config::set('app.name', app(General::class)->site_title[config('app.locale')] ?? config('app.name'));

        if (app(General::class)->default_locale)
            \Config::set('app.locale', app(General::class)->default_locale);

        if (Language::count()){
            \Config::set('app.locales', \Arr::mapWithKeys(Language::get()->toArray(), function ($value){
                return [$value['locale'] => $value['language']];
            }));

            \Config::set('app.locales_images', \Arr::mapWithKeys(Language::get()->toArray(), function ($value){
                return [$value['locale'] => asset('/storage/' . $value['image'])];
            }));
        }

        \Config::set('mail.mailers.smtp.host', app(General::class)->smtp_host);
        \Config::set('mail.mailers.smtp.port', app(General::class)->smtp_port);
        \Config::set('mail.mailers.smtp.username', app(General::class)->smtp_user);
        \Config::set('mail.mailers.smtp.password', app(General::class)->smtp_pass);
        \Config::set('mail.mailers.smtp.encryption', 'tls');
        \Config::set('mail.from.address', app(General::class)->smtp_from_address);
        \Config::set('mail.from.name', app(General::class)->smtp_from_name);

    }
}

