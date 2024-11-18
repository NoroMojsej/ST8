<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable 
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'user';

    protected $primaryKey = 'iduser';

    // Toto bude treba možno ešte upraviť
    protected $fillable = [
        'username', 'email', 'name', 'surname', 'country_idcountry', 'department_iddepartment', 'role_idrole', 'created_on', 'updated_on'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_idcountry');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_iddepartment');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_idrole');
    }

    public function papers()
    {
        return $this->belongsToMany(Paper::class, 'user_has_paper', 'user_iduser', 'paper_idpaper');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_iduser');
    }

    protected $hidden = [
        'password',
    ];
}
