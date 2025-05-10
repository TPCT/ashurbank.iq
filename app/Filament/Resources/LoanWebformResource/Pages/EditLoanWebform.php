<?php

namespace App\Filament\Resources\LoanWebformResource\Pages;

use App\Filament\Resources\LoanWebformResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLoanWebform extends EditRecord
{
    protected static string $resource = LoanWebformResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
