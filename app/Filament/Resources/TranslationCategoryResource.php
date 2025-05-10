<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TranslationCategoryResource\Pages;
use App\Filament\Resources\TranslationCategoryResource\RelationManagers;
use App\Filament\Resources\TranslationResource\Pages\CreateTranslation;
use App\Filament\Resources\TranslationResource\Pages\EditTranslation;
use App\Filament\Resources\TranslationResource\Pages\ListTranslations;
use App\Models\TranslationCategory;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Hamcrest\Core\Set;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Unique;

class TranslationCategoryResource extends Resource
{
    protected static ?string $model = TranslationCategory::class;

    public static function getRecordTitle(?Model $record): string|null|Htmlable
    {
        return $record->title;
    }

    public static function getNavigationLabel(): string
    {
        return __("Translations");
    }

    public static function getModelLabel(): string
    {
        return __("Translation");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Translations");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Translations");
    }

    protected static ?string $navigationIcon = 'eos-translate';

    public static function getNavigationGroup(): ?string
    {
        return __("Site Settings");
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\Section::make()->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__("Title"))
                            ->maxLength(255)
                            ->required(),
                    ])->columnSpan(1),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->toggleable()
                    ->label(__("Title"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('author.name')
                    ->toggleable()
                    ->label(__("Author"))
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Translations')
                    ->url(
                        fn (TranslationCategory $record): string => static::getUrl('translations.index', [
                            'parent' => $record->id,
                        ])
                    ),
                Tables\Actions\EditAction::make()
            ])
            ->poll('30s')
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
            'index' => Pages\ListTranslations::route('/'),
            'create' => Pages\CreateTranslation::route('/create'),
            'edit' => Pages\EditTranslation::route('/{record}/edit'),

            'translations.index' => ListTranslations::route('/{parent}/translations'),
            'translations.create' => CreateTranslation::route('/{parent}/translations/create'),
            'translations.edit' => EditTranslation::route('/{parent}/translations/{record}/edit'),
        ];
    }
}
