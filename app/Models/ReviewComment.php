<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewComment extends Model
{
    use HasFactory;
    protected $table = 'reviews_coment';

    protected $fillable = [
        'article_id',
        'rating',
        'review_questions',
        'review_comments',
        'file_path',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
