<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplication extends Model
{
    use SoftDeletes;
    protected $table='job_applications';

    protected $fillable = [
        'company_job_id',
        'user_id',
        'resume_path',
        'cover_letter_path',
        'additional_information',
        'status',
        'internal_notes',
        'reviewed_at',
        'reviewed_by',
        'current_salary_currency',
        'current_role',
        'current_salary',
        'years_of_experience',
        'notice_period',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(CompanyJob::class,'company_job_id');
    }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeShortlisted($query)
    {
        return $query->where('status', 'shortlisted');
    }

    public function scopeInterviewing($query)
    {
        return $query->whereIn('status', ['interview_scheduled', 'interviewed']);
    }

    public function scopeHired($query)
    {
        return $query->where('status', 'hired');
    }
}
