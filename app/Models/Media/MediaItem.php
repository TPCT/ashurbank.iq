<?php

namespace App\Models\Media;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class MediaItem extends BaseModel
{
    use HasFactory;

    
    protected $fillable = 
    [
        'mediable_type', 'mediable_id',  'media_id', 'order', 'type',

    ];


    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class, "media_id", "id");
    }




}
