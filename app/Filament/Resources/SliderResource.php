<?php

namespace App\Filament\Resources;

use App\Filament\Components\FileUpload;
use App\Filament\Components\TextInput;
use App\Filament\Resources\SliderResource\Pages;
use App\Filament\Resources\SliderResource\RelationManagers;
use App\Helpers\Utilities;
use App\Models\Block;
use App\Models\Slider;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Components\Tab;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class SliderResource extends Resource
{
    use Translatable;

    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __("Sliders");
    }

    public static function getModelLabel(): string
    {
        return __("Slider");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Sliders");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Sliders");
    }

    public static function getNavigationGroup(): ?string
    {
        return __("CMS");
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
                    Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\Tabs::make()->tabs(function(){
                                $tabs = [];
                                foreach (config('app.locales') as $locale => $language){
                                    $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema([
                                       TextInput::make("title.{$locale}")
                                            ->label(__("title") . "[{$language}]")
                                            ->languageRule()
                                            ->maxLength(255)
                                            ->unique(Slider::class, "title->{$locale}", ignoreRecord: true)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function($set, $get, $state, $record){
                                                if ($record?->slug)
                                                    return;
                                                $set('slug', \Str::slug($get("title." . config('app.locale'))));
                                            })
                                            ->required(),
                                        TextInput::make("second_title.{$locale}")
                                            ->label(__("Second Title") . "[{$language}]")
                                            ->languageRule()
                                            ->maxLength(255)
                                    ]);
                                }
                                return $tabs;
                            }),
                            Forms\Components\Repeater::make('bullets')->schema([
                                Forms\Components\Tabs::make()->tabs(function(){
                                    $tabs = [];
                                    foreach (config('app.locales') as $locale => $language){
                                        $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema([
                                            TextInput::make("title.{$locale}")
                                                ->label(__("Title") . "[{$language}]")
                                                ->languageRule()
                                                ->maxLength(255)
                                                ->required()
                                        ]);
                                    }
                                    return $tabs;
                                })
                            ])->itemLabel(function($component, $state){
                                return $state['title'][config('app.locale')];
                            })
                                ->collapsed()
                                ->collapsible()
                                ->cloneable()
                                ->defaultItems(0)
                                ->minItems(0),
                            Forms\Components\Repeater::make('slides')->schema([
                                FileUpload::make('image')
                                    ->label(__("Image")),
                                Forms\Components\Tabs::make()->tabs(function(){
                                    $tabs = [];
                                    foreach (config('app.locales') as $locale => $language){
                                        $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema([
                                            TextInput::make("title.{$locale}")
                                                ->label(__("Title") . "[{$language}]")
                                                ->languageRule()
                                                ->maxLength(255)
                                                ->live(onBlur: true),
                                            TextInput::make("link.{$locale}")
                                                ->label(__("Link") . "[{$language}]")
                                                ->maxLength(255)
                                        ]);
                                    }
                                    return $tabs;
                                })
                            ])
                            ->itemLabel(function($component, $state){
                                return $state['title'][config('app.locale')];
                            })
                            ->collapsed()
                            ->collapsible()
                            ->cloneable()
                            ->minItems(0)
                            ->defaultItems(0)
                        ])
                        ->columnSpan(2),
                    Forms\Components\Section::make()->schema(
                        array_merge(
                            Filament::auth()->user()->can('change_author_slider') ? [
                                Forms\Components\Select::make('author.name')
                                    ->label(__("Author"))
                                    ->relationship('author', 'name')
                                    ->default(Filament::auth()->user()->id)
                                    ->required()
                                    ->native(false)
                            ] : [] , [
                            Forms\Components\TextInput::make('slug')
                                ->label(__("Slug"))
                                ->disabled(function ($record){
                                    return (bool)$record?->slug;
                                })
                                ->unique(ignoreRecord: true)
                                ->required(),
                            Forms\Components\Select::make('category')
                                ->options(Slider::getCategories())
                                ->label(__("Category"))
                                ->required()
                                ->preload()
                                ->native(false),
                            Forms\Components\DatePicker::make('published_at')
                                ->label(__("Published At"))
                                ->default(Carbon::today())
                                ->native(false)
                                ->required(),
                            Forms\Components\Select::make('status')
                                ->label(__("Status"))
                                ->options(Slider::getStatuses())
                                ->native(false)
                                ->default(1)
                        ])
                    )->columnSpan(1)

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
                Tables\Columns\ImageColumn::make('image')
                    ->toggleable()
                    ->default(asset('/storage/' . "panel-assets/no-image.png"))
                    ->url(function (Slider $record){
                        if ($record->image)
                            return asset('/storage/' . $record->image);
                        return asset('/storage/' . "panel-assets/no-image.png") ;
                    })
                    ->circular(),
                Tables\Columns\TextColumn::make('title')
                    ->toggleable()
                    ->label(__("Title"))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->toggleable()
                    ->label(__("Status"))
                    ->badge()
                    ->color(function (Slider $record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function(Slider $record){
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
                Tables\Filters\SelectFilter::make('author')
                    ->label(__("Author"))
                    ->searchable()
                    ->relationship('author', 'name')
                    ->native(false),
                Tables\Filters\SelectFilter::make('status')
                    ->label(__("Status"))
                    ->options(Slider::getStatuses())
                    ->searchable()
                    ->native(false)
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->poll("5s")
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
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}

