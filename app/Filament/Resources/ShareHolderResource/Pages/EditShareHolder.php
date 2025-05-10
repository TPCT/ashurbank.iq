<?php

namespace App\Filament\Resources\ShareHolderResource\Pages;

use App\Filament\Resources\ShareHolderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShareHolder extends EditRecord
{
    protected static string $resource = ShareHolderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
