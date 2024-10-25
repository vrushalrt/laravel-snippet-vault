<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $job = Job::query();
        
        // $job->when(request()->get('search'), function($query){
        //     $query->where(function($query){
        //         $query->where('title', 'like', '%'. request()->get('search') .'%')
        //         ->orWhere('description', 'like', '%'. request()->get('search') .'%');
        //     });
        //     })
        //     ->when(request()->get('min_salary'), function($query){
        //         $query->where('salary', '>=', request()->get('min_salary'));
        //     })
            
        //     ->when(request()->get('max_salary'), function($query){
        //         $query->where('salary', '<=', request()->get('max_salary'));
        //     })

        //     ->when(request()->get('experience'), function($query){
        //         $query->where('experience', request()->get('experience'));
        //     })
            
        //     ->when(request()->get('category'), function($query){
        //         $query->where('category', request()->get('category'));
        //     })
            
        //     ;

        // return view('job.index', ['jobs' => $job->get()]);
        $this->authorize('viewAny', Job::class);

        $filter = request()->only('search', 'min_salary', 'max_salary', 'experience', 'category');

        return view('job.index', 
            ['jobs' => Job::with('employer')->latest()->filter($filter)->get()]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        $this->authorize('view', $job);
        // return view('job.show', compact('job'));
        return view('job.show', 
            ['job' => $job->load('employer.jobs')]
        );
    }

}
