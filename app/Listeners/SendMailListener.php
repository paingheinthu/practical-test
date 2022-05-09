<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if (empty($event?->email) && empty($event?->message)) {
            Log::error('can not send the mail to empty address or empty message');
            return;
        }
        $email = $event->email;
        $message = $event->message;
        Log::debug($email . " " . $message);
        try {
            Mail::raw($message, function ($message) use ($email) {
                $message->from(config('mail.from.address'))
                    ->subject("survey practical test")
                    ->to($email);
            });
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
