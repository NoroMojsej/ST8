<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'section';
    protected $primaryKey = 'idsection';

    protected $fillable = [
        'text', 'created_on', 'updated_on'
    ];

    public function papers()
    {
        return $this->hasMany(Paper::class, 'section_idsection', 'idsection');
    }

    public function conferences()
    {
        return $this->belongsToMany(Conference::class, 'conference_has_section', 'section_idsection', 'conference_idconference', 'idsection', 'idconference'); // možno, vraj parent a related keys netreba, uvidíme.
    }
}