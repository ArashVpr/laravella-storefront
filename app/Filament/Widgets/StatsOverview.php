<?php

namespace App\Filament\Widgets;

use App\Models\Car;
use App\Models\User;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('Registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make('Total Cars', Car::count())
                ->description('Listed cars')
                ->descriptionIcon('heroicon-m-truck')
                ->color('info'),
            Stat::make('Featured Cars', Car::where('is_featured', true)->count())
                ->description('Currently featured')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),
            Stat::make('Total Revenue', '$' . number_format(Payment::where('status', 'succeeded')->sum('amount') / 100, 2))
                ->description('From featured listings')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
        ];
    }
}
