<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFcmToken extends Model
{
    protected $fillable = [
        'user_id',
        'token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Attach $token to $userId, enforcing two invariants: a token belongs to at
     * most one user (a shared/re-logged-in device reassigns rather than
     * duplicating), and a user has at most one token (logging in on a new device
     * replaces the old one - only the latest device gets push notifications).
     */
    public static function saveForUser(int $userId, string $token): void
    {
        static::where('token', $token)->orWhere('user_id', $userId)->delete();
        static::create(['user_id' => $userId, 'token' => $token]);
    }
}
