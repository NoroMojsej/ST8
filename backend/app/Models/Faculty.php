<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'faculty';

    protected $fillable = [
        'code', 'name', 'university_iduniversity', 'valid_from', 'valid_to', 'created_on', 'updated_on',
    ];

    public function university()
    {
        return $this->belongsTo(University::class, 'university_iduniversity');
    }

    public function departments()
    {
        return $this->hasMany(Department::class, 'faculty_idfaculty');
    }
}