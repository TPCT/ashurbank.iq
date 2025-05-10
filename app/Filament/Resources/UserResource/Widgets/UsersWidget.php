<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UsersWidget extends BaseWidget
{
    protected static ?string $pollingInterval = "5s";

    protected function getStats(): array
    {
        return [
            Stat::make(__("Users"), function (){
                return User::count();
            })->icon('heroicon-s-users'),
            Stat::make(__("Active Users"), function(){
                return User::whereBanned(0)->count();
            })->icon('heroicon-s-users'),
            Stat::make(__("Banned Users"), function(){
                return User::whereBanned(1)->count();
            })->icon('heroicon-s-users'),
        ];
    }
}
