<?php

namespace App\Filament\Resources\HeaderImageResource\Pages;

use App\Filament\Resources\HeaderImageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHeaderImages extends ListRecords
{
    protected static string $resource = HeaderImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
