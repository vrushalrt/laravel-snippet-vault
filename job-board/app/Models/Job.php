<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    protected $table = 'job_board_jobs';

    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'location', 'salary', 'description', 'experience', 'category'];

    public static array $experience = ['entry', 'intermediate', 'senior'];

    public static array $category = [
        'IT',
        'Finance',
        'Sales',
        'Marketing',
    ];    

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public function jobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    /**
     * Checks if a user has applied for a job.
     *
     * @param Authenticatable|User|int $user The user to check for job application.
     * @return bool True if the user has applied, false otherwise.
     */
    public function hasUserApplied(Authenticatable|User|int $user): bool
    {
        return $this->where('id', $this->id)
            ->whereHas(
                'jobApplications',
                fn($query) => $query->where('user_id', '=', $user->id ?? $user)
            )->exists();
    }

    public function scopeFilter(Builder|QueryBuilder $query, array $filters): Builder|QueryBuilder
    {
        return $query->when($filters['search'] ?? null, function($query, $search) {
            $query->where(function($query) use($search) {
                $query->where('title', 'like', '%'. $search .'%')
                ->orWhere('description', 'like', '%'. $search .'%')
                ->orWhereHas('employer', function($query) use($search) {
                    $query->where('company_name', 'like', '%'. $search .'%');
                    });
                });
            })
            
            ->when($filters['min_salary'] ?? null, function($query, $min_salary){
                $query->where('salary', '>=', $min_salary);
            })
            
            ->when($filters['max_salary'] ?? null, function($query, $max_salary){
                $query->where('salary', '<=', $max_salary);
            })

            ->when($filters['experience'] ?? null, function($query, $experience){
                $query->where('experience', $experience);
            })
            
            ->when($filters['category'] ?? null, function($query, $category){
                $query->where('category', $category);
            })
            
            ;
    }
}
