<?php

namespace App\Filament\Resources\TranslationCategoryResource\Pages;

use App\Filament\Resources\TranslationCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTranslations extends ListRecords
{
    protected static string $resource = TranslationCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
