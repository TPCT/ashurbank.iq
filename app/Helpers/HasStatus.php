<?php

namespace App\Helpers;


use Filament\Facades\Filament;

trait HasStatus
{
    public function scopeActive($query): \Illuminate\Database\Eloquent\Builder
    {
        if (request('version_control') && Filament::auth()->user())
            return $query;
        return $query->where('status', Utilities::PUBLISHED);
    }

    public static function bootHasStatus(){
        parent::saving(function($model){
            $model->status = $model->status ?? 1;
        });

        if (!in_array(request()->segments()[0] ?? null, ['admin', 'livewire']))
            static::addGlobalScope('active', function ($builder) {
                if (request('version_control') && Filament::auth()->user())
                    return $builder;
                $builder->where('status', Utilities::PUBLISHED);
            });
    }

    public static function getStatuses(): array
    {
        return [
            Utilities::PENDING => __("Pending"),
            Utilities::PUBLISHED => __("Published")
        ];
    }
}
