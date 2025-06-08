<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyJob extends Model
{
    // use SoftDeletes;

    protected $model = 'company_jobs';

    protected $fillable = [
        'title',
        'description',
        'requirements',
        'responsibilities',
        'location',
        'type',
        'experience_level',
        'salary_min',
        'salary_max',
        'salary_currency',
        'is_remote',
        'department',
        'positions_available',
        'deadline',
        'status',
        'created_by',
    ];

    protected $casts = [
        'is_remote'  => 'boolean',
        'deadline'   => 'datetime',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

        public static function getUniqueLocations(): array
    {
        return self::distinct()->pluck('location')->toArray();
    }
    public static function getUniqueDepartments(): array
    {
        return self::distinct()->pluck('department')->toArray();
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('deadline')
                    ->orWhere('deadline', '>', now());
            });
    }

    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'closed');
    }

    public function getSalaryRangeAttribute(): string
    {
        if (! $this->salary_min && ! $this->salary_max) {
            return 'Competitive';
        }

        if (! $this->salary_max) {
            return "From {$this->salary_currency} {$this->salary_min}";
        }

        if (! $this->salary_min) {
            return "Up to {$this->salary_currency} {$this->salary_max}";
        }

        return "{$this->salary_currency} {$this->salary_min} - {$this->salary_max}";
    }

    public function isOpen(): bool
    {
        return $this->status === 'published' &&
            (! $this->deadline || $this->deadline->isFuture());
    }
}
