<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role';

    protected $fillable = [
        'code', 'description', 'validfrom', 'validto', 'created_on', 'updated_on'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_idrole');
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'role_idrole');
    }
}