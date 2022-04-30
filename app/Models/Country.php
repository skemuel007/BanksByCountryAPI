<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code'
    ];

    protected $hidden = [
        'active'
    ];

    public function banks() {
        return $this->hasMany(Bank::class);
    }
}
