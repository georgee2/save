<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeProjectItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_project_setting_id',
        'project_id',
        'ordering',
    ];

    /**
     * Get the setting for this item
     */
    public function setting()
    {
        return $this->belongsTo(HomeProjectSetting::class, 'home_project_setting_id');
    }

    /**
     * Get the project for this item
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
