<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewStatus extends Model
{
    use HasFactory;

    protected $table = 'paper_status';
    protected $primaryKey = 'idpaper_status';

    public $timestamps = false;
    
    protected $fillable = [
        'status', 'status_desc', 'valid_from', 'valid_to', 'created_on', 'updated_on'
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class, 'review_status_idreview_status');
    }
}