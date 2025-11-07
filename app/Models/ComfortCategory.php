<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ComfortCategory extends Model
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
        'level',
    ];

    public function positions()
    {
        return $this->belongsTo(Position::class, 'position_comfort_category');
    }

    public function carModels()
    {
        return $this->hasMany(Car::class);
    }
}
