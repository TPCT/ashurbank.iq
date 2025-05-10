<?php

namespace App\Exports;

use App\Helpers\BaseExport;

class BranchExport extends BaseExport
{
    protected array $exclude = [
        'weight', 'slug', 'status', 'promote', 'id', 'features', 'link', 'buttons', 'bullets'
    ];
}
