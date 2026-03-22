<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavouriteEmailLog extends Model
{
    protected $table = 'favourite_email_logs';

    protected $fillable = [
        'session_id',
        'user_id',
        'to_email',
        'cc_email',
        'subject',
        'body',
        'attachments',
        'type',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
