<?php

namespace App\Filament\Resources;

use App\Exports\FaqExport;
use App\Filament\Components\FileUpload;
use App\Filament\Components\RichEditor;
use App\Filament\Components\TextInput;
use App\Helpers\BaseExport;
use App\Helpers\Utilities;
use App\Models\Faq;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static ?string $navigationIcon = 'bi-question';

    public static function getNavigationLabel(): string
    {
        return __("Faqs");
    }

    public static function getModelLabel(): string
    {
        return __("Faq");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Faqs");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Faqs");
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
                                        FileUpload::make('image')
                                            ->label(__("Image"))
                                            ->required(function(Forms\Get $get){
                                                return $get('is_video');
                                            })
                                            ->hidden(function (Forms\Get $get){
                                                return !$get('is_video');
                                            })
                                            ->image()
                                            ->imageEditor(),
                                        TextInput::make("title.{$locale}")
                                            ->label(__("Title") . "[{$language}]")
                                            ->languageRule()
                                            ->maxLength(255)
                                            ->required(),
                                        TextInput::make("video_url.{$locale}")
                                            ->label(__("Video Url") . "[{$language}]")
                                            ->url()
                                            ->required(function(Forms\Get $get){
                                                return $get('is_video');
                                            })
                                            ->hidden(function (Forms\Get $get){
                                                return !$get('is_video');
                                            }),
                                        RichEditor::make("description.{$locale}")
                                            ->label(__("Description") . "[{$language}]")
                                            ->languageRule()
                                            ->hidden(function (Forms\Get $get){
                                                return $get('is_video');
                                            })
                                            ->required(function (Forms\Get $get){
                                                return !$get('is_video');
                                            })
                                    ]);
                                }
                                return $tabs;
                            })
                            ->columnSpanFull(),
                    ])->columnSpan(2),
                    Forms\Components\Grid::make(1)->schema([
                        Forms\Components\Section::make()->schema(
                            array_merge(
                                Filament::auth()->user()->can('change_author_faq') ? [
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
                                Forms\Components\Checkbox::make('promote_to_homepage')
                                    ->default(false),
                                Forms\Components\Checkbox::make('is_video')
                                    ->live()
                                    ->default(false),
                                Forms\Components\Select::make('status')
                                    ->label(__("Status"))
                                    ->options(Faq::getStatuses())
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
                Tables\Columns\TextColumn::make('title')
                    ->toggleable()
                    ->label(__("Title"))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->toggleable()
                    ->label(__("Status"))
                    ->badge()
                    ->color(function (Faq $record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function(Faq $record){
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
                    ->options(Faq::getStatuses())
                    ->searchable()
                    ->native(false),
                Tables\Filters\Filter::make('promote_to_homepage')
                    ->label(__("Promoted To Homepage"))
                    ->query(fn (Builder $query): Builder => $query->where('promote_to_homepage', true)),
                Tables\Filters\Filter::make('is_video')
                    ->label(__("Is Video"))
                    ->query(fn (Builder $query): Builder => $query->where('is_video', true))
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
                        FaqExport::make()->fromModel()
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
            'index' => \App\Filament\Resources\FaqResource\Pages\ListFaqs::route('/'),
            'create' => \App\Filament\Resources\FaqResource\Pages\CreateFaq::route('/create'),
            'edit' => \App\Filament\Resources\FaqResource\Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
