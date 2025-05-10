<?php

namespace App\Filament\Resources\CardWebformResource\Pages;

use App\Filament\Resources\CardWebformResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCardWebforms extends ListRecords
{
    protected static string $resource = CardWebformResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
