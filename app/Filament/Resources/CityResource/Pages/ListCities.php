<?php

namespace App\Filament\Resources\CityResource\Pages;

use App\Filament\Resources\CityResource;
use App\Imports\CityImport;
use App\Imports\ShareHolderImport;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCities extends ListRecords
{
    protected static string $resource = CityResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            CityResource\Widgets\CitiesWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->use(CityImport::class)
                ->color('primary'),
                Actions\CreateAction::make()
            ];
    }
}
