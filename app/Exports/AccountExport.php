<?php

namespace App\Exports;

use App\Helpers\BaseExport;

class AccountExport extends BaseExport
{
    protected array $exclude = [
        'weight', 'slug', 'status', 'promote', 'id', 'features', 'conditions'
    ];
}
