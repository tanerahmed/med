<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Activity Log
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Author extends Model
{
    use HasFactory, LogsActivity;
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['article_id', 'contact_email']);
    }

}
