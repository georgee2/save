<?php

namespace App\Models\Analytics;

use Illuminate\Database\Eloquent\Model;

class AnalyticsVisitor extends Model
{
    protected $table = 'analytics_visitors';
    protected $guarded = [];

    protected $casts = [
        'first_visit_at' => 'datetime',
        'last_visit_at' => 'datetime',
    ];

    public function sessions()
    {
        return $this->hasMany(AnalyticsSession::class, 'visitor_id', 'visitor_id');
    }

    public function pageViews()
    {
        return $this->hasMany(AnalyticsPageView::class, 'visitor_id', 'visitor_id');
    }
}
