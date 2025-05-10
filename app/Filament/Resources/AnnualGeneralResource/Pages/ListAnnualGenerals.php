<?php

namespace App\Filament\Resources\AnnualGeneralResource\Pages;

use App\Filament\Resources\AnnualGeneralResource;
use App\Imports\AccountImport;
use App\Imports\AnnualGeneralImport;
use App\Models\AnnualGeneral;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnnualGenerals extends ListRecords
{
    protected static string $resource = AnnualGeneralResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->use(AnnualGeneralImport::class)
                ->color('primary'),
            Actions\CreateAction::make(),
        ];
    }
}
