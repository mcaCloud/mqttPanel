<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class userDeleted extends Notification
{
    use Queueable;


    public $user;
    /*Esto es para poder utilizar el objeto user*/
    /*Hay que injectar el usuario en el contructor*/
    /*Todo lo que entre en este constructor como user lo guardamos en la variable de arriba User para que la info se pueda acceder*/
    public function __construct($user){

    $this->user = $user;
        
    }
/****************** VIA *************************/
    /* Via recive el objeto Notifiable por URL y 
    decide el canal que va a utilizar for delivery*/

    public function via($notifiable)
    {
        //Solo quiero notificar al admin que q se borro el mensaje
        return ['database'];
    }

/****************** VIA *************************/
/*
/*
/*
/**************** ToMAIL ***************************/
    /*Este es el canal que se activa con el metodo de VIA*/
    /*Receive a $notifiable entity and should return an Illuminate\Notifications\Messages\MailMessage*/
    /*Aqui se modifica que es lo que va a llevar el mensaje*/
    public function toMail($notifiable)
    {
        /*return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');*/
    }


/**************** toDataBAse ***************************/
/*Utilizamos este metodo porque lo vamos a guardar en la base dedatos*/
    public function toDatabase($notifiable)
    {

            'user_id'=>$this->user->id,
            'name' => $this->user->first_name,
            'email' => $this->user->email

    }
    /****************** toDataBase *************************/
/*
/*
/*
}
