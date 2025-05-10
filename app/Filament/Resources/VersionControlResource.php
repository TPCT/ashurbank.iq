<?php

namespace App\Filament\Resources;

use App\Filament\Components\FileUpload;
use App\Filament\Components\RichEditor;
use App\Filament\Resources\VersionControlResource\Pages;
use App\Filament\Resources\VersionControlResource\RelationManagers;
use App\Helpers\Utilities;
use App\Models\VersionControl;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class VersionControlResource extends Resource
{
    protected static ?string $model = VersionControl::class;

    protected static ?string $navigationIcon = 'carbon-version';


    public static function getNavigationLabel(): string
    {
        return __("Version Control");
    }

    public static function getModelLabel(): string
    {
        return __("Version Control");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Version Control");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Version Control");
    }

    public static function getNavigationBadge(): ?string
    {
        return self::$model::where('checked', false)->count();
    }

    public static function getNavigationGroup(): ?string
    {
        return __("Users Management");
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function(){
                return self::$model::query()->orderBy('created_at', 'desc');
            })
            ->columns([
                Tables\Columns\TextColumn::make('author.name')
                    ->label(__("Author")),

                TextColumn::make('Model')
                    ->label(__("Model"))
                    ->getStateUsing(function($record){
                        return last(explode("\\", $record->model_type));
                    }),

                TextColumn::make('action_type')
                    ->label(__('Action Type')),

                Tables\Columns\TextColumn::make('checked')
                    ->label(__('Checked'))
                    ->badge(function ($record){
                        return $record->checked ? "success" : "danger";
                    })
                    ->formatStateUsing(function($state){
                        return $state ? __("True") : __("False");
                    }),

                Tables\Columns\TextColumn::make('accepted')
                    ->label(__('Accepted'))
                    ->badge(function ($record){
                       return $record->accepted ? "success" : "danger";
                    })
                    ->formatStateUsing(function($state){
                        return $state ? __("True") : __("False");
                    }),

                Tables\Columns\TextColumn::make('reject_note')
                    ->label(__('Reject Note'))
                    ->formatStateUsing(function ($state){
                        return strip_tags($state);
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->label(__("Created at"))
                    ->dateTime()
            ])
            ->filters([
                SelectFilter::make('checked')
                    ->label(__('Checked'))
                    ->default(false)
                    ->native(false)
                    ->options([
                        false => __("Pending"),
                        true => __("Checked")
                    ]),
                SelectFilter::make('accepted')
                    ->label(__('Accepted'))
                    ->native(false)
                    ->options([
                        false => __('Rejected'),
                        true => __('Accepted')
                    ]),
                SelectFilter::make('action_type')
                    ->label(__("Action"))
                    ->native(false)
                    ->options([
                        "update" => __("Update"),
                        "delete" => __("Delete"),
                        "create" => __("Create")
                    ])
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label(__("View"))
                    ->modalWidth("100%")
                    ->modalContent(function ($record){
                        if ($model = $record->model_type::find($record->model_id)){
                            if ($model->getVersionControlUrl()){
                                return view('version-control', [
                                    'before_edit_link' => $model->getVersionControlUrl(),
                                    'after_edit_link' => $model->getVersionControlUrl() . "?version_control=" . $record->id,
                                ]);
                            }
                        }
                        return null;
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
                    ->form(function ($record){
                        $model = $record->model_type::find($record->model_id);
                        if (!$model->getVersionControlUrl()) {
                            $translatable = $model->translatable;
                            $difference = Utilities::array_diff_recursive($record->old_data, $record->new_data, false);
                            return [
                                Forms\Components\Tabs::make()->tabs(function () use ($record, $difference, $translatable) {
                                    $tabs = [];
                                    foreach (config('app.locales') as $locale => $language) {
                                        $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema(function () use ($record, $locale, $translatable, $difference) {
                                            $schema = [];
                                            foreach ($difference as $key => $value) {
                                                if (in_array($key, $translatable) && isset($value[$locale])) {
                                                    if (in_array($key, ['link', 'image'])){
                                                        $schema[] = Forms\Components\Grid::make()->schema([
                                                            Forms\Components\Placeholder::make("{$key}_old.{$locale}")
                                                                ->label("{$key}[Old]")
                                                                ->content(function() use ($record, $key, $locale){
                                                                    return new HtmlString("<a href='" . asset($record->old_data[$key][$locale]) . "'>" . __("View") . "</a>");
                                                                }),
                                                            Forms\Components\Placeholder::make("{$key}_new.{$locale}")
                                                                ->label("{$key}[New]")
                                                                ->content(function() use ($record, $key, $locale, $value){
                                                                    return new HtmlString("<a href='" . asset($value[$locale]) . "'>" . __("View") . "</a>");
                                                                }),
                                                        ]);
                                                    }else{
                                                        $schema[] = Forms\Components\Grid::make()->schema([
                                                            Forms\Components\Placeholder::make("{$key}_old.{$locale}")
                                                                ->label("{$key}[old]")
                                                                ->content($record->old_data[$key][$locale] ?? ""),
                                                            Forms\Components\Placeholder::make("{$key}_new.{$locale}")
                                                                ->label("{$key}[new]")
                                                                ->content($value[$locale] ?? "")
                                                        ]);
                                                    }
                                                }
                                            }
                                            return $schema;
                                        });
                                    }
                                    return $tabs;
                                })
                            ];
                        }
                        return [];
                    })
                    ->visible(function ($record){
                        return ($record->action_type == "update" || $record->action_type == "create");
                    }),

                Tables\Actions\Action::make('accept')
                    ->label(__('Accept'))
                    ->action(function ($record){
                        $record->accepted = true;
                        $record->checked = true;
                        $record->save();

                        if ($record->action_type == "update") {
                            $model = $record->model_type::find($record->model_id);
                            if (!$model){
                                $record->delete();
                                return null;
                            }
                            $model->update($record->new_data);
                            $model->save();
                        }

                        elseif ($record->action_type == "create"){
                            $model = $record->model_type::find($record->model_id);
                            if (!$model){
                                $record->delete();
                                return null;
                            }
                            $model->status = Utilities::PUBLISHED;
                            $model->save();
                        }

                        elseif ($record->action_type == "delete"){
                            $model = $record->model_type::create($record->new_data);
                            if (!$model){
                                $record->delete();
                                return null;
                            }
                            $model->delete();
                        }
                    }),
                Tables\Actions\Action::make('reject')
                    ->label(__('Reject'))
                    ->modal()
                    ->form([
                        RichEditor::make('reject_note')
                            ->label(__('Reject Note'))
                            ->maxLength(255)
                    ])
                    ->action(function ($data, $record){
                        $data['accepted'] = false;
                        $data['checked'] = true;
                        $record->update($data);

                        if ($record->action_type == "update") {
                            $model = $record->model_type;
                            $model = $model::find($record->model_id);
                            if (!$model){
                                $record->delete();
                                return null;
                            }
                            $model->update($record->old_data);
                            $model->save();
                        }
                        elseif ($record->action_type == "create"){
                            $model = $model::find($record->model_id);
                            if (!$model){
                                $record->delete();
                                return null;
                            }
                            $model->delete();
                        }
                    }),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListVersionControls::route('/')
        ];
    }
}
