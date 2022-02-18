<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StatusUpdate extends Notification
{
    use Queueable;
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('New Post has registered: ' . $this->post->title)
            ->action('Notification Action',$this->post['url']);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
