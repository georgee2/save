<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeInteriorItem extends Model
{
    use HasFactory;

    protected $table = 'home_interior_items';
    
    protected $fillable = [
        'interior_gallery_id',
        'ordering',
    ];

    /**
     * Get the interior gallery
     */
    public function gallery()
    {
        return $this->belongsTo(InteriorDesignGallery::class, 'interior_gallery_id');
    }
}
