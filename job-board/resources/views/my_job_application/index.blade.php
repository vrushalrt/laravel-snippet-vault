<x-layout>
    <x-breadcrumbs class="mb-4" :links="['My Jobs Applications' => '#']" />

    @forelse ($applications as $application)
        <x-job-card :job="$application->job">
            <div class="flex items-center justify-between text-xs text-slate-500">
                <div>
                    <div>
                        Applied on {{ $application->created_at->diffForHumans()}}
                    </div>
                    <div>
                        Other {{ Str::plural('applicat', $application->job->job_applications_count - 1) }} {{$application->job->job_applications_count - 1}}
                    </div>
                    <div>
                        Yours asking salary is ${{ number_format($application->expected_salary) }}
                    </div>
                    <div>
                        Average asking salary is ${{ number_format($application->job->job_applications_avg_expected_salary) }}
                    </div>
                </div>
                <div>
                    <form action="{{ route('my-jobs-applications.destroy', $application) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-button>Cancel</x-button>

                    </form>
                </div>
            </div>
        </x-job-card>
    @empty
        <div class="rounded-md border border-dashed border-slate-300 py-8">
            <div class="text-center font-medium">
                No job applications yet.
            </div>
            <div class="text-center">
                Find some jobs <a class="text-indigo-500 hover:underline" href="{{route('jobs.index')}}">here😀!</a> 
            </div>
        </div>
    @endforelse
        
</x-layout>