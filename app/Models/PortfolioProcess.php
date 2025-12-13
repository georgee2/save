<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PortfolioProcess extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'portfolio_processes';
    protected $guarded = [];
    
    /**
     * Relationship: Portfolio Process belongs to Portfolio
     */
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class, 'portfolio_id');
    }
}


