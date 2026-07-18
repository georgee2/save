<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class CustomerComment extends Model
{
    use LogsActivity;

    protected $table = 'customer_comments';

    protected $fillable = [
        'customer_id',
        'author_id',
        'comment',
    ];

    public function getLogTitle(): ?string
    {
        return \Illuminate\Support\Str::limit($this->comment, 50);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
