<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CarModel extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'manufacturer',
        'comfort_category'
    ];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function comfortCategory()
    {
        return $this->belongsTo(ComfortCategory::class);
    }
}
