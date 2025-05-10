<?php

namespace App\Filament\Resources\SeoLinkResource\Pages;

use App\Filament\Resources\SeoLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSeoLinks extends ListRecords
{
    protected static string $resource = SeoLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
