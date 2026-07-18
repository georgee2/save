<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Local mirror row for an ERPNext project (see migration + master plan section 5.2).
 * Not the source of truth; kept in sync from ERP for fast listing/filtering.
 */
class CustomerProject extends Model
{
    protected $fillable = [
        'user_id',
        'erp_project_id',
        'name',
        'status',
        'progress_percent',
        'contract_ref',
        'last_synced_at',
    ];

    protected $casts = [
        'progress_percent' => 'integer',
        'last_synced_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
