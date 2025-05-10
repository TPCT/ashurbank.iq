<?php

namespace App\Filament\Resources\BlockResource\Pages;

use App\Filament\Resources\BlockResource;
use App\Imports\AnnualGeneralImport;
use App\Imports\BlockImport;
use App\Models\Block;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBlocks extends ListRecords
{
    protected static string $resource = BlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->use(BlockImport::class)
                ->color('primary'),
            Actions\CreateAction::make(),
        ];
    }
}
