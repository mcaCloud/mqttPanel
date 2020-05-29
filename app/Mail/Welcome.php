<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


/*Sin esta clase no puedo importar el objeto user del controlador de USER*/
use App\User;

class welcome extends Mailable
{
    use Queueable, SerializesModels;

    /*Metemos aqui la var de USER para poder utilizar ese campo en las views*/
    /*En estas clases de mailables cualquier propiedad que definamos aqui las podemos utilizar en el view*/
    public $user;
    /* Aun tengo problemas para meter dos modelos con informacion dentro del constructor pero con uno funciona perfectamente*/
    public function __construct(User $user){

        $this ->user = $user;
    }

    /*Simpre para enviar correos en la funcion build tenemos el metodo para construir*/
    public function build(){

        /*Primero definimos de parte de quien se envia el mensaje*/
        /*De esta forma el usuario sabe si puede reply o no*/
        return $this->from('123@example.com')
                    ->subject('Bienvenido')
                    /*Regresamos el view con el BODY del correo*/
                    /*El mark down lo creamos cuando creamos el mailable con el tag --markDown*/
                    ->markdown('emails.welcome');

    }
}
