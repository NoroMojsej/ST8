<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'review';
    protected $primaryKey = 'idreview';
    public $timestamps = false;

    protected $fillable = [
        'grade1', 'grade2', 'grade3', 'grade4', 'grade5', 'grade6', 'grade7', 'grade8', 'grade9', 'grade10',
        'yesno1', 'yesno2', 'yesno3', 'yesno4', 'yesno5', 'yesno6', 'yesno7', 'yesno8', 'yesno9', 'yesno10', 'yesno11', 'yesno12',
        'txt_plus', 'txt_minus', 'txt_general', 'review_status_idreview_status', 'user_iduser', 'created_on', 'updated_on'
    ];

    public function status()
    {
        return $this->belongsTo(ReviewStatus::class, 'review_status_idreview_status');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_iduser');
    }

    public function papers()
    {
        return $this->hasMany(Paper::class, 'review_idreview');
    }
}