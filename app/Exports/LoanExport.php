<?php

namespace App\Exports;

use App\Helpers\BaseExport;

class LoanExport extends BaseExport
{
    protected array $exclude = [
        'weight', 'slug', 'status', 'promote', 'id', 'features',
        'link', 'buttons', 'bullets', 'form_type',
        'validations', 'category', 'url', 'promote_to_homepage',
        'is_video', 'video_url', 'interest_rate'
    ];
}
