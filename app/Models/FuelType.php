<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuelType extends Model
{
    protected $fillable = [
        'name',
    ];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
