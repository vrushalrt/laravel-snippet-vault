<?php

namespace App\Http\Controllers;

use App\Events\JobEvent;
use App\Http\Requests\JobRequest;
use App\Models\Job;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;

class MyJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAnyEmployer', Job::class);
        
        return view('my_job.index',[ 
            'jobs' => auth()->user()->employer
                        ->jobs()
                        ->with(['employer', 'jobApplications', 'jobApplications.user'])
                        ->withTrashed()
                        ->get() 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Job::class);

        return view('my_job.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobRequest $request)
    {
        $this->authorize('create', Job::class);

        // $validatedData = $request->validate([
        //     'title' => 'required|string|max:255',
        //     'location' => 'required|string|max:255',
        //     'salary' => 'required|numeric|max:500000',
        //     'description' => 'required|string',
        //     'experience' => 'required|in:'. implode(',', Job::$experience),
        //     'category' => 'required|in:' . implode(',', Job::$category)
        // ]);
           
        auth()->user()->employer->jobs()->create($request->validated());

        JobEvent::dispatch(auth()->user()->employer->jobs()->latest()->first(), 'JobPosted');
        // Event(new JobEvent(auth()->user()->employer->jobs()->latest()->first(), 'JOB_POSTED'));

        return redirect()->route('my-jobs.index')
            ->with('success', 'Job created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $myJob)
    {
        $this->authorize('update', $myJob);
        return view('my_job.edit', ['job' => $myJob]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobRequest $request, Job $myJob)
    {
        $this->authorize('update', $myJob);

        $myJob->update($request->validated());

        return redirect()->route('my-jobs.index')
                ->with('success', 'Job updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $myJob)
    {
        $myJob->delete(); // Delete the job permanently.

        return redirect()
                ->route('my-jobs.index')
                ->with('success', 'Job deleted successfully.');
    }
}
