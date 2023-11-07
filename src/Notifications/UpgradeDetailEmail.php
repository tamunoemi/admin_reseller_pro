<?php

namespace Teckipro\Admin\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpgradeDetailEmail extends Notification
{
    use Queueable;

    private $body;
    private $param;

    /**
     * Create a new notification instance.
     *@param
     *name,
     * @return void
     */
    public function __construct($param)
    {
        $this->param = $param;
        $packagename = $param['name'];

        $this->body = "Your account has been upgraded to $packagename";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
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

        $data['body'] = $this->body;
        $data['url'] = $url;

        return (new MailMessage)
         ->subject('Login Details ('.env("APP_NAME").')')
         ->markdown('teckiproadmin::mail.upgradedetail',$data);
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
            'data'=>$this->body
        ];
    }
}
