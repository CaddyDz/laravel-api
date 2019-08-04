<?php

namespace App\Mail;

use Illuminate\Notifications\ChannelManager as BaseManager;

class ChannelManager extends BaseManager
{
    /**
     * Create an instance of the mail driver.
     *
     * @return App\Mail\MailChannel
     */
    protected function createMailDriver()
    {
        return $this->app->make(MailChannel::class);
    }
}
