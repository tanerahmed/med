<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manuscript extends Model
{
    use HasFactory;
    protected $fillable = ['file_path'];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
