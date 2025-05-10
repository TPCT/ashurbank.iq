<?php

namespace App\Filament\Pages;

use App\Exports\GeneralSettingsExport;
use App\Exports\SiteSettingsExport;
use App\Filament\Components\FileUpload;
use App\Helpers\Utilities;
use App\Models\Language;
use App\Settings\General;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\SettingsPage;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Arr;
use Matrix\Exception;
use Nette\Utils\Arrays;

class ManageGeneralSettings extends SettingsPage
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = "Site Settings";

    public function getHeaderActions(): array
    {
        return [
            Action::make('Export')
                ->label(__("Export"))
                ->action(function(){
                    return \Maatwebsite\Excel\Facades\Excel::download(new GeneralSettingsExport(), 'general-settings.xlsx');
                })

        ];
    }
    public function getTitle(): string|Htmlable
    {
        return __("General Settings");
    }

    public static function getNavigationLabel(): string
    {
        return __("General Settings");
    }



    protected static string $settings = General::class;

    public function form(Form $form): Form
    {
        $tabs = [];
        foreach (config('app.locales') as $locale => $language){
            $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema([
                Forms\Components\Grid::make()
                    ->columns(1)
                    ->schema([
                        Forms\Components\TextInput::make("site_title.{$locale}")
                            ->label(__("Site Title") . "[{$language}]")
                            ->required(),
                        Forms\Components\TextInput::make("site_description.{$locale}")
                            ->label(__("Site Description") . "[{$language}]"),
                        Forms\Components\TextInput::make("site_admin_email")
                            ->label(__("Admin Email"))
                            ->email(),
                        Forms\Components\Select::make("site_country")
                            ->label(__("Country"))
                            ->native(false)
                            ->preload()
                            ->searchable()
                            ->options(Arr::keyBy(\Countries::getList(), function($value){
                                return $value;
                            })),
                        Forms\Components\Select::make("site_timezone")
                            ->label(__("Timezone"))
                            ->native(false)
                            ->preload()
                            ->searchable()
                            ->options(Arr::keyBy(General::getTimezones(), function($value){
                                return $value;
                            }))
                            ->default("Asia/Amman"),
                    ])
            ]);
        }
        return $form
            ->schema([
                Forms\Components\Grid::make()->schema([
                    Forms\Components\Tabs::make()->tabs($tabs)->columnSpan(1),
                    Forms\Components\Section::make()->schema([
                        Forms\Components\Select::make('default_locale')
                            ->default(Language::first() ?? config('app.locale'))
                            ->native(false)
                            ->options(function(){
                                return Arr::mapWithKeys(Language::get(['locale', 'language'])->toArray(), function ($value){
                                    return [$value['locale'] => $value['locale']];
                                });
                            }),
                        Forms\Components\Repeater::make('languages')
                            ->label(__("Languages"))
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        FileUpload::make('image')
                                                ->image()
                                                ->multiple(false)
                                                ->columnSpanFull(),
                                        Forms\Components\TextInput::make('locale')
                                            ->unique(ignoreRecord: true)
                                            ->label(__("Locale"))
                                            ->required(),
                                        TextInput::make('language')
                                            ->label(__("Language"))
                                            ->unique(ignoreRecord: true)
                                            ->required(),
                                        Forms\Components\Select::make('status')
                                            ->label(__("Status"))
                                            ->options(Language::getStatuses())
                                            ->native(false)
                                            ->default(Utilities::PUBLISHED)

                                    ])
                            ])
                            ->formatStateUsing(function (){
                                $languages =  Language::all()->toArray();
                                foreach ($languages as $index => $language){
                                    $languages[$index]['image'] = $language['image'] ? [
                                        $language['image']
                                    ] : $language['image'];
                                }
                                return $languages;
                            })
                            ->itemLabel(function($state){
                                return $state['language'];
                            })
                            ->reorderable(false)
                            ->collapsed()
                            ->collapsible()
                    ])->columnSpan(1)
                ]),
                Forms\Components\Section::make()->schema([
                    Forms\Components\Grid::make()->schema([
                        TextInput::make('smtp_host')
                            ->label(__("Smtp Host")),
                        TextInput::make('smtp_port')
                            ->label(__("Smtp Port")),
                        TextInput::make('smtp_user')
                            ->label(__("Smtp User")),
                        TextInput::make('smtp_pass')
                            ->label(__("Smtp Password"))
                            ->password(),
                        TextInput::make('smtp_from_address')
                            ->label(__("Smtp From Email"))
                            ->maxLength(255),
                        TextInput::make('smtp_from_name')
                            ->label(__("Smtp From Name"))
                            ->maxLength(255),
                    ]),
                    Forms\Components\Grid::make()->schema([
                        TextInput::make('testing_email')
                            ->label(__("Test Email"))
                            ->email(),
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('test')
                                ->label(__("Test"))
                                ->action(function($get){
                                    $to = $get('testing_email');
                                    if ($to){
                                        try {
                                            \Mail::raw('Hi, welcome user!', function ($message) use ($to){
                                                $message->to($to)
                                                    ->from(config('mail.from.address'), config('mail.from.name'))
                                                    ->subject("Testing Email");
                                            });


                                            Notification::make()
                                                ->title(__("Smtp Settings Are Valid"))
                                                ->success()
                                                ->send();

                                        }catch (Exception $e){
                                            Notification::make()
                                                ->danger()
                                                ->title(__("Please check smtp settings"))
                                                ->body($e->getMessage())
                                                ->send();
                                        }

                                        return;
                                    }

                                    Notification::make()
                                        ->title(__("Please enter email to test"))
                                        ->danger()
                                        ->send();
                                })
                        ])->verticallyAlignEnd()
                    ])
                ])->columnSpan(1)
            ]);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $supported_languages = Arr::pluck($data['languages'], 'locale');
        Language::whereNotIn('locale', $supported_languages)->delete();

        foreach ($data['languages'] ?? [] as $language){
            unset($language['created_at'], $language['updated_at'], $language['id']);
//            dd($language);
            Language::updateOrCreate(['locale' => $language['locale']], $language);
        }
        return parent::mutateFormDataBeforeSave($data);
    }
}
