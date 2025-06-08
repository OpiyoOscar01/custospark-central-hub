<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JobSkill extends Model
{
    protected $fillable = [
        'name',
        'category',
    ];

    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(CompanyJob::class, 'job_required_skills')
            ->withPivot('level', 'is_required')
            ->withTimestamps();
    }

    public function applicants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'applicant_skills')
            ->withPivot('level', 'description', 'years_experience')
            ->withTimestamps();
    }
}
