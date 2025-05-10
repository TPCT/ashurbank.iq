<?php

namespace App\Filament\Resources\AnnualGeneralResource\Pages;

use App\Filament\Resources\AnnualGeneralResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnnualGeneral extends EditRecord
{
    protected static string $resource = AnnualGeneralResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
