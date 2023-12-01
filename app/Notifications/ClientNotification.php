<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class ClientNotification extends Notification
{
    protected $title_ar;
    protected $title_en;
    protected $content_ar;
    protected $content_en;
    protected $code;

    public function __construct($data)
    {
        $this->title_ar = $data["title_ar"];
        $this->title_en = $data["title_en"];
        $this->content_ar = $data["content_ar"];
        $this->content_en = $data["title_en"];
        $this->code = $data["code"];
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
            "title_ar" => $this->title_ar,
            "title_en" => $this->title_en,
            "content_ar" => $this->content_ar,
            "content_en" => $this->content_en,
            "code" => $this->code
        ];
    }
}
