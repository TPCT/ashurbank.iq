<?php

namespace App\Filament\Resources\VersionControlResource\Pages;

use App\Filament\Resources\VersionControlResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVersionControls extends ListRecords
{
    protected static string $resource = VersionControlResource::class;

//    protected function getHeaderActions(): array
//    {
//        return [
//            Actions\CreateAction::make(),
//        ];
//    }

}
