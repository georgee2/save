<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUsEmailLog extends Model
{
    protected $table = 'contact_us_email_logs';

    protected $fillable = [
        'contact_us_id',
        'user_id',
        'to_email',
        'subject',
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
