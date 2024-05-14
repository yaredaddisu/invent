<?php

namespace App\Notifications;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

     public $plan;
          public $price;

    public function __construct($plan,  $price)
    {
        $this->plan = $plan;
      $this->price = $price;

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

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
 

https://www.pipedrive.com/en/blog/9-most-common-transactional-email-templates-examples
        return (new MailMessage)
        ->line($this->plan->user->name)
        ->line('Thank you for placing an payment on Lomi Website. We‘re glad to inform you that we received your payment on Lomi website')
        ->line('በሎሚ ድህረ ገጽ ላይ ክፍያ ስላደረጉ እናመሰግናለን። ክፍያዎን በሎሚ ድህረ ገጽ ላይ እንደደረሰን ስንገልጽልዎት ደስ ብሎናል።')
        ->line('Payed amaunt')
        ->line('የተከፈለ መጠን')
        ->line('ETB '.$this->price )
        ->action('Login', url('https://www.lomifera.com/#/login'))
        ->line('Thank you again for choosing  Lomi Website.
        ');
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
