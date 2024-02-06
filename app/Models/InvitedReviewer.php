<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitedReviewer extends Model
{
    use HasFactory;

    protected $fillable = ['article_id', 'user_id', 'rejected'];
    
    public static function saveInvitedReviewer($articleId, $userId)
    {
        // Проверяваме дали вече не съществува запис с дадените article_id и user_id
        $existingInvitation = InvitedReviewer::where('article_id', $articleId)->where('user_id', $userId)->first();

        if (!$existingInvitation) {
            // Ако не съществува, създаваме нов запис
            InvitedReviewer::create([
                'article_id' => $articleId,
                'user_id' => $userId,
            ]);

            return true; // Успешно създаден запис
        }

        return false; // Записът вече съществува
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
