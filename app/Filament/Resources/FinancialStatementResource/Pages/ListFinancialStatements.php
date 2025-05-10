<?php

namespace App\Filament\Resources\FinancialStatementResource\Pages;

use App\Filament\Resources\FinancialStatementResource;
use App\Imports\AnnualGeneralImport;
use App\Imports\FinancialStatementImport;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFinancialStatements extends ListRecords
{
    protected static string $resource = FinancialStatementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->use(FinancialStatementImport::class)
                ->color('primary'),
            Actions\CreateAction::make(),
        ];
    }
}
