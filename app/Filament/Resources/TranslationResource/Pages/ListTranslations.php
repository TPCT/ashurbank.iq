<?php

namespace App\Filament\Resources\TranslationResource\Pages;

use App\Filament\Helpers\HasParentResource;
use App\Filament\Resources\TranslationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTranslations extends ListRecords
{
    use HasParentResource;

    protected static string $resource = TranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->url(
                    fn (): string => static::getParentResource()::getUrl('translations.create', [
                        'parent' => $this->parent,
                    ])
                ),
        ];
    }
}
