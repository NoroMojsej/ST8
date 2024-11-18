<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $table = 'section';

    protected $fillable = [
        'text', 'created_on', 'updated_on'
    ];

    public function conferences()
    {
        return $this->belongsToMany(Conference::class, 'conference_has_section', 'section_idsection', 'conference_idconference');
    }
}