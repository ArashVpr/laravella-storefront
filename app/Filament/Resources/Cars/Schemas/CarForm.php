<?php

namespace App\Filament\Resources\Cars\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('maker_id')
                    ->relationship('maker', 'name')
                    ->required(),
                Select::make('model_id')
                    ->relationship('model', 'name')
                    ->required(),
                TextInput::make('year')
                    ->required()
                    ->numeric(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('mileage')
                    ->required()
                    ->numeric(),
                TextInput::make('vin')
                    ->required(),
                Select::make('car_type_id')
                    ->relationship('carType', 'name')
                    ->required(),
                Select::make('fuel_type_id')
                    ->relationship('fuelType', 'name')
                    ->required(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Select::make('city_id')
                    ->relationship('city', 'name')
                    ->required(),
                TextInput::make('address')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Toggle::make('is_featured')
                    ->required(),
                DateTimePicker::make('featured_until'),
                DateTimePicker::make('published_at'),
            ]);
    }
}
