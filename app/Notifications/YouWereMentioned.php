<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class YouWereMentioned extends Notification
{
    use Queueable;

    protected $reply;

    /**
     * Create a new notification instance.
     *
     * @param $reply
     */
    public function __construct($reply)
    {

        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->reply->owner->name . ' mentioned you in ' . $this->reply->thread->title,
            'link' => $this->reply->path()
        ];
    }
}
