<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    public $timestamps = false;

    protected $table = 'user';

    protected $primaryKey = 'iduser'; 

    protected $fillable = [
        'name', 'surname', 'email', 'password_hash', 'created_on', 'updated_on', 'country_idcountry', 'department_iddepartment', 'role_idrole'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_idcountry', 'idcountry');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_iddepartment', 'iddepartment');
    }

    public function faculty()
    {
        return $this->hasOneThrough(
            Faculty::class,
            Department::class,
            'iddepartment',    
            'idfaculty',       
            'department_iddepartment', 
            'idfaculty'        
        );
    }

    public function university()
    {
        return $this->hasOneThrough(
            University::class,
            Faculty::class,
            'idfaculty',       
            'iduniversity',    
            'faculty_idfaculty', 
            'iduniversity'     
        );
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_idrole'); 
    }

    public function papers()
    {
        return $this->belongsToMany(Paper::class, 'user_has_paper', 'user_id', 'paper_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }
    public function degrees()
    {
        return $this->belongsToMany(Degree::class, 'user_has_degree', 'user_iduser', 'degree_iddegree');
    }

    /**
     * Get the password for the authentication.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
