<?php

namespace App\Filament\Resources;

use App\Exports\BranchExport;
use App\Filament\Components\TextInput;
use App\Helpers\BaseExport;
use App\Helpers\Utilities;
use App\Models\Account;
use App\Models\Branch;
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

class BranchResource extends Resource
{
    use Translatable;

    protected static ?string $model = Branch::class;

    protected static ?string $navigationIcon = 'zondicon-location';

    public static function getNavigationLabel(): string
    {
        return __("Branches");
    }

    public static function getModelLabel(): string
    {
        return __("Branch");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Branches");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Branches");
    }

    public static function getNavigationGroup(): ?string
    {
        return __("Map");
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
                    Forms\Components\Tabs::make()
                        ->tabs(function(){
                            $tabs = [];
                            foreach (config('app.locales') as $locale => $language){
                                $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema([
                                    TextInput::make("name.{$locale}")
                                        ->label(__("Name") . "[{$language}]")
                                        ->languageRule()
                                        ->maxLength(255)
                                        ->unique(Branch::class, "name->{$locale}", ignoreRecord: true),
                                    TextInput::make("address.{$locale}")
                                        ->label(__("Address") . "[{$language}]")
                                        ->languageRule()
                                        ->maxLength(255),
                                    Forms\Components\Grid::make()
                                        ->columns(2)
                                        ->schema([
                                            TextInput::make('longitude')
                                                ->numeric()
                                                ->languageRule()
                                                ->required()
                                                ->columnSpan(1),
                                            TextInput::make('latitude')
                                                ->numeric()
                                                ->languageRule()
                                                ->required()
                                                ->columnSpan(1)
                                        ])
                                ]);
                            }
                            return $tabs;
                        })
                        ->columnSpan(2),
                    Forms\Components\Section::make()->schema(
                        array_merge(
                            Filament::auth()->user()->can('change_author_branch') ? [
                                Forms\Components\Select::make('author.name')
                                    ->label(__("Author"))
                                    ->relationship('author', 'name')
                                    ->default(Filament::auth()->user()->id)
                                    ->required()
                                    ->native(false)
                            ] : [] , [
                            Forms\Components\DatePicker::make('published_at')
                                ->label(__("Published At"))
                                ->default(Carbon::today())
                                ->native(false)
                                ->required(),
                            Forms\Components\Select::make('city_id')
                                ->label(__("City"))
                                ->required()
                                ->native(false)
                                ->searchable()
                                ->preload()
                                ->relationship('city', 'title->' . app()->getLocale()),

                            Forms\Components\Checkbox::make('is_atm')
                                ->default(false),

                            Forms\Components\Select::make('status')
                                ->label(__("Status"))
                                ->options(Branch::getStatuses())
                                ->native(false)
                                ->default(1),

                            Forms\Components\Select::make('weight')
                                ->label(__("Weight"))
                                ->options(range(0, self::$model::count()))
                                ->default(self::$model::count())
                                ->native(false)
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
                Tables\Columns\TextColumn::make('name')
                    ->toggleable()
                    ->label(__("Name"))
                    ->searchable(),

                Tables\Columns\TextColumn::make('city.title')
                    ->toggleable()
                    ->label(__("City")),

                Tables\Columns\TextColumn::make('status')
                    ->toggleable()
                    ->label(__("Status"))
                    ->badge()
                    ->color(function (Branch $record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function(Branch $record){
                        return $record->status == Utilities::PUBLISHED ? __("Published") : __("Pending");
                    }),

                Tables\Columns\TextColumn::make('published_at')
                    ->toggleable()
                    ->label(__("Publish Time"))
                    ->date(),

                Tables\Columns\TextColumn::make('author.name')
                    ->toggleable()
                    ->label(__("Author")),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('city_id')
                    ->label(__("City"))
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->relationship('city', 'title->' . app()->getLocale()),
                Tables\Filters\Filter::make('is_atm')
                    ->label(__("ATM"))
                    ->default(false)
                    ->query(fn ($query) => $query->where('is_atm', true)),
                Tables\Filters\SelectFilter::make('status')
                    ->label(__("Status"))
                    ->options(Branch::getStatuses())
                    ->searchable()
                    ->native(false)
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->poll('30s')
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
                        BranchExport::make()->fromModel()
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
            'index' => \App\Filament\Resources\BranchResource\Pages\ListBranches::route('/'),
            'create' => \App\Filament\Resources\BranchResource\Pages\CreateBranch::route('/create'),
            'edit' => \App\Filament\Resources\BranchResource\Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}
