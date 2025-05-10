<?php

namespace App\Filament\Resources\BranchResource\Widgets;

use App\Models\Branch;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BranchesWidget extends BaseWidget
{
    protected static ?string $pollingInterval = "5s";

    protected function getStats(): array
    {
        return [
            Stat::make(__("Branches"), function (){
                return Branch::count();
            })->icon('zondicon-location'),
            Stat::make(__("Active Branches"), function(){
                return Branch::active()->count();
            })->icon('zondicon-location'),
            Stat::make('active Atms', function (){
                return Branch::active()->where('is_atm', true)->count();
            })->icon('zondicon-location'),
        ];
    }
}
