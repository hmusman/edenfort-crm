<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class reminderMails extends Mailable
{
    use Queueable, SerializesModels;

    public $massage;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($massage)
    {
        $this->massage = $massage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reminder Alert | Edenfort CRM')->view('reminder-mail');
    }
}
