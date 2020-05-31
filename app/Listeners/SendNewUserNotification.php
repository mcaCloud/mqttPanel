<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewUserNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        /*Creo la variable de admins para que me busque en la base de datos
         a todos los usuarios que tienen un ROLE de ('1') (super-administrador)*/
        $admins = User::whereHas('roles', function ($query) {
                $query->where('id', 1);
            })->get();
        /*Entonces le enviamos la notificacion con el nombre con el evento sobre el USUARIO*/
        /*OJO con este concepto*/
        /*Para poder hacer que este listener funcione lo tenenmos que dar de alta en app/Providers/EventServiceProvider.php*/

        Notification::send($admins, new UserCreated($event->user));
    }
}
