<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Activity Log
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class XMLFile extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'xml_files';
    protected $fillable = [
        'filename',
        'content', // XML съдържание
        'article_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['id', 'article_id', 'filename']);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
    
}
