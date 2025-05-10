<?php

namespace App\Filament\Resources;

use App\Exports\NewsExport;
use App\Exports\ShareHoldersExport;
use App\Filament\Components\FileUpload;
use App\Filament\Components\RichEditor;
use App\Filament\Components\TextInput;
use App\Helpers\Utilities;
use App\Models\Language;
use App\Models\News;
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
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\PathGenerators\DatePathGenerator;
use App\Classes\CustomPackage\CustomComponent\CustomCuratorPicker;

class NewsResource extends Resource
{
    use Translatable;

    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'zondicon-news-paper';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __("News");
    }

    public static function getModelLabel(): string
    {
        return __("News Piece");
    }

    public static function getPluralLabel(): ?string
    {
        return __("News");
    }

    public static function getPluralModelLabel(): string
    {
        return __("News");
    }

    public static function getNavigationGroup(): ?string
    {
        return __("Custom Modules");
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
                                    FileUpload::make("header_image.{$locale}")
                                        ->label(__("Header Image") . "[{$language}]")
                                        ->image()
                                        ->imageEditor(),

                                    TextInput::make("header_title.{$locale}")
                                        ->label(__("Header Title") . "[{$language}]")
                                        ->languageRule()
                                        ->maxLength(255)
                                        ->default(''),

                                    RichEditor::make("header_description.{$locale}")
                                        ->label(__("Header Description") . "[{$language}]")
                                        ->languageRule()
                                        ->maxLength(255),
                                ]);
                            }
                            return $tabs;
                        })
                        ->columnSpanFull(),
                        Forms\Components\Tabs::make()
                            ->tabs(function(){
                                $tabs = [];
                                foreach (config('app.locales') as $locale => $language){
                                    $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema([
                                        CustomCuratorPicker::make("image")
                                            ->label(__("Image"))
                                            ->pathGenerator(DatePathGenerator::class)
                                            ->size(40)
                                            ->color('primary') // defaults to primary
                                            ->outlined(true) // defaults to true
                                            ->size('md') // defaults to md
                                            ->constrained(false) // defaults to false (forces image to fit inside the preview area)
//                                            ->dehydrateStateUsing(function ($state) {
//                                                $path = !empty($state) ? reset($state)['path'] : '';
//                                                return $path; // If already a path, keep it
//                                            })
                                          , // only necessary to rename the order column if using a relationship with multiple media


//                                        FileUpload::make("image")
//                                            ->label(__("Image"))
//                                            ->image()
//                                            ->imageEditor()
//                                            ->multiple(false),

                                        TextInput::make("title.{$locale}")
                                            ->label(__("Title") . "[{$language}]")
                                            ->languageRule()
                                            ->maxLength(255)
                                            ->afterStateUpdated(function($state, $set, $get, $record) use ($locale){
                                                $set("seo.title.{$locale}", $state);
                                                if ($record?->slug)
                                                    return;
                                                $set('slug',  Utilities::slug($get('title.' . $locale)));
                                            })
                                            ->live(onBlur: true, debounce: false)
                                            ->required(function(Forms\Get $get) use ($locale){
                                                return in_array(Language::where('locale', $locale)->first()->id, $get('data.language_ids', true));
                                            }),

                                        RichEditor::make("description.{$locale}")
                                            ->label(__("Description") . "[{$language}]")
                                            ->languageRule()
                                            ->maxLength(255)
                                            ->live(onBlur: true, debounce: false)
                                            ->afterStateUpdated(function($state, $set, $get, $record) use ($locale){
                                                $set("seo.description.{$locale}", Utilities::trimParagraph($state));
                                            }),


                                        \App\Filament\Components\TinyEditor::make("content.{$locale}")
                                            ->label(__("Content") . "[{$language}]")
                                            ->languageRule()
                                            ->showMenuBar()
                                            ->toolbarSticky(true)
                                    ]);
                                }
                                return $tabs;
                            })
                            ->columnSpanFull(),
                        Forms\Components\Section::make()->schema([
                            Forms\Components\Repeater::make('slider')
                                ->label(__("Images"))
                                ->schema([
                                    FileUpload::make('image')
                                        ->image()
                                        ->imageEditor()
                                        ->required()
                                ])
                                ->maxItems(2)
                                ->collapsed()
                                ->collapsible()
                                ->cloneable()
                                ->minItems(0)
                                ->defaultItems(0)
                                ->itemLabel(function ($state){
                                    return array_keys($state['image'])[0] ?? "";
                                })
                        ])->columnSpanFull()
                    ])->columnSpan(2),
                    Forms\Components\Grid::make(1)->schema([
                        Forms\Components\Section::make()->schema(
                            array_merge(
                                Filament::auth()->user()->can('change_author_news') ? [
                                    Forms\Components\Select::make('author.name')
                                        ->label(__("Author"))
                                        ->relationship('author', 'name')
                                        ->default(Filament::auth()->user()->id)
                                        ->required()
                                        ->native(false)
                                ] : [] , [
                                Forms\Components\TextInput::make('slug')
                                    ->label(__("Slug"))
                                    ->unique(News::class, 'slug', ignoreRecord: true)
                                    ->required(),
                                Forms\Components\Select::make('category_id')
                                    ->label(__("Category"))
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->relationship('category', 'title->' . config('app.locale'))
                                    ->native(false),
                                Forms\Components\Select::make('language_ids')
                                    ->label(__("Language"))
                                    ->multiple()
                                    ->preload()
                                    ->live()
                                    ->required()
                                    ->default(Language::all()->pluck('id')->toArray())
                                    ->relationship('languages', 'language'),
                                Forms\Components\Checkbox::make('heading_news')
                                    ->label(__("Heading News"))
                                    ->default(false),
                                Forms\Components\DatePicker::make('published_at')
                                    ->label(__("Published At"))
                                    ->default(Carbon::today())
                                    ->native(false)
                                    ->required(),
                                Forms\Components\Select::make('status')
                                    ->label(__("Status"))
                                    ->options(News::getStatuses())
                                    ->native(false)
                                    ->default(1)
                            ])
                        ),
                        \App\Filament\Components\Seo::make(config('app.locales'))
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
                    ->default(asset('/storage/panel-assets/no-image.png'))
                    ->circular(),
                Tables\Columns\TextColumn::make('title')
                    ->toggleable()
                    ->getStateUsing(function ($record){
                        foreach (Language::all() as $language){
                            if (strlen($translation = $record->getTranslation('title', $language->locale)))
                                return $translation;
                        }
                        return "";
                    })
                    ->label(__("Title"))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.title')
                    ->label(__("Category"))
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->toggleable()
                    ->label(__("Status"))
                    ->badge()
                    ->color(function (News $record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function(News $record){
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
                Tables\Filters\SelectFilter::make('category_id')
                    ->label(__("Category"))
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->relationship('category', 'title->' . app()->getLocale()),
                Tables\Filters\SelectFilter::make('status')
                    ->label(__("Status"))
                    ->options(News::getStatuses())
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
                        NewsExport::make()->fromModel()
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
            'index' => \App\Filament\Resources\NewsResource\Pages\ListNews::route('/'),
            'create' => \App\Filament\Resources\NewsResource\Pages\CreateNews::route('/create'),
            'edit' => \App\Filament\Resources\NewsResource\Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
