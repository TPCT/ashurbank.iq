<?php

namespace App\Filament\Resources\ShareHolderResource\Pages;

use App\Filament\Resources\ShareHolderResource;
use App\Imports\FinancialStatementImport;
use App\Imports\ShareHolderImport;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShareHolders extends ListRecords
{
    protected static string $resource = ShareHolderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->use(ShareHolderImport::class)
                ->color('primary'),
            Actions\CreateAction::make(),
        ];
    }
}
