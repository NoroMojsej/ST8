<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model // done
{
    protected $table = 'permission';
    protected $primaryKey = 'idpermission';

    protected $fillable = [
        'code', 'description', 'validfrom', 'validto', 'created_on', 'updated_on'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_has_permission', 'permission_idpermission', 'role_idrole', 'idpermission', 'idrole');
    }
}