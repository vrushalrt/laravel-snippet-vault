<?php

namespace App\Listeners;

use App\Events\JobEvent;
use App\Models\User;
use App\Notifications\JobEmailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use InvalidArgumentException;

class SendJobNotificationListener
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
    public function handle(JobEvent $event): void
    {
        match($event->action)
        {
            JobEvent::JOB_POSTED => $this->handleJobPosted($event->job),

            default => throw new InvalidArgumentException('Invalid job event action.')
        };
    }

    public function handleJobPosted($job): void
    {
        $users = User::doesntHave('employer')->get();

        $users->each(function($user) use ($job) {
            $user->notify(
                new JobEmailNotification($job, $user)
            );

            // info('Job Email Notification sent to: '.$users->email);
        });
    }

}
