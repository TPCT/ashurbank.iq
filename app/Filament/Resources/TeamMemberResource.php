<?php

namespace App\Filament\Resources;

use App\Exports\TeamMemberExport;
use App\Filament\Components\FileUpload;
use App\Filament\Components\RichEditor;
use App\Filament\Components\TextInput;
use App\Helpers\BaseExport;
use App\Helpers\Utilities;
use App\Models\TeamMember;
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

class TeamMemberResource extends Resource
{
    use Translatable;

    protected static ?string $model = TeamMember::class;

    protected static ?string $navigationIcon = 'ri-team-fill';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __("Team Members");
    }

    public static function getModelLabel(): string
    {
        return __("Team Member");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Team Members");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Team Members");
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
                                        FileUpload::make("image")
                                            ->label(__("Image"))
                                            ->image()
                                            ->imageEditor()
                                            ->live()
                                            ->afterStateUpdated(function($state, $set, $get, $record) use ($locale) {
                                                $set("seo.image.{$locale}", $state);
                                            }),

                                        TextInput::make("name.{$locale}")
                                            ->label(__("Name") . "[{$language}]")
                                            ->languageRule()
                                            ->maxLength(255)
                                            ->live(onBlur: true, debounce: false)
                                            ->unique(TeamMember::class, "name->{$locale}", ignoreRecord: true)
                                            ->required(),

                                        TextInput::make("position.{$locale}")
                                            ->label(__("Position") . "[{$language}]")
                                            ->languageRule()
                                            ->maxLength(255)
                                            ->live(onBlur: true, debounce: false)
                                            ->required(),
                                        RichEditor::make("description.{$locale}")
                                            ->label(__("Description") . "[{$language}]")
                                            ->languageRule()
                                    ]);
                                }
                                return $tabs;
                            })
                            ->columnSpanFull()
                    ])->columnSpan(2),
                    Forms\Components\Grid::make(1)->schema([
                        Forms\Components\Section::make()->schema(
                            array_merge(
                                Filament::auth()->user()->can('change_author_team-member') ? [
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
                                    ->options(TeamMember::getStatuses())
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
                Tables\Columns\ImageColumn::make('image')
                    ->toggleable()
                    ->default(asset('/storage/panel-assets/no-image.png'))
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->toggleable()
                    ->label(__("Name"))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position')
                    ->toggleable()
                    ->label(__("Position")),
                Tables\Columns\TextColumn::make('status')
                    ->toggleable()
                    ->label(__("Status"))
                    ->badge()
                    ->color(function (TeamMember $record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function(TeamMember $record){
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
                    ->preload()
                    ->relationship('author', 'name')
                    ->native(false),
                Tables\Filters\SelectFilter::make('position')
                    ->label(__("Position"))
                    ->searchable()
                    ->preload()
                    ->native(false),
                Tables\Filters\SelectFilter::make('status')
                    ->label(__("Status"))
                    ->options(TeamMember::getStatuses())
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
                        TeamMemberExport::make()->fromModel()
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
            'index' => \App\Filament\Resources\TeamMemberResource\Pages\ListTeamMembers::route('/'),
            'create' => \App\Filament\Resources\TeamMemberResource\Pages\CreateTeamMember::route('/create'),
            'edit' => \App\Filament\Resources\TeamMemberResource\Pages\EditTeamMember::route('/{record}/edit'),
        ];
    }
}
