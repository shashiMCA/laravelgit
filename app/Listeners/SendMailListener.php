<?php

namespace App\Listeners;

use Mail;
use App\Mail\VeryfyUserByMail;
use App\Events\RegisterMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailListener
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
     * @param  RegisterMail  $event
     * @return void
     */
    public function handle(RegisterMail $event)
    {
        $user= $event->user;
        
      Mail::to($user->email)->send(new VeryfyUserByMail($user));

       
    }
}
