<?php

namespace App\Filament\Resources\LoanWebformResource\Pages;

use App\Filament\Resources\LoanWebformResource;
use App\Imports\LoanImport;
use App\Imports\NewsImport;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLoanWebforms extends ListRecords
{
    protected static string $resource = LoanWebformResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
