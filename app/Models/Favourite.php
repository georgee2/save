<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $fillable = [
        'session_id',
        'item_type',
        'item_id',
        'emirate_id',
        'price',
        'name',
        'email',
        'mobile',
        'lead_id',
        'sales_agent_id',
        'is_permanent',
        'expires_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_permanent' => 'boolean',
        'expires_at' => 'datetime',
    ];

    protected static $itemModels = [
        'project' => Project::class,
        'offer' => Offer::class,
        'interior' => InteriorDesignGallery::class,
    ];

    public function item()
    {
        $modelClass = self::$itemModels[$this->item_type] ?? null;
        if (!$modelClass) return null;
        return $this->belongsTo($modelClass, 'item_id');
    }

    public function getItemAttribute()
    {
        $modelClass = self::$itemModels[$this->item_type] ?? null;
        if (!$modelClass) return null;
        return $modelClass::find($this->item_id);
    }

    public function emirate()
    {
        return $this->belongsTo(Emirate::class);
    }

    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->where('is_permanent', true)
              ->orWhere('expires_at', '>', now());
        });
    }

    public function scopeExpired($query)
    {
        return $query->where('is_permanent', false)
                     ->where('expires_at', '<=', now());
    }

    public function isExpired()
    {
        return !$this->is_permanent && $this->expires_at && $this->expires_at->isPast();
    }

    public static function getSessionId()
    {
        $sessionId = request()->cookie('favourite_session_id');

        if (!$sessionId) {
            $sessionId = session('favourite_session_id');
        }

        if (!$sessionId) {
            $sessionId = (string) \Illuminate\Support\Str::uuid();
        }

        session(['favourite_session_id' => $sessionId]);
        cookie()->queue('favourite_session_id', $sessionId, 60 * 24 * 30);

        return $sessionId;
    }

    public static function countForSession($sessionId)
    {
        return static::forSession($sessionId)->active()->count();
    }
}
