<?php namespace jamx\Events;

use jamx\Events\Event;
use Illuminate\Queue\SerializesModels;

class UserUpdate extends Event
{

    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        //
        $this->user = $user;
    }
}
