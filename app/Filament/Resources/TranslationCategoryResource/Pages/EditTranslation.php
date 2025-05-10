<?php

namespace App\Filament\Resources\TranslationCategoryResource\Pages;

use App\Filament\Resources\TranslationCategoryResource;
use App\Models\Translation;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Model;

class EditTranslation extends EditRecord
{
    protected static string $resource = TranslationCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('save')->action(fn () => $this->save())
                ->label(__("Save Changes"))
        ];
    }
}
