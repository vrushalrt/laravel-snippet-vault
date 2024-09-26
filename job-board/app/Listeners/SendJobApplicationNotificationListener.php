<?php

namespace App\Listeners;

use App\Events\JobApplicationEvent;
use App\Events\JobEvent;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class SendJobApplicationNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(JobApplicationEvent $event): void
    {
        info('Job Posted JobApplicationEvent: '. $event->action .'  User: ');
    }

    public function handleJobPosted($job): void
    {
       
    }
}
