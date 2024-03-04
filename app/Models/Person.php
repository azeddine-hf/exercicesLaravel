<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    protected $table = 'people';
    protected $fillable = ['name', 'city_id'];
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
