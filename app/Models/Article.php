<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'specialty',
        'scientific_area',
        'title',
        'abstract',
        'keywords',
        'funding_name',
        'grant_id',
    ];

    // Define relationships
    public function titlePage()
    {
        return $this->hasMany(TitlePage::class);
    }

    public function manuscript()
    {
        return $this->hasMany(Manuscript::class);
    }

    public function figures()
    {
        return $this->hasMany(Figure::class);
    }

    public function tables()
    {
        return $this->hasMany(Table::class);
    }

    public function supplementaryFiles()
    {
        return $this->hasMany(SupplementaryFile::class);
    }

    public function coverLetter()
    {
        return $this->hasMany(CoverLetter::class);
    }

    public function authors()
    {
        return $this->hasMany(Author::class);
    }
}
