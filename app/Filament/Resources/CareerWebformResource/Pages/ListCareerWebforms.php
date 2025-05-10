<?php

namespace App\Filament\Resources\CareerWebformResource\Pages;

use App\Filament\Resources\CareerWebformResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCareerWebforms extends ListRecords
{
    protected static string $resource = CareerWebformResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
