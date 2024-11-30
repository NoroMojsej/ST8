<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    use HasFactory;

    protected $table = 'conference';

    protected $fillable = [
        'abbreviation', 'submissions_from', 'submissions_to', 'take_place_from', 'take_place_to', 'description', 'country_idcountry', 'university_iduniversity', 'created_on', 'updated_on'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_idcountry');
    }

    public function university()
    {
        return $this->belongsTo(University::class, 'university_iduniversity');
    }

    public function papers()
    {
        return $this->hasMany(Paper::class, 'conference_idconference');
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'conference_has_section', 'conference_idconference', 'section_idsection');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'conference_has_user', 'conference_idconference', 'user_iduser');
    }
}