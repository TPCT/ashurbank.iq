<?php

namespace App\Filament\Widgets;

use App\Filament\Components\RichEditor;
use App\Helpers\Utilities;
use App\Models\User;
use App\Models\VersionControl;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Facades\Filament;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Tabs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\HtmlString;

class VersionControlWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(function(){
                $user = Filament::auth()->user();
                $query = VersionControl::query()->orderBy('created_at', 'desc');
                if ($user->hasRole('Maker'))
                    return $query->where('user_id', $user->id);
                return $query;
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
                    ->default(function (){
                        if (Filament::auth()->user()->hasRole('Maker'))
                            return true;
                        return false;
                    })
                    ->native(false)
                    ->options([
                        false => __("Pending"),
                        true => __("Checked")
                    ]),
                SelectFilter::make('accepted')
                    ->default(function (){
                        if (Filament::auth()->user()->hasRole('Maker'))
                            return false;
                        return null;
                    })
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
                                Tabs::make()->tabs(function () use ($record, $difference, $translatable) {
                                    $tabs = [];
                                    foreach (config('app.locales') as $locale => $language) {
                                        $tabs[] = Tabs\Tab::make($language)->schema(function () use ($record, $locale, $translatable, $difference) {
                                            $schema = [];
                                            foreach ($difference as $key => $value) {
                                                if (in_array($key, $translatable) && isset($value[$locale])) {
                                                    if (in_array($key, ['link', 'image'])){
                                                        $schema[] = Grid::make()->schema([
                                                            Placeholder::make("{$key}_old.{$locale}")
                                                                ->label("{$key}[Old]")
                                                                ->content(function() use ($record, $key, $locale){
                                                                    return new HtmlString("<a href='" . asset($record->old_data[$key][$locale]) . "'>" . __("View") . "</a>");
                                                                }),
                                                            Placeholder::make("{$key}_new.{$locale}")
                                                                ->label("{$key}[New]")
                                                                ->content(function() use ($record, $key, $locale, $value){
                                                                    return new HtmlString("<a href='" . asset($value[$locale]) . "'>" . __("View") . "</a>");
                                                                }),
                                                        ]);
                                                    }else{
                                                        $schema[] = Grid::make()->schema([
                                                            Placeholder::make("{$key}_old.{$locale}")
                                                                ->label("{$key}[old]")
                                                                ->content($record->old_data[$key][$locale] ?? ""),
                                                            Placeholder::make("{$key}_new.{$locale}")
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
                    })
                    ->visible(function(){
                        $user = Filament::auth()->user();
                        return $user->hasRole('Checker') or $user->hasRole('super_admin');
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
                            $model = VersionControl::find($record->model_id);
                            if (!$model){
                                $record->delete();
                                return null;
                            }
                            $model->delete();
                        }
                    })
                    ->visible(function(){
                        $user = Filament::auth()->user();
                        return $user->hasRole('Checker') or $user->hasRole('super_admin');
                    }),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
