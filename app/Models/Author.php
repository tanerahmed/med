<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'middle_name',
        'family_name',
        'primary_affiliation',
        'contact_email',
        'author_contributions',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
