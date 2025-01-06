<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;

    protected $table = 'paper';
    protected $primaryKey = 'idpaper';
    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';

    protected $fillable = [
        'name', 'path_filesystem', 'abstract_lang1', 'abstract_lang2', 'upload_datetime', 'reupload_datetime', 'keywords_lang1', 'keywords_lang2', 'status', 'review_idreview', 'conference_idconference', 'created_on', 'updated_on'
    ];

    public function conference()
    {
        return $this->belongsTo(Conference::class, 'conference_idconference');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_idsection');
    }

    public function review()
    {
        return $this->belongsTo(Review::class, 'review_idreview');
    }
    
    public function paper_status()
    {
        return $this->belongsTo(ReviewStatus::class, 'paper_status_idpaper_status');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_has_paper', 'paper_idpaper', 'user_iduser');
    }
}