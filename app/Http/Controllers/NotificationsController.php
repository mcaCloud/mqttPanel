<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
/*Con esto importo los metodos (authorize,rules,message)*/
/*Es unicamente para la creacion y actualizacion de usuarios*/
use App\Http\Requests\UserRequest;
/*Esto es para poder utilizar los requests que me llegan por URL*/
use Illuminate\Http\Request;

/********IMPORTANTE***********************/
/*Aqui importo los MODELOS de Role y Permissions*/
/*Dentro de estos modelos ya se encuentran importados los TRAIT de HasRoles y HasPermissions*/
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
/********IMPORTANTE***********************/

/*Los metodos necesarios para poder implementar el RESETPASSWORD feature*/
use Illuminate\Contracts\Auth\CanResetPassword;

/*Importo el MODELO de User*/
use App\User;
/* Middleware vendor/laravel/framework/src/iluminate/auth/middleware/Authenticate*/
use Auth;

class NotificationsController extends Controller
{

/*******************INDEX*********************************/
    /*Recojo la request que me llega por URL*/
    public function index(Request $request)
    {
        //Creamos una variable notification para conseguir el objeto de la notificaion que estamos intentando editar. 
        //Esta variable de NOTIFICTION es la que vamos a utilizar en el formulario para conseguir cada campo
        $user = User::find(1);
        $notification = Auth::user()->notifications;
  
        return view('notifications.index')->with('notification',$notification);

    }
/******************* /INDEX*********************************/
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
/******************* SHOW*********************************/
    //Aqui vamos a capturar toda la informacion de la notificaion que nos llegue por un parametro de la URL
    public function show($id)
    {

        //Creamos una variable detail para conseguir el objeto de la notificaion que estamos intentando editar. Utilizamos WHERE para que nos devuelva el objeto que coicida con el ID que le pasamos por parametro.
        //Esta variable de DETAIL es la que vamos a utilizar en el formulario para conseguir cada campo
        $detail = Auth::user()->notifications->where('id',$id);
        /*Una vez que el usuario ingrese en la notificaion se marca como leida*/
        $detail->markAsRead();

        /*Regresamos la vista de notificacion y le pasamos el objeto detail*/
        return view('notifications.notification.notificationShow', array(
            'detail'=> $detail
            
        ));
    }
/******************* SHOW *********************************/

    
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

/******************* DELETE *********************************/
    /* Para que la ruta de DELETE funcione es necesario un FORM en el View
     *Por ahora los browser por el momento no soportan el metodo DELETE
    * Necesitan recibir un POST request
     *Solo se logra con un submit button
    */
    public function destroy(Request $request,$id)
    {
        //Creamos una variable detail para conseguir el objeto de la notificaion que estamos intentando eliminar. Utilizamos WHERE para que nos devuelva el objeto que coicida con el ID que le pasamos por parametro.
        $detail = Auth::user()->notifications
                              ->where('id',$id)
                              ->first()
                              ->delete();
               return redirect()->route('notifications')->with([
            'message' => 'La notificación a sido borrada!',
            'level' => 'success'
        ]); 
    }
/******************* /DELETE *********************************/

/******************* ONE-READ *********************************/
    public function oneRead($id)
    {
        /* Esto es importante ver como  funciona para poder imprimir toda la info*/
        /*Necesito imprimir algo aprecido dende un vista*/
        /* IMprime las notificaciones NO LEIDAS de usuario authenticado y me las marca todas como leidas
         Esto se actualiza directamente en la base de datos*/
        $detail = Auth::user()->notifications
                              ->where('id',$id)
                              ->first()
                              ->markAsRead();
    return redirect()->back()
        ->with([
            'message' => 'Notificacion marcada como leída',
            'level' => 'success'
        ]);

    }
/******************* /ONE-READ *********************************/

/******************* ONE-UNREAD *********************************/
    public function oneUnRead($id)
    {
        /* Esto es importante ver como  funciona para poder imprimir toda la info*/
        /*Necesito imprimir algo aprecido dende un vista*/
        /* IMprime las notificaciones NO LEIDAS de usuario authenticado y me las marca todas como leidas
         Esto se actualiza directamente en la base de datos*/
        $detail = Auth::user()->notifications
                              ->where('id',$id)
                              ->first()
                              ->markAsUnread();
    return redirect()->back()
        ->with([
            'message' => 'Notificacion marcada como no leída',
            'level' => 'success'
        ]);
    }
/******************* ONE-UREAD *********************************/

/******************* ALL-READ *********************************/
    public function allRead()
    {

    /* Primero necesito saber si existen notificaiones porque si no existen me sale error al intentar marcarlas como leidas.*/
    if (Auth::user()->notifications->count()) {

        /*Si existen notificaciones marcalas todas como leidas*/
        Auth::user()->unreadNotifications-> markAsRead();

        /*Cuando se marcan todas como leidas se regresa a la pagina principal*/
        return redirect()->back()
                     ->with([
                           'message' => '[' . Auth::user()->first_name . '] las notificaciones están marcadas como leidas',
                           'level' => 'success'
        ]);
    /*Si no existen notificaciones...*/
    }else{
        /*Regreso a la vista con un mensaje de que no hay*/
        return redirect()->back()
        ->with([
            'message' => '[' . Auth::user()->first_name . '] No existen notificaciones',
            'level' => 'warning'
        ]);
    }
    
    }
/******************* ALL-READ *********************************/

/******************* ALL-UNREAD *********************************/
   public function allUnRead()
    {
   /* Primero necesito saber si existen notificaiones porque si no existen me sale error al intentar marcarlas como leidas.*/
    if (Auth::user()->notifications->count()) {

        /*Si existen notificaciones marcalas todas como leidas*/
        Auth::user()->unreadNotifications-> markAsUnread();

        /*Cuando se marcan todas como leidas se regresa a la pagina principal*/
        return redirect()->back()
                     ->with([
                           'message' => '[' . Auth::user()->first_name . '] las notificaciones están marcadas como no leidas',
                           'level' => 'success'
        ]);
    /*Si no existen notificaciones...*/
    }else{
        /*Regreso a la vista con un mensaje de que no hay*/
        return redirect()->back()
        ->with([
            'message' => '[' . Auth::user()->first_name . '] No existen notificaciones',
            'level' => 'warning'
        ]);
    }

    }
/******************* ALL-UNREAD *********************************/

/******************* ALL-UNREAD *********************************/
   public function empty()
    {
    /* Esto es importante ver como  funciona para poder imprimir toda la info*/
    /*Necesito imprimir algo aprecido dende un vista*/
    /* IMprime las notificaciones NO LEIDAS de usuario authenticado y me las marca todas como leidas
    Esto se actualiza directamente en la base de datos*/
    Auth::user()->notifications()->delete();

    /*Cuando se marcan todas como leidas se regresa a la pagina principal*/
    return redirect()->back()
        ->with([
            'message' => '[' . Auth::user()->first_name . '] todas las notificaciones se han borrado',
            'level' => 'success'
        ]);

    }
/******************* ALL-UNREAD *********************************/
}
