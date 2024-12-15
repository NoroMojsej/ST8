<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaperStatus extends Model // novinka, done.
{
    protected $table = 'paper_status';
    protected $primaryKey = 'idpaper_status';

    protected $fillable = [
        'status', 'status_desc', 'valid_from', 'valid_to', 'created_on', 'updated_on'
    ];

    public function papers()
    {
        return $this->hasMany(Paper::class, 'paper_status_idpaper_status', 'idpaper_status');
    }
}

class Paper extends Model // done
{
    protected $table = 'paper';
    protected $primaryKey = 'idpaper';

    protected $fillable = [
        'name', 'path_filesystem', 'abstract_lang1', 'abstract_lang2', 'upload_datetime', 'reupload_datetime',
        'keywords_lang1', 'keywords_lang2', 'created_on', 'updated_on',
        'review_idreview', 'conference_idconference', 'section_idsection', 'paper_status_idpaper_status'
    ];


    public function conference()
    {
        return $this->belongsTo(Conference::class, 'conference_idconference', 'idconference');
    }

    public function review()
    {
        return $this->belongsTo(Review::class, 'review_idreview', 'idreview');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_idsection', 'idsection');
    }

    public function paperStatus() // novinka
    {
        return $this->belongsTo(PaperStatus::class, 'paper_status_idpaper_status', 'idpaper_status');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_has_paper', 'paper_idpaper', 'user_iduser', 'idpaper', 'iduser');
    }
}