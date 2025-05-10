<?php

namespace App\Filament\Resources;

use App\Exports\ShareHoldersExport;
use App\Filament\Components\FileUpload;
use App\Filament\Components\TextInput;
use App\Helpers\BaseExport;
use App\Helpers\Utilities;
use App\Models\ShareHolder;
use Carbon\Carbon;
use Faker\Provider\Text;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class ShareHolderResource extends Resource
{
    protected static ?string $model = ShareHolder::class;

    protected static ?string $navigationIcon = 'tabler-report-analytics';

    public static function getNavigationLabel(): string
    {
        return __("Share Holders");
    }

    public static function getModelLabel(): string
    {
        return __("Share Holder");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Share Holders");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Share Holders");
    }

    public static function getNavigationGroup(): ?string
    {
        return __("Investor Relations");
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
                                        FileUpload::make("image")
                                            ->label(__("Image"))
                                            ->multiple(false)
                                            ->previewable(false)
                                            ->required(),
                                        TextInput::make("name.{$locale}")
                                            ->label(__("Name") . "[{$language}]")
                                            ->languageRule()
                                            ->maxLength(255)
                                            ->required(),
                                        TextInput::make("title.{$locale}")
                                            ->label(__("Title") . "[{$language}]")
                                            ->languageRule()
                                            ->maxLength(255),
                                        TextInput::make('shares')
                                            ->label(__("Shares"))
                                            ->required()
                                    ]);
                                }
                                return $tabs;
                            })
                            ->columnSpanFull(),
                    ])->columnSpan(2),
                    Forms\Components\Grid::make(1)->schema([
                        Forms\Components\Section::make()->schema(
                            array_merge(
                                Filament::auth()->user()->can('change_author_share-holder') ? [
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
                                Forms\Components\Select::make('status')
                                    ->label(__("Status"))
                                    ->options(ShareHolder::getStatuses())
                                    ->native(false)
                                    ->default(1),
                                Forms\Components\Select::make('weight')
                                    ->default(self::$model::count())
                                    ->label(__("Weight"))
                                    ->options(range(0, self::$model::count()))
                                    ->native(false)
                            ])
                        )
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
                Tables\Columns\TextColumn::make('name')
                    ->label(__("Name"))
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label(__("Title"))
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shares')
                    ->label(__("Shares"))
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__("Status"))
                    ->badge()
                    ->toggleable()
                    ->color(function (ShareHolder $record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function(ShareHolder $record){
                        return $record->status == Utilities::PUBLISHED ? __("Published") : __("Pending");
                    }),
                Tables\Columns\TextColumn::make('published_at')
                    ->label(__("Publish Time"))
                    ->toggleable()
                    ->date(),
                Tables\Columns\TextColumn::make('author.name')
                    ->label(__("Author"))
                    ->toggleable()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('author')
                    ->label(__("Author"))
                    ->searchable()
                    ->relationship('author', 'name')
                    ->native(false),
                Tables\Filters\SelectFilter::make('status')
                    ->label(__("Status"))
                    ->options(ShareHolder::getStatuses())
                    ->searchable()
                    ->native(false)
            ])
            ->actions([
                Tables\Actions\Action::make('View')
                    ->label(__("View"))
                    ->url(function ($record){
                        return asset('/storage/' . $record->link);
                    }, shouldOpenInNewTab: true),
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
                        ShareHoldersExport::make()->fromModel()
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
            'index' => \App\Filament\Resources\ShareHolderResource\Pages\ListShareHolders::route('/'),
            'create' => \App\Filament\Resources\ShareHolderResource\Pages\CreateShareHolder::route('/create'),
            'edit' => \App\Filament\Resources\ShareHolderResource\Pages\EditShareHolder::route('/{record}/edit'),
        ];
    }
}
