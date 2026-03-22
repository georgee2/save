<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUsComment extends Model
{
    protected $table = 'contact_us_comments';

    protected $fillable = [
        'contact_us_id',
        'user_id',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
