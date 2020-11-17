<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\User;
use App\Answer;
use App\Ticket;

class StudentFollowUpEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $user = User::where('email',$notifiable -> email) -> first();
        $tickets = Ticket::where('user_id',$user -> id) -> whereNotNull('item_id') -> get();
        $answers = $user -> answers;
        $connect = $user -> connect;
        $items = [];

        foreach($tickets as $key => $ticket){
            if(!in_array($ticket -> item_id,$items)){
                array_push($items,$ticket -> item_id);
            }
        }
        
        return (new MailMessage)
                    ->subject('Thank you for attending $4YT!!')
                    ->markdown('mail.event',['answers'=>$answers,'items'=>$items,'connects'=>$connect]);
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
