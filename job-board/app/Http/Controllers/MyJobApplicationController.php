<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use Illuminate\Queue\Jobs\Job;

class MyJobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(
            'my_job_application.index',
            [
                'applications' => auth()->user()->jobApplications()
                                    ->with([
                                        'job' => fn($query) => $query
                                                                ->withCount('jobApplications')
                                                                ->withAvg('jobApplications','expected_salary') 
                                                                ->withTrashed(),
                                        'job.employer'
                                        ])
                                    ->latest()->get()
            ]
        );
    }   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobApplication $myJobsApplication)
    {
        $myJobsApplication->delete();
        
        return redirect()->back()->with('success', 'Job application withdrawn.');
    }
}
