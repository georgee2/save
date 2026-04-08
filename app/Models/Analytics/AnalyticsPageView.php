<?php

namespace App\Models\Analytics;

use Illuminate\Database\Eloquent\Model;

class AnalyticsPageView extends Model
{
    protected $table = 'analytics_page_views';
    protected $guarded = [];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    public function session()
    {
        return $this->belongsTo(AnalyticsSession::class, 'session_id', 'session_id');
    }

    public function visitor()
    {
        return $this->belongsTo(AnalyticsVisitor::class, 'visitor_id', 'visitor_id');
    }
}
