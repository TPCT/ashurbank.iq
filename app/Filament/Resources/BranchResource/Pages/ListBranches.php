<?php

namespace App\Filament\Resources\BranchResource\Pages;

use App\Filament\Resources\BranchResource;
use App\Imports\BranchImport;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBranches extends ListRecords
{
    protected static string $resource = BranchResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Resources\BranchResource\Widgets\BranchesWidget::class
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->use(BranchImport::class)
                ->color('primary'),
            Actions\CreateAction::make(),
        ];
    }
}
