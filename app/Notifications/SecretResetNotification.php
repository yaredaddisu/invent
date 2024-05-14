<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SecretResetNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $user;  

    public function __construct($token,$user)
    {
        $this->user = $user;
         $this->token = $token;
    }
   

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

   
    
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->greeting('Hello, '.$this->user->name)
                ->line('The support team received your request to reset your password.
                copy and paste the following token .')
                ->line($this->token);
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
            'user' => $this->user,
            'token' => $this->token,

        ];
    }
}
