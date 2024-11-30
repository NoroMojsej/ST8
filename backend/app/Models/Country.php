<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'country';

    protected $fillable = [
        'iso_code', 'name', 'valid_from', 'valid_to', 'created_on', 'updated_on',
    ];

    public function universities()
    {
        return $this->hasMany(University::class, 'country_idcountry');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'country_idcountry');
    }
}