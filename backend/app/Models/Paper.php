<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;

    protected $table = 'paper';

    protected $fillable = [
        'name', 'path_filesystem', 'abstract_lang1', 'abstract_lang2', 'upload_datetime', 'reupload_datetime', 'keywords_lang1', 'keywords_lang2', 'status', 'review_idreview', 'conference_idconference', 'created_on', 'updated_on'
    ];

    public function conference()
    {
        return $this->belongsTo(Conference::class, 'conference_idconference');
    }

    public function review()
    {
        return $this->belongsTo(Review::class, 'review_idreview');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_has_paper', 'paper_idpaper', 'user_iduser');
    }
}