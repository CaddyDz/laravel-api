<?php

namespace App\Mail;

use Swift_Mailer;
use Illuminate\Events\Dispatcher;
use Illuminate\Mail\Mailer as BaseMailer;

class Mailer extends BaseMailer
{
    /**
     * Create a new Mailer instance.
     *
     * @param  \Swift_Mailer  $swift
     * @param  \Illuminate\Contracts\Events\Dispatcher|null  $events
     * @return void
     */
    public function __construct(Swift_Mailer $swift, Dispatcher $events = null)
    {
        $this->swift = $swift;
        $this->events = $events;
    }

    /**
     * Render the given view.
     *
     * @param  string  $view
     * @param  array  $data
     * @return string
     */
    protected function renderView($view, $data)
    {
        return $data['actionUrl'];
    }
}
