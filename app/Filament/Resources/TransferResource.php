<?php

namespace App\Filament\Resources;

use App\Exports\TeamMemberExport;
use App\Exports\TransfersExport;
use App\Filament\Components\FileUpload;
use App\Filament\Components\RichEditor;
use App\Filament\Components\TextInput;
use App\Filament\Resources\TransferResource\RelationManagers;
use App\Filament\Resources\TransferResource\Pages\CreateTransfer;
use App\Filament\Resources\TransferResource\Pages\EditTransfer;
use App\Filament\Resources\TransferResource\Pages\ListTransfers;
use App\Helpers\Utilities;
use App\Models\Transfer;
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

class TransferResource extends Resource
{
    use Translatable;

    protected static ?string $model = Transfer::class;

    protected static ?string $navigationIcon = 'clarity-block-solid';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __("Transfers");
    }

    public static function getModelLabel(): string
    {
        return __("Transfer");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Transfers");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Transfers");
    }

    public static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }

    public static function getNavigationGroup(): ?string
    {
        return __("Transfers");
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\Section::make()
                                ->schema([
                                    FileUpload::make("image")
                                        ->label(__("image"))
                                        ->multiple(false),
                                    FileUpload::make("inner_image")
                                        ->label(__("Inner Image"))
                                        ->multiple(false)
                                ]),
                            Forms\Components\Tabs::make()
                                ->tabs(function(){
                                    $tabs = [];
                                    foreach (config('app.locales') as $locale => $language){
                                        $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema([
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
                                                ->unique(Transfer::class, "title->{$locale}", ignoreRecord: true)
                                                ->required(),

                                            TextInput::make("second_title.{$locale}")
                                                ->label(__("Second Title") . "[{$language}]")
                                                ->languageRule()
                                                ->maxLength(255),

                                            RichEditor::make("description.{$locale}")
                                                ->label(__("Description") . "[{$language}]")
                                                ->languageRule()
                                        ]);
                                    }

                                    return $tabs;
                                })->columnSpanFull(),
                            Forms\Components\Section::make()->schema([
                                Forms\Components\Repeater::make('features')
                                    ->schema([
                                        Forms\Components\Tabs::make()->tabs(function(){
                                            $tabs = [];
                                            foreach(config('app.locales') as $locale => $language){
                                                $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema([
                                                    TextInput::make("title.{$locale}")
                                                        ->label(__("Title") . "[{$language}]")
                                                        ->languageRule()
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
                            ])->visible(function (Forms\Get $get){
                                return $get("data.view", true) != Transfer::MONEY_GRAM_VIEW;
                            })
                        ])
                        ->columnSpan(2),
                    Forms\Components\Grid::make(1)->schema([
                        Forms\Components\Section::make()->schema(
                            array_merge(
                                Filament::auth()->user()->can('change_author_transfer') ? [
                                    Forms\Components\Select::make('author.name')
                                        ->label(__("Author"))
                                        ->relationship('author', 'name')
                                        ->default(Filament::auth()->user()->id)
                                        ->required()
                                        ->native(false)
                                ] : [] , [
                                Forms\Components\Select::make('weight')
                                    ->default(self::$model::count())
                                    ->label(__("Weight"))
                                    ->options(range(0, self::$model::count()))
                                    ->native(false),
                                Forms\Components\TextInput::make('slug')
                                    ->label(__("Slug"))
                                    ->unique(self::$model, 'slug', ignoreRecord: true)
                                    ->required(),
                                Forms\Components\Select::make('view')
                                    ->label(__("View"))
                                    ->options(Transfer::getViews())
                                    ->preload()
                                    ->required()
                                    ->live()
                                    ->native(false),
                                Forms\Components\TextInput::make('button_url')
                                    ->label(__("Button Url"))
                                    ->visible(function (Forms\Get $get){
                                        return $get("data.view", true) == Transfer::MONEY_GRAM_VIEW;
                                    }),
                                Forms\Components\Select::make('section_ids')
                                    ->label(__("Section"))
                                    ->multiple()
                                    ->preload()
                                    ->required()
                                    ->relationship('sections', 'name'),
                                Forms\Components\DatePicker::make('published_at')
                                    ->label(__("Published At"))
                                    ->default(Carbon::today())
                                    ->native(false)
                                    ->required(),
                                Forms\Components\Select::make('status')
                                    ->label(__("Status"))
                                    ->options(Transfer::getStatuses())
                                    ->native(false)
                                    ->default(1)
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
                Tables\Columns\ImageColumn::make('image')
                    ->toggleable()
                    ->default(asset('/storage/' . "panel-assets/no-image.png"))
                    ->url(function (Transfer $record){
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
                    ->color(function (Transfer $record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function(Transfer $record){
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
                    ->options(Transfer::getStatuses())
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
                        TransfersExport::make()->fromModel()
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
            'index' => ListTransfers::route('/'),
            'create' => CreateTransfer::route('/create'),
            'edit' => EditTransfer::route('/{record}/edit'),
        ];
    }
}
