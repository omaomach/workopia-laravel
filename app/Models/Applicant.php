<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Datebase\Eloquent\Relations\BelongsTo;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = ['job_id', 'user_id', 'full_name', 'contact_phone', 'contact_email', 'message', 'location', 'resume_path'];

    // Relation to job
    // An applicant belongs to a Job
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    // Relation to user
    // An applicant belongs to a User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
