<?php

namespace App\Exports;

use App\Helpers\BaseExport;

class ShareHoldersExport extends BaseExport
{
    protected array $exclude = [
        'weight', 'slug', 'status', 'promote', 'id', 'features',
        'buttons', 'bullets', 'form_type',
        'validations', 'category', 'url', 'promote_to_homepage',
        'is_video', 'video_url'
    ];
}
