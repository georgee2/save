<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceFAQ extends Model
{
    use HasFactory;
    
    protected $table = 'service_faqs';
    protected $guarded = [];
    
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    
    public function faq()
    {
        return $this->belongsTo(FAQ::class);
    }
}
