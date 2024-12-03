<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    //timestamps sa v databaze volaju created_on a updated_on tak som vypla default laravel timestamps created_at, updated_at
    //treba na to mysliet vzdy ked budeme niekde nieco vytvarat/editovat aby sa vytvarali casy rucne cez now()
//    public $timestamps = false;

    protected $table = 'user';

    protected $primaryKey = 'id';

    // Toto bude treba možno ešte upraviť
    protected $fillable = [
        //'username', 'name', 'surname', 'email', 'password', 'country_idcountry', 'department_iddepartment', 'role_idrole', 'created_on', 'updated_on'
        'name', 'surname', 'email', 'password_hash', 'created_on', 'updated_on'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function papers()
    {
        return $this->belongsToMany(Paper::class, 'user_has_paper', 'user_id', 'paper_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    protected $hidden = [
        'password',
    ];
}
