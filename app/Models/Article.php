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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reviwers()
    {
        return $this->hasMany(Review::class);
    }

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

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isAccepted()
    {
        return $this->status === 'accepted';
    }

    public function isAcceptedWithRevision()
    {
        return $this->status === 'accepted with revision';
    }

    public function isDeclined()
    {
        return $this->status === 'declined';
    }


}
