<?php

namespace App\Listeners;

use App\Events\Models\User\UserUpdated;
use App\Mail\UserUpdatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendUserUpdateEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserUpdated  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to($event->user)->send(new UserUpdatedMail($event->user));
    }
}
