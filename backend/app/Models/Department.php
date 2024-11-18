<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'department';

    protected $fillable = [
        'code', 'name', 'valid_from', 'valid_to', 'faculty_idfaculty', 'created_on', 'updated_on',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_idfaculty');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'department_iddepartment');
    }
}