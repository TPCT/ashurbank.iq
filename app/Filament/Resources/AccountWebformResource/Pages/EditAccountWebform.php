<?php

namespace App\Filament\Resources\AccountWebformResource\Pages;

use App\Filament\Resources\AccountWebformResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccountWebform extends EditRecord
{
    protected static string $resource = AccountWebformResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
