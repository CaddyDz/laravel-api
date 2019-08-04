<?php

namespace App\Mail;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Notifications\Channels\MailChannel as BaseChannel;
use Illuminate\Support\HtmlString;

class MailChannel extends BaseChannel
{
    /**
     * The mailer implementation.
     *
     * @var \Illuminate\Contracts\Mail\Mailer
     */
    protected $mailer;

    /**
     * Create a new mail channel instance.
     *
     * @param  \Illuminate\Contracts\Mail\Mailer  $mailer
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Build the notification's view.
     *
     * @param  \Illuminate\Notifications\Messages\MailMessage  $message
     * @return string|array
     */
    protected function buildView($message)
    {
        return $message->toArray()['actionUrl'];
    }
}
