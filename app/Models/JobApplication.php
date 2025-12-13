<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $table = 'job_applications';
    protected $guarded = [];

    /**
     * Relationship: JobApplication belongs to JobsPosting
     */
    public function job()
    {
        return $this->belongsTo(JobsPosting::class, 'job_id');
    }
}

