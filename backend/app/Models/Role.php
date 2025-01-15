<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role';
    protected $primaryKey = 'idrole';

    protected $fillable = [
        'code', 'description', 'validfrom', 'validto', 'created_on', 'updated_on'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_idrole', 'idrole');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permission', 'role_idrole', 'permission_idpermission');
    }
}