<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ImportJobStatusNotification extends Notification
{
    public $status, $errorMessage;
    /**
     * Create a new notification instance.
     */
    public function __construct($status, $errorMessage)
    {
        $this->status = $status;
        $this->errorMessage = $errorMessage;
    }

    public function via($notifiable){
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'status' => $this->status,
            'errorMessage' => $this->errorMessage,
        ];
    }
}
