<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'persmission';  // Note: chyba v databáze, permission nie persmission.

    protected $fillable = [
        'code', 'description', 'validfrom', 'validto', 'created_on', 'updated_on', 'role_idrole'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_idrole');
    }
}