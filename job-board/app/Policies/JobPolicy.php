<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JobPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool // Every one can see all the jobs.
    {
        return true;        
    }
 
    /**
     * Determine whether the user can view any models.
     */
    public function viewAnyEmployer(User $user): bool // Every one can see all the jobs.
    {
        return true;        
    }
    
    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Job $job): bool // Every one can see all the jobs.
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool 
    {
        return $user->employer !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Job $job): bool|Response
    {
        if ( $user->employer->user_id !== $user->id ) {
            return false;
        }
        
        if ($job->jobApplications()->count() > 0) {
            return Response::deny('Cannot update the job with applicantions');
        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Job $job): bool
    {
        return $user->employer->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Job $job): bool
    {
        return $user->employer->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Job $job): bool
    {
        return $user->employer->user_id === $user->id;
    }

    /**
     * Determine whether the user can apply for the given job.
     *
     * @param User $user The user attempting to apply for the job.
     * @param Job $job The job the user is attempting to apply for.
     * @return bool True if the user can apply for the job, false otherwise.
     */
    public function apply(User $user, Job $job): bool
    {
        return !$job->hasUserApplied($user);
    }
}
