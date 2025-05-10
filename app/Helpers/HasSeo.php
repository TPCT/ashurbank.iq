<?php

namespace App\Helpers;

use App\Models\Seo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasSeo
{
    public function addSEO(): static
    {
        $this->seo()->create();
        return $this;
    }
    protected static function bootHasSEO(): void
    {
        static::created(fn (self $model): self => $model->addSEO());
    }
    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, 'model')->withDefault(function(){
//            if (is_array($this->image)){
//                $image_data = $this->image;
//            }else{
//                $image_data = [];
//                foreach (config('app.locales') as $locale => $language){
//                    $image_data[$locale]['data.seo.image.' . $locale] = $this->image;
//                }
//                return $image_data;
//            }
//            return collect([
//                'image' => $image_data
//            ]);
        });
    }
}
