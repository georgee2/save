<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class CustomerEmailLog extends Model
{
    use LogsActivity;

    protected $logTitleField = 'subject';

    protected $table = 'customer_email_logs';

    protected $fillable = [
        'customer_id',
        'sent_by',
        'to_email',
        'cc_email',
        'subject',
        'body',
        'attachments',
        'type',
        'status',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }
}
