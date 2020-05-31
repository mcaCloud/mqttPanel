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
        //
    }


/****************** VIA *************************/
    /* Via recive el objeto Notifiable por URL y 
    decide el canal que va a utilizar for delivery*/
    public function via($notifiable)
    {   
        /* Para poder hacer que el ususario escoja que tipo de comunicacion prefiere
        se crea un campo en la tabla de Usuarios de la base de datos
        notification_preference.*/

        /* Basicamente el notifiable puede acceder a las propiedade s de la tabla users.
            *Solo le pedimos que nos lea la opcion del campo de preferencias en la base de datos para saber como prefiere ser contactado el user
            *En la base de datos se pueden agregar campos en forma de array separados con una coma
        */
        return explode(',', $notifiable->notification_preference);

        /* Esto es como el stack de formas de notificar al usuario*/
        /* Si se queire escojer cada opcion manualmente es asi*/
        //return ['database'];
    }
/****************** VIA *************************/
/*
/*
/*
/**************** ToMAIL ***************************/
    /*Este es el canal que se activa con el metodo de VIA*/
    /*Receive a $notifiable entity and should return an Illuminate\Notifications\Messages\MailMessage*/
    /*Aqui se modifica que es lo que va a llevar el mensaje*/

    function toMail($notifiable)
    {
        return (new MailMessage)
                    
                    /*En caso de que se quiera informar a los usuarios sobre un error*/
                    ->error()
                    ->subject('Order Status')
                    ->from('sender@example.com', 'Sender')
                    ->greeting('Hello!') 
                    ->line('Your order status has been updated')
                    ->action('Check it out', url('/'))
                    ->line('Best regards!');
    }
/**************** /ToMAIL ***************************/



    /*Utilizamos este metodo porque lo vamos a guardar en la base dedatos*/
    public function toDatabase($notifiable)
    {
        return [
            /*Esta variable guarda el ID del user que la envio*/
            /*Funciona muy bien cuando necesito saber tema defollowers que suscriben*/
            'user_id'=>$this->user->id,
            'name' => $this->user->first_name,
            'email' => $this->user->email,
            'subject' => 'Usuarios eliminado',
            'place' => 'el sistema',
            'action' => 'eliminado',       
        ];
    }
}
