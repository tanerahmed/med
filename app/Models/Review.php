<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'rating_1',
        'reviewer_id_1',
        'rating_2',
        'reviewer_id_2',
        'rating_3',
        'reviewer_id_3',
        // Добавете останалите полета тук...
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
