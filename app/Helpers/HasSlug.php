<?php

namespace App\Helpers;


use App\Models\Language;
use App\Models\News;
use App\Settings\General;

trait HasSlug
{
    public static function bootHasSlug(){
        parent::saving(function ($model) {
            $slug = null;
            foreach($model->getTranslations('title') as $locale => $title){
                if ($title = trim($title)){
                    $language_id = Language::where('locale', $locale)->first()->id;
                    if ($model instanceof News)
                        $model->language_ids[] = $language_id;

                    if (!$slug) {
                        $slug = Utilities::slug($title);
                        $items = parent::whereSlug($slug);
                        if (!$items->count() || ($items->count() == 1 && $items->first()->id == $model->id))
                            continue;

                        $slug = $items->count() > 0 ? $slug . '-' . $items->count() : $slug;
                    }
                }
            }
            $model->slug = $slug;
        });
    }

    public function getRouteKey(){
        return $this->slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
