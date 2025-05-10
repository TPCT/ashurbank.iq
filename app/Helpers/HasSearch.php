<?php

namespace App\Helpers;

use App\Settings\Site;
use Illuminate\Support\Str;

trait HasSearch
{
    public static function results($keys){
        return self::where(function($query) use ($keys){
                    foreach($keys as $key){
                        $query->orWhere($key, 'LIKE', '%'.request('search', '').'%');
                    }
                })
                ->offset(app(Site::class)->search_page_size * request('page', 0))
                ->limit(app(Site::class)->search_page_size)->get();
    }

    public function getSearchUrl(){
        $model_name = Str::lower(\Str::afterLast(self::class, '\\'));
        if ($this->sections?->count())
            return route(Str::plural($model_name) . ".show", ['section' => $this->sections->first(), $model_name => $this]);
        return route(Str::plural($model_name) . ".show", [$model_name => $this]);
    }
}