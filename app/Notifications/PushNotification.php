<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class PushNotification extends Notification
{
    use Queueable;

    public $title;
    public $message;
    public $buttonText;
    public $buttonURL;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $message, $buttonText, $buttonURL)
    {
        $this->title = $title;
        $this->message = $message;
        $this->buttonText = $buttonText;
        $this->buttonURL = $buttonURL;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toWebPush($notifiable, $notification)
    {
        $push = (new WebPushMessage)
            ->title($this->title)
            ->icon('assets/images/logo.png')
            ->action($this->buttonText, $this->buttonURL);

        if (!empty($this->message)) {
            $push = $push->body($this->message);
        }

        return $push;
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
            //
        ];
    }
}
