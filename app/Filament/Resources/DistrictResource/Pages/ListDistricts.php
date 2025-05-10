<?php

namespace App\Filament\Resources\DistrictResource\Pages;

use App\Filament\Resources\DistrictResource;
use App\Imports\CityImport;
use App\Imports\DistrictImport;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDistricts extends ListRecords
{
    protected static string $resource = DistrictResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            DistrictResource\Widgets\DistrictsWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->use(DistrictImport::class)
                ->color('primary'),
            Actions\CreateAction::make(),
        ];
    }
}
