<?php

namespace App\Filament\Resources;

use App\Filament\Components\FileUpload;
use App\Filament\Components\TextInput;
use App\Filament\Resources\MenuResource\Pages;
use App\Filament\Resources\MenuResource\RelationManagers;
use App\Helpers\Utilities;
use App\Models\Menu;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Saade\FilamentAdjacencyList\Forms\Components\AdjacencyList;

class MenuResource extends Resource
{
    use Translatable;

    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'zondicon-menu';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __("Menus");
    }

    public static function getModelLabel(): string
    {
        return __("Menu");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Menus");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Menus");
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
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Section::make('')->schema([
                            TextInput::make('title')
                                ->label(__("Title"))
                                ->languageRule()
                                ->maxLength(255)
                                ->unique(Menu::class, ignoreRecord: true),
                            AdjacencyList::make('links')
                                ->form([
                                    Forms\Components\Tabs::make('')->tabs(function (){
                                        $tabs = [];
                                        foreach (config('app.locales') as $locale => $language){
                                            $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema([
                                                TextInput::make("title.{$locale}")
                                                    ->label(__("Title") . "[{$language}]")
                                                    ->languageRule()
                                                    ->required()
                                                    ->default("")
                                                    ->maxLength(255)
                                                    ->hidden(function (Forms\Get $get){
                                                        return $get('data.category', true) == Menu::SIDE_MENU;
                                                    }),
                                                FileUpload::make('image')
                                                    ->label(__("Image"))
                                                    ->visible(function (Forms\Get $get){
                                                        return in_array($get('data.category', true), [
                                                             Menu::SIDE_MENU,
                                                             Menu::TOP_HEADER_MENU
                                                        ]);
                                                    })
                                                    ->required()
                                                    ->image(),
                                                Forms\Components\TextInput::make("link.{$locale}")
                                                    ->label(__("Link") . "[{$language}]")
                                                    ->required()
                                                    ->default("#")
                                                    ->maxLength(255),
                                                Forms\Components\Checkbox::make('inactive')
                                                    ->default(false)
                                            ]);
                                        }
                                        return $tabs;
                                    })->default([])
                                ])
                                ->collapsible()
                                ->collapsed()
                                ->modal(false)
                                ->labelKey('title')
                                ->maxDepth(2)
                                ->label(__("Links")),

                            Forms\Components\Repeater::make('buttons')
                                ->visible(function (Forms\Get $get){
                                    return $get('data.category', true) == Menu::HEADER_MENU;
                                })
                                ->schema([
                                    Forms\Components\Tabs::make('')->tabs(function (){
                                        $tabs = [];
                                        foreach (config('app.locales') as $locale => $language){
                                            $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema([
                                                Forms\Components\TextInput::make("title.{$locale}")
                                                    ->label(__("Title") . "[{$language}]")
                                                    ->required()
                                                    ->default("")
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make("link.{$locale}")
                                                    ->label(__("Link") . "[{$language}]")
                                                    ->required()
                                                    ->default("#")
                                                    ->maxLength(255)
                                            ]);
                                        }
                                        return $tabs;
                                    })->default([])
                                ])
                                ->itemLabel(function ($state){
                                    return $state['title'][config('app.locale')];
                                })
                                ->collapsible()
                                ->collapsed()
                                ->label(__("Buttons"))

                        ])->columnSpan(2),
                        Forms\Components\Section::make()->schema(
                            array_merge(
                                Filament::auth()->user()->can('change_author_menu') ? [
                                    Forms\Components\Select::make('author.name')
                                        ->label(__("Author"))
                                        ->relationship('author', 'name')
                                        ->default(Filament::auth()->user()->id)
                                        ->required()
                                        ->native(false)
                                ] : [] , [
                                Forms\Components\Select::make('category')
                                    ->options(Menu::getCategories())
                                    ->label(__("Category"))
                                    ->live()
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
                                    ->options(Menu::getStatuses())
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
                Tables\Columns\TextColumn::make('title')
                    ->toggleable()
                    ->label(__("Title"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->toggleable()
                    ->label(__("Status"))
                    ->badge()
                    ->color(function (Menu $record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function(Menu $record){
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
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }

}
