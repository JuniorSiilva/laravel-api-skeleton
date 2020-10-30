<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification as BaseSendEmailVerificationNotification;

class SendEmailVerificationNotification extends BaseSendEmailVerificationNotification implements ShouldQueue
{
    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'users';
}
