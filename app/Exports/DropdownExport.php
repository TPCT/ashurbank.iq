<?php

namespace App\Exports;

use App\Helpers\BaseExport;

class DropdownExport extends BaseExport
{
    protected array $exclude = [
        'weight', 'slug', 'status', 'promote', 'features',
        'link', 'buttons', 'bullets', 'form_type',
        'validations', 'url'
    ];
}
