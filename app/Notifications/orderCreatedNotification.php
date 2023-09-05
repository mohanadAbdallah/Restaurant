<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class orderCreatedNotification extends Notification implements ShouldBroadcast
{

    public $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database','broadcast'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'id' => $this->order->id,
            'order_number'=>$this->order->number,
            'created_at'=>$this->order->created_at,
            'total' => $this->order->total,
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Order')
            ->line('New Order Added To your restaurant.')
            ->action('Go To Dashboard', url('/dashboard'))
            ->line('Thank you for using our application!');
    }



    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
           'body' => "lkjdhfjkldfs",
        ]);
    }

}
