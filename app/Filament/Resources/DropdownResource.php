<?php

namespace App\Filament\Resources;

use App\Exports\DropdownExport;
use App\Filament\Components\FileUpload;
use App\Filament\Components\RichEditor;
use App\Filament\Components\TextInput;
use App\Filament\Resources\DropdownResource\Pages;
use App\Filament\Resources\DropdownResource\RelationManagers;
use App\Helpers\BaseExport;
use App\Helpers\Utilities;
use App\Models\Dropdown;
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
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;


class DropdownResource extends Resource
{
    use Translatable;

    protected static ?string $model = Dropdown::class;

    protected static ?string $navigationIcon = 'iconpark-dropdownlist-o';

    public static function getNavigationLabel(): string
    {
        return __("Dropdowns");
    }

    public static function getModelLabel(): string
    {
        return __("Dropdown");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Dropdowns");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Dropdowns");
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
        $tabs = [];
        foreach (config('app.locales') as $locale => $language){
            $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema([
                    FileUpload::make("image.{$locale}")
                            ->label(__("Image") . "[{$language}]")
                            ->image()
                            ->imageEditor(),
                    TextInput::make("title.{$locale}")
                            ->label(__("Title") . "[{$language}]")
                            ->languageRule()
                            ->maxLength(255)
                            ->afterStateUpdated(function($set, $get, $record){
                                if ($record?->slug)
                                    return;
                                $set('slug', \Str::slug($get('title.' . config('app.locale'))));
                            })
                            ->live(onBlur: true, debounce: false)
                            ->unique(Dropdown::class, "title->{$locale}", ignoreRecord: true)
                            ->required(),
                    RichEditor::make("description.{$locale}")
                            ->label(__("Description") . "[{$language}]")
                            ->languageRule()
                            ->maxLength(255),
                    Forms\Components\Grid::make(5)
                        ->schema([
                            Forms\Components\Checkbox::make('validations.has_partner')
                                ->label(__("Has Partner"))
                                ->default(true)
                                ->visible(function (Forms\Get $get){
                                    return $get('data.category', true) == Dropdown::MARTIAL_STATUS;
                                }),
                            Forms\Components\Checkbox::make('validations.has_max_length')
                                ->label(__("Max Length"))
                                ->live()
                                ->visible(function (Forms\Get $get){
                                    return $get('data.category', true) == Dropdown::DOCUMENT_TYPE;
                                })
                                ->columnSpan(1),
                            TextInput::make('validations.length')
                                ->label(false)
                                ->visible(function (Forms\Get $get){
                                    return $get('data.validations.has_max_length', true) == true;
                                })
                                ->columnSpan(4)
                        ])
            ]);
        }
        return $form
            ->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\Tabs::make()
                        ->tabs($tabs)
                        ->columnSpan(2),
                    Forms\Components\Section::make()->schema(
                       array_merge(
                           Filament::auth()->user()->can('change_author_dropdown') ? [
                               Forms\Components\Select::make('author.name')
                                     ->label(__("Author"))
                                     ->relationship('author', 'name')
                                     ->default(Filament::auth()->user()->id)
                                     ->required()
                                     ->native(false)
                           ] : [] , [
                           Forms\Components\TextInput::make('slug')
                               ->label(__("Slug"))
                               ->disabledOn('edit')
                               ->unique(ignoreRecord: true),
                           Forms\Components\TextInput::make('url')
                               ->label(__("Url"))
                               ->url(),
                           Forms\Components\Select::make('category')
                               ->label(__("Category"))
                               ->options(Dropdown::getCategories())
                               ->searchable()
                               ->preload()
                               ->required()
                               ->live()
                               ->native(false),
                           Forms\Components\DatePicker::make('published_at')
                               ->label(__("Published At"))
                               ->default(Carbon::today())
                               ->native(false)
                               ->required(),
                           Forms\Components\Select::make('status')
                               ->label(__("Status"))
                               ->options(Dropdown::getStatuses())
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
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->toggleable()
                    ->label(__("Category"))
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->toggleable()
                    ->label(__("Status"))
                    ->badge()
                    ->color(function (Dropdown $record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function(Dropdown $record){
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
                Tables\Filters\SelectFilter::make('category')
                    ->label(__("Category"))
                    ->options(Dropdown::getCategories())
                    ->native(false)
                    ->searchable(),
                Tables\Filters\SelectFilter::make('status')
                    ->label(__("Status"))
                    ->options(Dropdown::getStatuses())
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
                    ExportBulkAction::make('Export')->label(__('Export'))->exports([
                        DropdownExport::make()->fromModel(),
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
            'index' => Pages\ListDropdowns::route('/'),
            'create' => Pages\CreateDropdown::route('/create'),
            'edit' => Pages\EditDropdown::route('/{record}/edit'),
        ];
    }
}
