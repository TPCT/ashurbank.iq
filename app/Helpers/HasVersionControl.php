<?php

namespace App\Helpers;

use App\Models\Account;
use App\Models\VersionControl;
use Caxy\HtmlDiff\HtmlDiff;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\Diff\Diff;

trait HasVersionControl
{
    public function version_control(){
        return $this->morphOne(VersionControl::class, 'model');
    }

    public static function maker($model, $action_type){
        $user = Filament::auth()->user();

        if ($user->hasRole('super_admin') || $user->hasRole('checker'))
            return true;

        if ($user->hasRole('Maker')){
            if ($action_type == "update"){
                $old_values = \Arr::except(parent::find($model->id)->toArray(), [
                    'id', 'created_at', 'updated_at', 'published_at', 'user_id', 'status'
                ]);

                $new_values = \Arr::except($model->toArray(), [
                    'id', 'created_at', 'updated_at', 'published_at', 'user_id', 'status'
                ]);

                $model->version_control()->create([
                    'action_type' => $action_type,
                    'old_data' => $old_values,
                    'new_data' => $new_values,
                    'updated_by' => $user->id
                ]);

                return false;
            }

            $old_values = $new_values = $model->toArray();

            $model->version_control()->create([
                'action_type' => $action_type,
                'old_data' => $old_values,
                'new_data' => $new_values,
                'updated_by' => $user->id
            ]);

            if ($action_type == "create") {
                $model->status = false;
                $model->save();
                return true;
            }


            if ($action_type == "delete") {
                return false;
            }
        }

        return true;
    }

    private static function getTranslationDifference($model, $key, $translations){
        foreach ($translations as $locale => $translation) {
            $translations[$locale] = $translation ? Utilities::str_difference($model->{$key}, $translation) : "";
        }
        return $translations;
    }

    public static function bootHasVersionControl(){
        parent::retrieved(function (Model $model) {
            if (request('version_control') && $model->getVersionControlUrl()) {
                $user = Filament::auth()->user();
                if ($user->hasRole('super_admin') || $user->hasRole('Checker')){
                    $version_control = VersionControl::findOrFail(request('version_control'));
                    $translatable = $model->translatable;

                    foreach ($version_control->new_data as $key => $value) {
                        if (in_array($key, $translatable ?? [])) {
                            $value = self::getTranslationDifference($model, $key, $value);
                            $model->setTranslations($key, $value);
                            continue;
                        }

                        if (is_array($value)) {
                            $value = Utilities::array_diff_recursive($value, $model->{$key});
                            $model->{$key} = $value;
                            continue;
                        }

                        if ($key == "slug"){
                            continue;
                        }

                        $model->{$key} = Utilities::str_difference($model->{$key}, $value);
                    }
                }
            }
        });

        parent::created(fn($model) => static::maker($model, "create"));

        parent::updating(fn ($model) => static::maker($model, 'update'));

        parent::deleting(fn ($model) => static::maker($model, 'delete'));

    }
}