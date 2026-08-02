<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'user_id',
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
        $modelClass = self::modelForType($this->item_type);
        if (!$modelClass) return null;
        return $this->belongsTo($modelClass, 'item_id');
    }

    public function getItemAttribute()
    {
        $modelClass = self::modelForType($this->item_type);
        if (!$modelClass) return null;
        return $modelClass::find($this->item_id);
    }

    /**
     * The single source of truth for valid item_type values - every place that
     * validates/enumerates item_type (API request validation, groupFavourites,
     * response totals) reads this instead of repeating the list.
     */
    public static function itemTypes(): array
    {
        return array_keys(self::$itemModels);
    }

    public static function modelForType(string $itemType): ?string
    {
        return self::$itemModels[$itemType] ?? null;
    }

    public function emirate()
    {
        return $this->belongsTo(Emirate::class);
    }

    /**
     * The customer account this favourite belongs to (null for pure guests).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
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
        // Logged-in customers use their stable per-account token, so their
        // favourites follow them across devices/sessions (not a per-browser
        // cookie). We deliberately do NOT queue the plaintext cookie here.
        $user = auth()->user();
        if ($user && $user->isCustomer()) {
            return $user->favouritesToken();
        }

        // Guests: persistent 30-day cookie (falls back to session, then a new UUID).
        // The cookie is encrypted, so a tampered value fails to decrypt and arrives as null.
        // The shape check is a second line of defence: this value is written straight into
        // users.favourites_token by FavouriteMergeService when a guest logs in, so anything
        // that is not a UUID we generated is discarded rather than adopted.
        $sessionId = static::sanitiseSessionId(request()->cookie('favourite_session_id'));

        if (!$sessionId) {
            $sessionId = static::sanitiseSessionId(session('favourite_session_id'));
        }

        if (!$sessionId) {
            $sessionId = (string) \Illuminate\Support\Str::uuid();
        }

        session(['favourite_session_id' => $sessionId]);
        cookie()->queue('favourite_session_id', $sessionId, 60 * 24 * 30);

        return $sessionId;
    }

    /**
     * Accept a session id only if it looks like a UUID we minted.
     */
    protected static function sanitiseSessionId($value): ?string
    {
        if (!is_string($value) || !\Illuminate\Support\Str::isUuid($value)) {
            return null;
        }

        return $value;
    }

    public static function countForSession($sessionId)
    {
        return static::forSession($sessionId)->active()->count();
    }

    public static function countForUser($userId)
    {
        return static::forUser($userId)->active()->count();
    }
}
