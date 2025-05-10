<?php

namespace App\Filament\Resources\SeoLinkResource\Pages;

use App\Filament\Resources\SeoLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeoLink extends EditRecord
{
    protected static string $resource = SeoLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
