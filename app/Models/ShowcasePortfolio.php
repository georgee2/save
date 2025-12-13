<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowcasePortfolio extends Model
{
    use HasFactory;
    
    protected $table = 'showcase_portfolio';
    protected $guarded = [];
    
    /**
     * Get the showcase that owns the relation
     */
    public function showcase()
    {
        return $this->belongsTo(Showcase::class);
    }
    
    /**
     * Get the portfolio that owns the relation
     */
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}

