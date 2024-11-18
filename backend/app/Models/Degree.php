<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    use HasFactory;

    protected $table = 'degree';

    protected $fillable = [
        'abbreviation', 'description'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_has_degree', 'degree_iddegree', 'user_iduser');
    }
}