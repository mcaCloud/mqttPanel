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
/*ShouldBroadcast interface and this tells Laravel that this event should be broadcasted using whatever driver we have set in the configuration file.*/
class userUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /* Esto representa el PAYLOAD que queremos utilizar para el evento
      * Al ser publico estamos seteando la variable como GLOBAL*/
    /* It is important to set the visibility of the properties to public; if you don't, the property will be ignored by de constructor*/
    /*Como en este caso lo que deseo es la informacion del usuario que ha sido creado pues llamo a la variable USER*/
    public $user;

    //Esta la creo especificamente para guardar el usuario de quien realiza la accion
    public $authUser;
    /*IMIPORTANTE*/
    /*Esta variable es publica porque la necesito utilizar en el front end. Le voy a asignar un valor string que va a representar el tipo de actualizacion del USER*/
    /*La variable se crea directamente en cada metodo*/
    /*Voy a comenzar a trabajarla con una, denspues intento hacerlo array*/
    /*Cada variable puede representar unatabla dentro de la base de datos, solo asegurarse de las relaciones en los modelos*/
    public $state;
    /*Esta variable me trabaja los atributos de la tabla de ROLES, ya en el modelo le asigno los atributos pero aqui la declaro para poder usarla despues*/
    public $role;

    /*Le paso el PAYLOAD que defini dentro del Evento en la ruta de ejemplo
     y entonces la puedo acceder cuando hago el broadcasting*/
     /*We also have a constructor that accepts two parameters, username and verb.*/
    public function __construct($user,$state,$role,$authUser)
    {
       /*Para poder utilizar las variables todas tienen que estar declaradas dentro des constructor del metodo
       Los valores de STATE se los asigno dentro del controlador. Es solo como un cajon que dejo abierto para meterle cosas en el controlador*/
       $this->user = $user;
       $this->state = $state;
       $this->role = $role;
       $this->authUser = $authUser;
    }

    public function broadcastOn()
    {
        /*Esto escucha a traves del canal de la pagina que creamos pusherCluster*/
        /*Ahy tres tipos de canales
            *Public--Cualquiera que este en la pagina puede ver los mensajes. Es este no se escribe PUBLIC solo channel.
            *Private--Necesita autenticacion para poder entrar en le broadcasting
            *Precense--Parecido al private channel pero depende si alguien esta en linea o no
                       Tipo facebook donde te dice si alguien esta en linea o si alguien esta escribiendo algo. Ese tipo de cosas
                       Te dice si una persona esta o no presente
        */
    return new Channel('users');
    }

    /*Esta funcion me deja darle un nombre mas agradeble el EVENT y poder llamarlo por ese nombre
     Si nos fijamos en PUSHER web el EVENT va a venir con este nombre
     Esto evita que usuarios maliciosos vean el (App\Events\....) y tengas mas info de como el proyecto esta estructurado*/
    public function broadcastAs()
    {
        return 'user-update';
    }
}
