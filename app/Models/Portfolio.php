<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Portfolio extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'portfolios';
    protected $guarded = [];
    
    protected $casts = [
        'date' => 'date',
    ];
    
    /**
     * Get all portfolios for listing
     */
    public static function list()
    {
        $portfolios = DB::table('portfolios')
            ->join('portfolio_types', 'portfolios.portfolio_type_id', '=', 'portfolio_types.id')
            ->select(
                'portfolios.id', 
                'portfolios.title_english as Title (EN)', 
                'portfolios.title_arabic as Title (AR)',
                'portfolios.main_image as Image',
                'portfolios.client_name as Client',
                'portfolio_types.name_english as Type',
                'portfolios.date as Date',
                DB::raw("CASE WHEN portfolios.status = 0 THEN 'Publish' ELSE 'Not Publish' END as Status"),
                DB::raw("CASE WHEN portfolios.home_status = 0 THEN 'Shown' ELSE 'Not Shown' END as 'Home Status'")
            )
            ->whereNull('portfolios.deleted_at')
            ->orderBy('portfolios.created_at', 'desc')
            ->get();
            
        return $portfolios->map(function ($item) {
            return (array) $item;
        })->toArray();
    }
    
    /**
     * Get trashed portfolios
     */
    public static function trashed()
    {
        $portfolios = DB::table('portfolios')
            ->select(
                'id', 
                'title_english as Title (EN)', 
                'title_arabic as Title (AR)', 
                'client_name as Client', 
                'deleted_at as Deleted At'
            )
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
            
        return $portfolios->map(function ($item) {
            return (array) $item;
        })->toArray();
    }
    
    /**
     * Find portfolio by ID
     */
    public static function find($id)
    {
        return DB::table('portfolios')
            ->join('portfolio_types', 'portfolios.portfolio_type_id', '=', 'portfolio_types.id')
            ->select(
                'portfolios.*',
                'portfolio_types.name_english as type_name_english',
                'portfolio_types.name_arabic as type_name_arabic'
            )
            ->where('portfolios.id', $id)
            ->whereNull('portfolios.deleted_at')
            ->first();
    }
    
    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return $this->status == 0 ? 'Publish' : 'Not Publish';
    }
    
    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute()
    {
        return $this->status == 0 ? 'badge-success' : 'badge-danger';
    }
    
    /**
     * Get home status label
     */
    public function getHomeStatusLabelAttribute()
    {
        return $this->home_status == 0 ? 'Shown' : 'Not Shown';
    }
    
    /**
     * Get home status badge class
     */
    public function getHomeStatusBadgeAttribute()
    {
        return $this->home_status == 0 ? 'badge-success' : 'badge-warning';
    }
    
    /**
     * Relationship: Portfolio belongs to Portfolio Type
     */
    public function portfolioType()
    {
        return $this->belongsTo(PortfolioType::class, 'portfolio_type_id');
    }
    
    /**
     * Relationship: Portfolio has many Portfolio Processes
     */
    public function processes()
    {
        return $this->hasMany(PortfolioProcess::class, 'portfolio_id')->orderBy('order', 'asc');
    }
    
    /**
     * Relationship: Portfolio has many Portfolio Images (Gallery)
     */
    public function images()
    {
        return $this->hasMany(PortfolioImage::class, 'portfolio_id')->orderBy('created_at', 'desc');
    }
}

