<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowcaseTeam extends Model
{
    use HasFactory;
    
    protected $table = 'showcase_team';
    protected $guarded = [];
    
    /**
     * Get the showcase that owns the relation
     */
    public function showcase()
    {
        return $this->belongsTo(Showcase::class);
    }
    
    /**
     * Get the team member that owns the relation
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}

