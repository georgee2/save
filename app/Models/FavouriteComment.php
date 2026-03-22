<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavouriteComment extends Model
{
    protected $table = 'favourite_comments';

    protected $fillable = [
        'session_id',
        'user_id',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
