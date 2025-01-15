<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $table = 'section';
    protected $primaryKey = 'idsection';

    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';

    protected $fillable = [
        'text', 'created_on', 'updated_on'
    ];

    public function conferences()
    {
        return $this->belongsToMany(Conference::class, 'conference_has_section', 'section_idsection', 'conference_idconference');
    }
    
}