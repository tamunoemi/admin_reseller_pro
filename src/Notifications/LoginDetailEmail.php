<?php

namespace Teckipro\Admin\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginDetailEmail extends Notification
{
    use Queueable;

    public $password;
    public $email;
    public $user_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($arg)
    {
        $this->email = $arg['email'];
        $this->password = $arg['password'];
        $this->user_id = $arg['user_id'];
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
        $url = env("APP_URL");

        $data['url'] = $url;
        $data['password'] = $this->password;
        $data['email'] = $this->email;

        return (new MailMessage)
         ->subject('Login Details ('.env("APP_NAME").')')
         ->markdown('teckiproadmin::mail.logindetail',$data);

    }


}
