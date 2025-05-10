<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VersionControl extends Model implements Auditable
{
    use HasFactory, HasAuthor, \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];
}
