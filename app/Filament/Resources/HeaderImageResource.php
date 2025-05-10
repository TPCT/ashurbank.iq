<?php

namespace App\Filament\Resources;

use App\Exports\HeaderImagesExport;
use App\Filament\Components\FileUpload;
use App\Filament\Components\TextInput;
use App\Filament\Resources\HeaderImageResource\Pages;
use App\Filament\Resources\HeaderImageResource\RelationManagers;
use App\Models\Block;
use App\Models\HeaderImage;
use App\Models\Menu;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use http\Header;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class HeaderImageResource extends Resource
{
    use Translatable;

    protected static ?string $model = HeaderImage::class;

    protected static ?string $navigationIcon = 'bi-image-fill';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __("Header Images");
    }

    public static function getModelLabel(): string
    {
        return __("Header Image");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Header Images");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Header Images");
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
        $section = array_merge(
            [
                Forms\Components\Tabs::make()->tabs(function(){
            $tabs = [];
            foreach (config('app.locales') as $locale => $language){
                $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema([
                    Forms\Components\TextInput::make('path')
                        ->label(__("Path"))
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->required(),
                    FileUpload::make("image.{$locale}")
                        ->label(__("Image") . "[{$language}]")
                        ->image()
                        ->imageEditor(),
                    TextInput::make("title.{$locale}")
                        ->languageRule()
                        ->label(__("Title") . "[{$language}]")
                        ->maxLength(255),
                    TextInput::make("description.{$locale}")
                        ->languageRule()
                        ->label(__("Description") . "[{$language}]")
                        ->maxLength(255)
                ]);
            }
            return $tabs;
        })->columnSpan(2)
            ],
            Filament::auth()->user()->can('change_author_header-image') ?
                [
                    Forms\Components\Section::make()->schema([
                        Forms\Components\Select::make('author.name')
                            ->label(__("Author"))
                            ->relationship('author', 'name')
                            ->default(Filament::auth()->user()->id)
                            ->required()
                            ->native(false)
                    ])->columnSpan(1)
                ] : []
        );
        return $form
            ->schema([
                Forms\Components\Grid::make(3)->schema($section)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function(){
                return self::$model::orderBy('created_at', 'desc');
            })
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->toggleable()
                    ->label(__("Image"))
                    ->default(asset('/storage/panel-assets/no-image.png'))
                    ->circular(),
                Tables\Columns\TextColumn::make('path')
                    ->toggleable()
                    ->label(__("Path"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->toggleable()
                    ->label(__("Creation Time"))
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
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make('Export')->label(__('Export'))->exports([
                        HeaderImagesExport::make()->fromModel()
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
            'index' => Pages\ListHeaderImages::route('/'),
            'create' => Pages\CreateHeaderImage::route('/create'),
            'edit' => Pages\EditHeaderImage::route('/{record}/edit'),
        ];
    }
}
