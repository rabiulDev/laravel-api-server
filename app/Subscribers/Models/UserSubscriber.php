<?php


namespace App\Subscribers\Models;


use App\Events\Models\User\UserCreated;
use App\Events\Models\User\UserUpdated;
use App\Listeners\SendUserUpdateEmail;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Events\Dispatcher;

class UserSubscriber
{

    public function subscribe(Dispatcher $events)
    {
        $events->listen(UserCreated::class, SendWelcomeEmail::class);
        $events->listen(UserUpdated::class, SendUserUpdateEmail::class);
    }
}
