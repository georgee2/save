<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $table = 'job_applications';

    protected $fillable = [
        'job_id',
        'applicant_name',
        'email',
        'phone',
        'resume',
        'resume_original_name',
        'cover_letter',
        'status',
    ];

    /**
     * Relationship: JobApplication belongs to JobsPosting
     */
    public function job()
    {
        return $this->belongsTo(JobsPosting::class, 'job_id');
    }
}

