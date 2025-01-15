<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $table = 'university';
    protected $primaryKey = 'iduniversity';

    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';

    protected $fillable = [
        'code', 'name', 'created_on', 'updated_on', 'country_idcountry'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_idcountry');
    }

    public function faculties()
    {
        return $this->hasMany(Faculty::class, 'university_iduniversity');
    }

    public function conferences()
    {
        return $this->hasMany(Conference::class, 'university_iduniversity');
    }
}