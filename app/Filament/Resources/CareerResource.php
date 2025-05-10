<?php

namespace App\Filament\Resources;

use App\Exports\CardExport;
use App\Exports\CareersExport;
use App\Filament\Components\RichEditor;
use App\Filament\Components\TextInput;
use App\Helpers\BaseExport;
use App\Helpers\Utilities;
use App\Models\Career;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class CareerResource extends Resource
{
    use Translatable;

    protected static ?string $model = Career::class;

    protected static ?string $navigationIcon = 'eos-job';

    public static function getNavigationLabel(): string
    {
        return __("Careers");
    }

    public static function getModelLabel(): string
    {
        return __("Career");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Careers");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Careers");
    }

    public static function getNavigationGroup(): ?string
    {
        return __("Careers");
    }

    public static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\Grid::make()->schema([
                        Forms\Components\Tabs::make()
                            ->tabs(function(){
                                $tabs = [];
                                foreach (config('app.locales') as $locale => $language){
                                    $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema([
                                        TextInput::make("title.{$locale}")
                                            ->label(__("Title") . "[{$language}]")
                                            ->languageRule()
                                            ->maxLength(255)
                                            ->afterStateUpdated(function($state, $set, $get, $record) use ($locale){
                                                $set("seo.title.{$locale}", $state);
                                                if ($record?->slug)
                                                    return;
                                                $set('slug', \Str::slug($get('title.' . config('app.locale'))));
                                            })
                                            ->live(onBlur: true, debounce: false)
                                            ->required(),

                                        TextInput::make("location.{$locale}")
                                            ->label(__("Location") . "[{$language}]")
                                            ->languageRule()
                                            ->maxLength(255)
                                            ->required(),

                                        RichEditor::make("description.{$locale}")
                                            ->label(__("Description") . "[{$language}]")
                                            ->languageRule()
                                            ->live(onBlur: true, debounce: false)
                                            ->afterStateUpdated(function($state, $set, $get, $record) use ($locale){
                                                $set("seo.description.{$locale}", Utilities::trimParagraph($state));
                                            }),

                                        RichEditor::make("qualifications.{$locale}")
                                            ->label(__("Qualifications") . "[{$language}]")
                                        ->languageRule(),

                                        RichEditor::make("desirable.{$locale}")
                                            ->label(__("Desirable") . "[{$language}]")
                                        ->languageRule(),

                                        RichEditor::make("benefits.{$locale}")
                                            ->label(__("Benefits") . "[{$language}]")
                                        ->languageRule()
                                    ]);
                                }
                                return $tabs;
                            })
                            ->columnSpanFull(),
                    ])->columnSpan(2),
                    Forms\Components\Grid::make(1)->schema([
                        Forms\Components\Section::make()->schema(
                            array_merge(
                                Filament::auth()->user()->can('change_author_career') ? [
                                    Forms\Components\Select::make('author.name')
                                        ->label(__("Author"))
                                        ->relationship('author', 'name')
                                        ->default(Filament::auth()->user()->id)
                                        ->required()
                                        ->native(false)
                                ] : [] , [
                                Forms\Components\Select::make('category_id')
                                    ->label(__("Category"))
                                    ->native(false)
                                    ->preload()
                                    ->searchable()
                                    ->relationship('category', 'title->' . app()->getLocale())
                                    ->required(),
                                Forms\Components\TextInput::make('slug')
                                    ->label(__("Slug"))
                                    ->unique(Career::class, 'slug', ignoreRecord: true)
                                    ->required(),
                                Forms\Components\DatePicker::make('published_at')
                                    ->label(__("Published At"))
                                    ->default(Carbon::today())
                                    ->native(false)
                                    ->required(),
                                Forms\Components\Select::make('status')
                                    ->label(__("Status"))
                                    ->options(Career::getStatuses())
                                    ->native(false)
                                    ->default(1),
                                Forms\Components\Select::make('weight')
                                    ->default(self::$model::count())
                                    ->label(__("Weight"))
                                    ->options(range(0, self::$model::count()))
                                    ->native(false)
                            ])
                        ),
                        \App\Filament\Components\Seo::make(config('app.locales'))
                    ])->columnSpan(1),

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function(){
                return self::$model::orderBy('published_at', 'desc');
            })
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->toggleable()
                    ->label(__("Title"))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->toggleable()
                    ->label(__("Status"))
                    ->badge()
                    ->color(function (Career $record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function(Career $record){
                        return $record->status == Utilities::PUBLISHED ? __("Published") : __("Pending");
                    }),
                Tables\Columns\TextColumn::make('published_at')
                    ->toggleable()
                    ->label(__("Publish Time"))
                    ->date(),
                Tables\Columns\TextColumn::make('author.name')
                    ->toggleable()
                    ->label(__("Author"))
            ])
            ->filters([
                //
            ])
            ->poll('30s')
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('Change Status')
                    ->label(__("Change Status"))
                    ->modal()
                    ->modalWidth('sm')
                    ->form(function(){
                        return [
                            Forms\Components\Radio::make('status')
                                ->label(__("Status"))
                                ->options([
                                    'published' => __("Published"),
                                    'pending'   => __("Pending"),
                                ])
                        ];
                    })
                    ->deselectRecordsAfterCompletion()
                    ->action(function (Collection $records, $data){
                        $records->each(function($record) use ($data){
                            $record->status = $data['status'] == 'published';
                            $record->save();
                        });
                    }),
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make('Export')->label(__('Export'))->exports([
                        CareersExport::make()->fromModel()
                    ]),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\CareerResource\Pages\ListCareers::route('/'),
            'create' => \App\Filament\Resources\CareerResource\Pages\CreateCareer::route('/create'),
            'edit' => \App\Filament\Resources\CareerResource\Pages\EditCareer::route('/{record}/edit'),
        ];
    }
}
