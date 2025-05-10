<?php

namespace App\Filament\Resources;

use App\Filament\Components\Seo;
use App\Filament\Resources\SeoLinkResource\Pages;
use App\Filament\Resources\SeoLinkResource\RelationManagers;
use App\Models\SeoLink;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SeoLinkResource extends Resource
{
    use Translatable;

    protected static ?string $model = SeoLink::class;

    protected static ?string $navigationIcon = 'iconpark-seo';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __("Seo Links");
    }

    public static function getModelLabel(): string
    {
        return __("Seo Link");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Seo Links");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Seo Links");
    }

    public static function getNavigationGroup(): ?string{
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
                    Forms\Components\Section::make()->schema([
                        Forms\Components\TextInput::make('path')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->required(),
                        Seo::make(config('app.locales'))
                    ])
                    ->columnSpan(2),
                    Forms\Components\Section::make()
                        ->schema(Filament::auth()->user()->can('change_author_seo-link') ? [
                            Forms\Components\Select::make('author.name')
                                ->label(__("Author"))
                                ->relationship('author', 'name')
                                ->default(Filament::auth()->user()->id)
                                ->required()
                                ->native(false)
                        ] : [])
                        ->columnSpan(1)
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('path')
                    ->toggleable()
                    ->label(__("Path"))
                    ->searchable(),
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
            'index' => Pages\ListSeoLinks::route('/'),
            'create' => Pages\CreateSeoLink::route('/create'),
            'edit' => Pages\EditSeoLink::route('/{record}/edit'),
        ];
    }
}
