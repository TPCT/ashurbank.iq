<?php

namespace App\Filament\Resources\DropdownResource\Pages;

use App\Filament\Resources\DropdownResource;
use App\Imports\DistrictImport;
use App\Imports\DropdownImport;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDropdowns extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = DropdownResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->use(DropdownImport::class)
                ->color('primary'),
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            DropdownResource\Widgets\DropdownsStat::class
        ];
    }
}
