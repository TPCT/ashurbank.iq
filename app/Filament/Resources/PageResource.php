<?php

namespace App\Filament\Resources;

use App\Exports\NewsExport;
use App\Exports\PageExport;
use App\Filament\Components\RichEditor;
use App\Filament\Components\TextInput;
use App\Filament\Resources\PageResource\Pages;
use App\Helpers\Utilities;
use App\Models\Page;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Hamcrest\Core\Set;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use RalphJSmit\Filament\SEO\SEO;

class PageResource extends Resource
{
    use Translatable;

    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-s-document';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __("Pages");
    }

    public static function getModelLabel(): string
    {
        return __("Page");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Pages");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Pages");
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
                    Forms\Components\Grid::make()->schema([
                        Forms\Components\Tabs::make()
                            ->tabs(function(){
                                $tabs = [];
                                foreach (config('app.locales') as $locale => $language){
                                    $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema([
                                        TextInput::make("title.{$locale}")
                                            ->label(__("Title") . "[{$language}]")
                                            ->languageRule()
                                            ->maxLength(255)
                                            ->afterStateUpdated(function($state, $set, $get, $record) use ($locale){
                                                $set("seo.title.{$locale}", $state);
                                                if ($record?->slug)
                                                    return;
//                                                $set('slug', \Str::slug($get('title.' . config('app.locale'))));
                                            })
                                            ->live(onBlur: true, debounce: false)
//                                            ->unique(Page::class, "title->{$locale}", ignoreRecord: true)
                                            ->required(),

                                        RichEditor::make("description.{$locale}")
                                            ->label(__("Description") . "[{$language}]")
                                            ->languageRule()
                                            ->live(onBlur: true, debounce: false)
                                            ->afterStateUpdated(function($state, $set, $get, $record) use ($locale){
                                                $set("seo.description.{$locale}", Utilities::trimParagraph($state));
                                            }),

                                        \App\Filament\Components\TinyEditor::make("content.{$locale}")
                                            ->label(__("Content") . "[{$language}]")
                                            ->languageRule()
                                            ->showMenuBar()
                                            ->toolbarSticky(true),
                                    ]);
                                }
                                return $tabs;
                            })
                            ->columnSpanFull()
                    ])->columnSpan(2),
                    Forms\Components\Grid::make(1)->schema([
                        Forms\Components\Section::make()->schema(
                            array_merge(
                                Filament::auth()->user()->can('change_author_page') ? [
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
                                Forms\Components\TextInput::make('slug')
                                    ->label(__("Slug")),
                                Forms\Components\TextInput::make('prefix')
                                    ->label(__("Prefix"))
                                    ->afterStateUpdated(function($state, Forms\Set $set){
                                        $set('prefix', trim(trim($state, "/")));
                                    })
                                    ->live(true)
                                    ->default(""),
                                Forms\Components\Select::make('view')
                                        ->label(__("View"))
                                        ->options(Page::getViews())
                                        ->preload()
                                        ->default(Page::DEFAULT_VIEW)
                                        ->native(false),
                                Forms\Components\DatePicker::make('published_at')
                                    ->label(__("Published At"))
                                    ->default(Carbon::today())
                                    ->native(false)
                                    ->required(),
                                Forms\Components\Select::make('status')
                                    ->label(__("Status"))
                                    ->options(Page::getStatuses())
                                    ->native(false)
                                    ->default(1),
                                Forms\Components\Checkbox::make('direct_access')
                                    ->label(__("Direct Access"))
                                    ->default(true),
                            ])
                        ),
                        \App\Filament\Components\Seo::make(config('app.locales'))
                            ->columnSpan(1)
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
                Tables\Columns\TextColumn::make('title')
                    ->toggleable()
                    ->label(__("Title"))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->toggleable()
                    ->label(__("Status"))
                    ->badge()
                    ->color(function (Page $record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function(Page $record){
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
                    ->options(Page::getStatuses())
                    ->searchable()
                    ->native(false)
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->icon('heroicon-s-eye')
                    ->label(__("View"))
                    ->url(function(Model $record){
                        $prefix = "/";
                        if ($record->sections()->count())
                            $prefix .= $record->sections()->first()->slug . "/";
                        $prefix .= $record->prefix ? ($record->prefix . "/"): "";
                        $prefix .= $record->slug;
                        return url($prefix);
                        return route('site.show', ['page' => $record]);
                }, shouldOpenInNewTab: true),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->poll("5s")
            ->recordAction(Tables\Actions\EditAction::class)
            ->recordUrl(function($record){
                return Pages\EditPage::getUrl([$record->slug]);
            })
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
                        PageExport::make()->fromModel()
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
