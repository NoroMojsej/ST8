<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasPaper extends Model
{
    protected $table = 'user_has_paper';

    public function paper()
    {
        return $this->belongsTo(Paper::class, 'paper_idpaper', 'idpaper');
    }
}
