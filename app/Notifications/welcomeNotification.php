<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class welcomeNotification extends Notification
{
    use Queueable;

    public $user;
    /*Esto es para poder utilizar el objeto user*/
    /*Hay que injectar el usuario en el contructor*/
    /*Todo lo que entre en este constructor como user lo guardamos en la variable de arriba User para que la info se pueda acceder*/
    public function __construct(User $user){

    $this->user = $user;
        //
    }


/****************** VIA *************************/
    /* Via recive el objeto Notifiable por URL y 
    decide el canal que va a utilizar for delivery*/
    public function via($notifiable)
    {
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

    function toMail($notifiable)
    {
        return (new MailMessage)
                    
                    /*En caso de que se quiera informar a los usuarios sobre un error*/
                    ->error()
                    ->subject('Te damos la bienvenida!!')
                    ->from('no_reply@example.com', 'Sender')
                    ->line('Tu cuenta ha sido creada con éxito. Ya eres parte de equipo.')
                    ->action('Ingresa aquí', url('/'));

                    
                    
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
            'email' => $this->user->email
            
        ];
    }
}
