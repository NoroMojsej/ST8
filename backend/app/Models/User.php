<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable // done
{
    use HasFactory, Notifiable, HasApiTokens;

    //timestamps sa v databaze volaju created_on a updated_on tak som vypla default laravel timestamps created_at, updated_at
    //treba na to mysliet vzdy ked budeme niekde nieco vytvarat/editovat aby sa vytvarali casy rucne cez now()
    public $timestamps = false;

    protected $table = 'user';
    protected $primaryKey = 'iduser';

    // toto si upravte keď ste to menili, má tam byť ale všetko.
    protected $fillable = [
        //'username', 'name', 'surname', 'email', 'password', 'country_idcountry', 'department_iddepartment', 'role_idrole', 'created_on', 'updated_on'
        'name', 'surname', 'email', 'password_hash', 'created_on', 'updated_on', 'country_idcountry', 'department_iddepartment', 'role_idrole'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_idcountry', 'idcountry'); // related, FK, ownerkey, relationship (úprimne netuším čo by v relationship malo byť, ak vôbec niečo)
    }

    public function department()
    {
        return $this->belongsTo(Department::class,'department_iddepartment', 'iddepartment');        
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_idrole', 'idrole');
    }

    public function papers()
    {
        return $this->belongsToMany(Degree::class, 'user_has_paper', 'user_iduser', 'paper_idpaper', 'iduser', 'idpaper');
    }

    public function degrees()
    {
       // return $this->belongsToMany(Degree::class, 'user_has_degree', 'user_iduser', 'degree_iddegree'); - možnosť
       return $this->belongsToMany(Degree::class, 'user_has_degree', 'user_iduser', 'degree_iddegree', 'iduser', 'iddegree'); // takto to bude treba podľa všetkého
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    protected $hidden = [
        'password_hash' // mozno to tu padne
    ];

    /**
     * Get the password for the authentication.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password_hash;  // Return the 'password_hash' column instead of 'password'
    }
}
