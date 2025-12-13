<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Card extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'cards';
    protected $guarded = [];
    
    /**
     * Relationship: Card belongs to Home Block
     */
    public function homeBlock()
    {
        return $this->belongsTo(HomeBlock::class, 'home_block_id');
    }
    
    /**
     * Get all cards for listing
     */
    public static function list()
    {
        return DB::table('cards')
            ->leftJoin('home_blocks', 'cards.home_block_id', '=', 'home_blocks.id')
            ->select(
                'cards.id',
                'cards.card_type',
                'cards.title_english',
                'cards.title_arabic',
                'cards.icon_dark',
                'cards.icon_white',
                'cards.background',
                'cards.status',
                'home_blocks.title_english as home_block_title_en',
                'home_blocks.title_arabic as home_block_title_ar',
                'cards.created_at',
                'cards.updated_at'
            )
            ->whereNull('cards.deleted_at')
            ->orderBy('cards.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed cards
     */
    public static function trashed()
    {
        return DB::table('cards')
            ->leftJoin('home_blocks', 'cards.home_block_id', '=', 'home_blocks.id')
            ->select(
                'cards.id',
                'cards.card_type',
                'cards.title_english',
                'cards.title_arabic',
                'home_blocks.title_english as home_block_title_en',
                'cards.status',
                'cards.deleted_at'
            )
            ->whereNotNull('cards.deleted_at')
            ->orderBy('cards.deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Get card type display name
     */
    public function getCardTypeDisplayAttribute()
    {
        $types = [
            'card_with_background' => 'Card with Background',
            'icon_card' => 'Icon Card'
        ];
        
        return $types[$this->card_type] ?? $this->card_type;
    }
    
    /**
     * Get status display name
     */
    public function getStatusDisplayAttribute()
    {
        return $this->status == 0 ? 'Active' : 'Not Active';
    }
}

