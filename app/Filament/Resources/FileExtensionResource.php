<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FileExtensionResource\Pages;
use App\Filament\Resources\FileExtensionResource\RelationManagers;
use App\Models\FileExtension;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FileExtensionResource extends Resource
{
    protected static ?string $model = FileExtension::class;

    protected static ?string $navigationIcon = 'zondicon-upload';

    public static function getNavigationGroup(): ?string
    {
        return __("Site Settings");
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\Grid::make()->schema([
                        Forms\Components\Section::make()->schema([
                            Forms\Components\TextInput::make('name')
                                ->label(__("Name"))
                                ->required()
                                ->unique(ignoreRecord: true),
                            Forms\Components\TextInput::make('extension')
                                ->required()
                                ->label(__("Extension"))
                                ->unique(ignoreRecord: true)
                        ])
                    ])->columnSpan(2),
                    Forms\Components\Grid::make(1)->schema([
                        Forms\Components\Section::make()->schema(
                            array_merge(
                                Filament::auth()->user()->can('change_author_file-extension') ? [
                                    Forms\Components\Select::make('author.name')
                                        ->label(__("Author"))
                                        ->relationship('author', 'name')
                                        ->default(Filament::auth()->user()->id)
                                        ->required()
                                        ->native(false)
                                ] : [] , [
                            ])
                        )
                    ])->columnSpan(1),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__("Name")),
                Tables\Columns\TextColumn::make('extension')
                    ->label(__("Extension")),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__("Created at"))
                    ->date()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
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
            'index' => Pages\ListFileExtensions::route('/'),
            'create' => Pages\CreateFileExtension::route('/create'),
            'edit' => Pages\EditFileExtension::route('/{record}/edit'),
        ];
    }
}
