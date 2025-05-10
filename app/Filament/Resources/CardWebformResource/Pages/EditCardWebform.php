<?php

namespace App\Filament\Resources\CardWebformResource\Pages;

use App\Filament\Resources\CardWebformResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCardWebform extends EditRecord
{
    protected static string $resource = CardWebformResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
