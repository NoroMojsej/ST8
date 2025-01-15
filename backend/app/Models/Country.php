<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory; // neviem či to treba úprimne v týchto modeloch, but whatever.

    protected $table = 'country';
    protected $primaryKey = 'idcountry';

    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';

    protected $fillable = [
        'iso_code', 'name', 'valid_from', 'valid_to', 'created_on', 'updated_on',
    ];

    public function universities()
    {
        return $this->hasMany(University::class, 'country_idcountry');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'country_idcountry', 'idcountry');
    }
}