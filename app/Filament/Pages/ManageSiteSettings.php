<?php

namespace App\Filament\Pages;

use App\Exports\SiteSettingsExport;
use App\Filament\Components\FileUpload;
use App\Helpers\SettingsExport;
use App\Settings\Site;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Faker\Provider\Text;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Filament\Resources\Concerns\Translatable;
use Illuminate\Contracts\Support\Htmlable;
use Maatwebsite\Excel\Excel;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ManageSiteSettings extends SettingsPage
{
    use HasPageShield;
    protected static ?string $navigationGroup = "Site Settings";

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = Site::class;

    public function getTitle(): string|Htmlable
    {
        return __("Site Settings");
    }

    public static function getNavigationLabel(): string
    {
        return __("Site Settings");
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('Export')
                ->label(__("Export"))
                ->action(function(){
                    return \Maatwebsite\Excel\Facades\Excel::download(new SiteSettingsExport, 'site-settings.xlsx');
                })

        ];
    }

    public function form(Form $form): Form
    {
        $tabs = [];
        foreach (config('app.locales') as $locale => $language){
            $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema([
                Forms\Components\Grid::make()
                    ->columns(2)
                    ->schema([
                        FileUpload::make("fav_icon")
                            ->label(__("Fav Icon"))
                            ->image()
                            ->imagePreviewHeight('100%')
                            ->imageEditor(),
                        FileUpload::make("logo.{$locale}")
                            ->label(__("Logo") . "[{$language}]")
                            ->image()
                            ->imagePreviewHeight('100%')
                            ->imageEditor(),
                    ]),
                Forms\Components\Grid::make()
                    ->columns(1)
                    ->schema([
                        Forms\Components\TextInput::make("address.{$locale}")
                            ->label(__("Address") . "[{$language}]"),
                        Forms\Components\TextInput::make("email")
                            ->label(__("Email"))
                            ->email(),
                        Forms\Components\TextInput::make("phone")
                            ->label(__("Phone")),
                        Forms\Components\TextInput::make("fax")
                            ->label(__("Fax")),
                        Forms\Components\Grid::make()
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('headquarter_longitude')
                                    ->label(__("Headquarter longitude"))
                                    ->numeric(),
                                Forms\Components\TextInput::make('headquarter_latitude')
                                    ->label(__("Headquarter Latitude"))
                                    ->numeric(),
                            ])
                    ])
            ]);
        }
        return $form
            ->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Grid::make(1)
                        ->schema([
                            Forms\Components\Tabs::make()
                                ->tabs($tabs)
                                ->columnSpan(1),
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\TextInput::make('facebook_link')
                                        ->label(__("Facebook")),
                                    Forms\Components\TextInput::make('instagram_link')
                                        ->label(__("Instagram")),
                                    Forms\Components\TextInput::make('twitter_link')
                                        ->label(__("Twitter")),
                                    Forms\Components\TextInput::make('youtube_link')
                                        ->label(__("Youtube")),
                                    Forms\Components\TextInput::make('linkedin_link')
                                        ->label(__("Linkedin")),
                                    Forms\Components\TextInput::make("whatsapp_link")
                                        ->label(__("Whatsapp")),
                                    Forms\Components\TextInput::make("app_store_link")
                                        ->label(__("App Store")),
                                    Forms\Components\TextInput::make("play_store_link")
                                        ->label(__("Play Store")),
                                    Forms\Components\TextInput::make("app_gallery_link")
                                        ->label(__("App Gallery"))
                                ])
                                ->columnSpan(1)
                                ->columns(1),
                        ])
                        ->columnSpan(1),
                    Forms\Components\Grid::make(1)
                        ->schema([
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\TextInput::make('deposits_interest_rate')
                                        ->label(__("Deposits Interest Rate"))
                                        ->numeric()
                                        ->minValue(0),
                                ]),
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\TextInput::make('chat_key')
                                        ->default(null)
                                        ->label(__("Chat Key"))
                                ]),
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\TextInput::make('captcha_site_key')
                                        ->label(__("Captcha Site Key")),
                                    Forms\Components\TextInput::make('captcha_secret_key')
                                        ->label(__("Captcha Secret Key")),
                                    Forms\Components\Checkbox::make('enable_captcha')
                                        ->label(__("Enable Captcha"))
                                ]),
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\TextInput::make("google_tag_code"),
                                    Forms\Components\TextInput::make("google_analytics_code"),
                                    Forms\Components\TextInput::make("meta_pixel_code")
                                ]),
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\TextInput::make("default_page_size")
                                        ->integer()
                                        ->minValue(1),
                                    Forms\Components\TextInput::make("news_page_size")
                                        ->integer()
                                        ->minValue(1),
                                    Forms\Components\TextInput::make("search_page_size")
                                        ->integer()
                                        ->minValue(1),
                                    Forms\Components\TextInput::make("careers_page_size")
                                        ->integer()
                                        ->minValue(1),
                                    Forms\Components\TextInput::make("financial_statements_page_size")
                                        ->integer()
                                        ->minValue(1),
                                    Forms\Components\TextInput::make("annual_general_page_size")
                                        ->integer()
                                        ->minValue(1),
                                    Forms\Components\TextInput::make("shareholders_page_size")
                                        ->integer()
                                        ->minValue(1),
                                ]),
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\TextInput::make('contact_us_mailing_list')
                                        ->regex('/.*@ashurbank\.iq$/i')
                                        ->email(),
                                    Forms\Components\TextInput::make('careers_mailing_list')
                                        ->regex('/.*@ashurbank\.iq$/i')
                                        ->email(),
//                                    Forms\Components\TextInput::make("account_appliers_mailing_list")
//                                        ->email(),
//                                    Forms\Components\TextInput::make("card_appliers_mailing_list")
//                                        ->email(),
//                                    Forms\Components\TextInput::make("finance_appliers_mailing_list")
//                                        ->email()
                                ])
                        ])
                        ->columnSpan(1)
                ])
            ]);
    }
}
