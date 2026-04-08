<?php

namespace App\Models\Analytics;

use Illuminate\Database\Eloquent\Model;

class AnalyticsSession extends Model
{
    protected $table = 'analytics_sessions';
    protected $guarded = [];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'is_bounce' => 'boolean',
    ];

    public function visitor()
    {
        return $this->belongsTo(AnalyticsVisitor::class, 'visitor_id', 'visitor_id');
    }

    public function pageViews()
    {
        return $this->hasMany(AnalyticsPageView::class, 'session_id', 'session_id');
    }
}
