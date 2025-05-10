<?php

namespace App\Filament\Resources\AuditResource\Pages;

use App\Filament\Resources\AuditResource;
use App\Models\Audit;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAudits extends ListRecords
{
    protected static string $resource = AuditResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('clear_audits')
                ->label(__("Clear Audits"))
                ->action(function (){
                    return Audit::whereDate('created_at', '<', Carbon::today()->subDays(30))->delete();
                })
        ];
    }
}
