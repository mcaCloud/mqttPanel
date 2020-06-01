<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/*tenemos que indicar que esta clase debe de hace broadcast lo antes posible*/
class FormSubmitted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /* Esto representa el PAYLOAD que queremos utilizar para el evento
      * Al ser publico estamos seteando la variable como GLOBAL*/
    public $ejemplo;

    /*Le paso el PAYLOAD que defini dentro del Evento en la ruta de ejemplo
     y entonces la puedo acceder cuando hago el broadcasting*/
    public function __construct($ejemplo)
    {
        $this->ejemplo = $ejemplo;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        /*Esto escucha a traves del canal de la pagina que creamos pusherCluster*/
        /*Ahy tres tipos de canales
            *Public--Cualquiera que este en la pagina puede ver los mensajes. Es este no se cribe PUBLIC solo channel.
            *Private--Necesita autenticacion para poder entrar en le broadcasting
            *Precense--Parecido al private channel pero depende si alguien esta en linea o no
                       Tipo facebook donde te dice si alguien esta en linea o si alguien esta escribiendo algo. Ese tipo de cosas
                       Te dice si una persona esta o no presente
        */
        return new Channel('my-channel');
    }
    /*Esta funcion me deja darle un nombre mas agradeble el EVENT y poder llamarlo por ese nombre
     Si nos fijamos en PUSHER web el EVENT va a venir con este nombre
     Esto evita que usuarios maliciosos vean el (App\Events\....) y tengas mas info de como el proyecto esta estructurado*/
    public function broadcastAs()
    {
        return 'form-submitted';
    }
}
