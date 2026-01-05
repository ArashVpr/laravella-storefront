<?php

namespace App\Filament\Resources\Cars;

use App\Filament\Resources\Cars\Pages\CreateCar;
use App\Filament\Resources\Cars\Pages\EditCar;
use App\Filament\Resources\Cars\Pages\ListCars;
use App\Filament\Resources\Cars\Schemas\CarForm;
use App\Filament\Resources\Cars\Tables\CarsTable;
use App\Models\Car;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;

    protected static ?string $recordTitleAttribute = 'name';
    
    protected static ?string $navigationLabel = 'Cars';
    
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return CarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CarsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCars::route('/'),
            'create' => CreateCar::route('/create'),
            'edit' => EditCar::route('/{record}/edit'),
        ];
    }

    /**
     * @return Builder<Car>
     */
    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
