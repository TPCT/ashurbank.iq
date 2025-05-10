<?php

namespace App\Filament\Resources;

use App\Exports\BlockExport;
use App\Filament\Components\FileUpload;
use App\Filament\Components\RichEditor;
use App\Filament\Components\TextInput;
use App\Filament\Resources\BlockResource\Pages;
use App\Filament\Resources\BlockResource\RelationManagers;
use App\Helpers\Utilities;
use App\Models\Account;
use App\Models\Block;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class BlockResource extends Resource
{
    use Translatable;

    protected static ?string $model = Block::class;

    protected static ?string $navigationIcon = 'clarity-block-solid';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __("Blocks");
    }

    public static function getModelLabel(): string
    {
        return __("Block");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Blocks");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Blocks");
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
                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\Tabs::make()
                                ->tabs(function(){
                                    $tabs = [];
                                    foreach (config('app.locales') as $locale => $language){
                                        $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema([
                                            FileUpload::make("image.{$locale}")
                                                ->label(__("Image") . "[{$language}]"),

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
                                                ->required(),

                                            TextInput::make("second_title.{$locale}")
                                                ->label(__("Second Title") . "[{$language}]")
                                                ->languageRule()
                                                ->maxLength(255),

                                            RichEditor::make("description.{$locale}")
                                                ->label(__("Description") . "[{$language}]")
                                                ->languageRule(),

                                            \App\Filament\Components\TinyEditor::make("content.{$locale}")
                                                ->label(__("Content") . "[{$language}]")
                                                ->languageRule()
                                                ->showMenuBar()
                                                ->toolbarSticky(true),
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
                                                    FileUpload::make('image')
                                                        ->label(__("Image"))
                                                        ->multiple(false)
                                                        ->image()
                                                        ->imageEditor(),
                                                    TextInput::make("title.{$locale}")
                                                        ->label(__("Title") . "[{$language}]")
                                                        ->languageRule(),
                                                    RichEditor::make("description.{$locale}")
                                                        ->label(__("Description") . "[{$language}]")
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
                            ]),
                            Forms\Components\Section::make()->schema([
                                Forms\Components\Repeater::make('buttons')
                                    ->schema([
                                        Forms\Components\Tabs::make()->tabs(function(){
                                            $tabs = [];
                                            foreach(config('app.locales') as $locale => $language){
                                                $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema([
                                                    Forms\Components\Grid::make()
                                                    ->schema([
                                                        TextInput::make("text.{$locale}")
                                                            ->label(__("Text") . "[{$language}]")
                                                            ->languageRule(),
                                                        TextInput::make("url.{$locale}")
                                                            ->label(__("Url") . "[{$language}]")
                                                            ->languageRule()
                                                    ])
                                                ]);
                                            }
                                            return $tabs;
                                        })
                                    ])
                                    ->itemLabel(function($component, $state){
                                        return $state['text'][config('app.locale')];
                                    })
                                    ->collapsed()
                                    ->collapsible()
                                    ->cloneable()
                                    ->minItems(0)
                                    ->defaultItems(0)
                            ])
                        ])
                        ->columnSpan(2),
                    Forms\Components\Grid::make(1)->schema([
                        Forms\Components\Section::make()->schema(
                            array_merge(
                                Filament::auth()->user()->can('change_author_block') ? [
                                    Forms\Components\Select::make('author.name')
                                        ->label(__("Author"))
                                        ->relationship('author', 'name')
                                        ->default(Filament::auth()->user()->id)
                                        ->required()
                                        ->native(false)
                                ] : [] , [

                                Forms\Components\Select::make('section_ids')
                                    ->label(__("Section"))
                                    ->multiple()
                                    ->preload()
                                    ->relationship('sections', 'name'),
                                Forms\Components\Select::make('dropdown_id')
                                    ->label(__("Category"))
                                    ->required()
                                    ->native(false)
                                    ->searchable()
                                    ->preload()
                                    ->default(null)
                                    ->relationship('dropdown', 'title->' . app()->getLocale()),
                                Forms\Components\DatePicker::make('published_at')
                                    ->label(__("Published At"))
                                    ->default(Carbon::today())
                                    ->native(false)
                                    ->required(),
                                Forms\Components\Select::make('status')
                                    ->label(__("Status"))
                                    ->options(Block::getStatuses())
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
                    ->url(function (Block $record){
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
                    ->color(function (Block $record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function(Block $record){
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
                    ->options(Block::getStatuses())
                    ->searchable()
                    ->native(false),
                Tables\Filters\SelectFilter::make('dropdown_id')
                    ->label(__("Category"))
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->default(null)
                    ->relationship('dropdown', 'title->' . app()->getLocale()),

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
                        BlockExport::make()->fromModel()
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
            'index' => Pages\ListBlocks::route('/'),
            'create' => Pages\CreateBlock::route('/create'),
            'edit' => Pages\EditBlock::route('/{record}/edit'),
        ];
    }
}
