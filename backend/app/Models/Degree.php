<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    protected $table = 'degree';
    protected $primaryKey = 'iddegree';

    protected $fillable = [
        'abbreviation', 'description', 'created_on', 'updated_on'  // - úprimne netuším načo created_on', 'updated_on' tam je
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_has_degree', 'degree_iddegree', 'user_iduser', 'iddegree', 'iduser');
    }
}