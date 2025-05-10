<?php

namespace App\Helpers;

use App\Models\AnnualReport;
use Illuminate\Database\Eloquent\Model;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class BaseExport extends ExcelExport
{
    use Export;


    protected array $exclude = [
        'weight', 'slug', 'status'
    ];

    protected array $timestamps = [
        'created_at', 'updated_at', 'deleted_at', 'published_at'
    ];

    protected array $translatable = [];

    protected array $attributes = [];


    public function fromModel(): static
    {
        parent::fromModel()
            ->except(fn ($model) => $this->ignore())
            ->withColumns(function($model) {
                $this->ignore();
                $columns = [];

                foreach ($this->attributes as $attribute)
                    $this->column($attribute, $columns);

                foreach ($this->translatable as $attribute)
                    $this->translate($attribute, $columns);

                return $columns;
            })
            ->askForFilename();
        return $this;
    }
}

