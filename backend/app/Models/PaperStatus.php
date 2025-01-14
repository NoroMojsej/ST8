<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaperStatus extends Model
{
    use HasFactory;

    // Definuje tabuľku, ak názov modelu nezodpovedá názvu tabuľky
    protected $table = 'paper_status';

    protected $primaryKey = 'idpaper_status';

    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';

    // Umožňuje masové priradenie týchto stĺpcov
    protected $fillable = ['status','status_desc','valid_from','valid_to','created_on', 'updated_on'];

    public function papers()
    {
        return $this->hasMany(Paper::class, 'paper_status_idpaper_status');
    }
}
