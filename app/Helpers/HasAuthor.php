<?php

namespace App\Helpers;

use App\Models\User;
use Filament\Facades\Filament;

trait HasAuthor
{
    public static function boot(): void{
        parent::saving(function($model){
            if ($model->user_id)
                return;
            $model->user_id = Filament::auth()->user()->id;
        });
        parent::boot();
    }

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
