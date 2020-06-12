<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
/*Con esto importo los metodos (authorize,rules,message)*/
/*Es unicamente para la creacion y actualizacion de usuarios*/
use App\Http\Requests\UserRequest;

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

/************* EVENTS ***************/
use \App\Events\userUpdate;

/*************MAIL-NOTIFICATION****************/
/*Por cada mail que desee enviar lo tengo que importar aqui para poderlo utilizar*/
use App\Mail\welcome;

//use App\Notifications\userCreated;
use App\Notifications\userDeleted;
use App\Notifications\userUpdated;

/*Para recibir las notificacion desde la base de datos y desplegarlas en el panel de control*/
use Illuminate\Support\Facades\Notification;
/************* /MAIL-NOTIFICATION****************/


/*Esto es para poder utilizar el ojeto REQUEST*/
use Illuminate\Http\Request;

use App\Exports\UserCollectionExport;
use App\Exports\UserQueryExport;
use App\Exports\UserViewExport;
use App\Exports\UserMappingExport;


class UserController extends Controller
{
/*******************INDEX*********************************/
    /*Recojo la request que me llega por URL*/
    public function index(Request $request)
    {
        /*THIS es un puntero que hace referencia a un OBJETO*/
        /*El AUTHORIZE es un metodo del controller App\Http\Requests\UserRequest
        /* Se autoriza a quien tenga permiso de 'listar-usuarios'*/
        $this->authorize('listar-usuarios');

        /*Creo un variable USERS para que me guarde el QUERY el modelo de usuario*/
        $users = User::query();

        /*Si el usuario autenticado tiene otro rol diferente a
          'super-admin' entonces: */
        /*Utiliza el TRAIT 'HasRoles' y el metodo de 'hasRole'*/
        /*Esto se logra porque se usan los modelo de SPATIE que ya a su vez incluyen los TRAITS*/
        if (!Auth::user()->hasRole('super-administrador')){
            /*Se le muestra la info, no se le oculta */
            /*Si el valor estuviera en TRUE solo el super admin la podria ver*/
            $users = $users->where('hidden', false);
        }
        /*Muestreme esta vista*/
        return view('dashboard.users.index', [
            /*Donde la variable 'items' me muestra el QUERY dentro de la variable USERS de forma paginada
              *CONFIG es parte de un helper to Get / set the specified configuration value. Y poder utilizar el User Interface*/ 
            /*La variable 'page' me da el objeto de la request dentro de la pagina
            */
            /*Se hace asi para poder utilizar el JS de DataTables*/
            'items' => $users->paginate(config('ui.dashboard.page_size')),
            'page' => $request->query('page')
        ]);
    }
/******************* /INDEX*********************************/


/******************* CREATE*********************************/
    /*Aqui recibo el objeto de la request por URL*/
    public function create(Request $request)
    {   
        /*El AUTHORIZE es un metodo del controller App\Http\Requests\UserRequest
        /*authorize este es un método opcional donde colocamos la lógica para la autorización del usuario que devolverá true si el usuario está autorizado para hacer la solicitud y false en caso contrario.*/
        $this->authorize('crear-usuarios');

        /*Creo la variable Model para que me guarde un nuevo objeto USER*/
        $model = new User;

        $page = $request->get('page');

        /*Me guarda el query que le hago al modelo ROLE*/
        $roles = Role::query();

        /*Me guarda el query que le hago al modelo PERMISSION*/
        $permissions = Permission::query();

        /*Si la REQ viene de un usuario diferente a 'super-admin'entonces:*/
        if (!$request->user()->hasRole('super-administrador')){
            /*FALSE significa que no se oculta, si se permite*/
            /*Hay que estudiarlo mas*/
            $roles->where('hidden', false);
        }

        /*Que me regrese la vista de crear el usuario*/
        return view('dashboard.users.create', [

            'hidden'=> $request->old('hidden', false),
            'model'=> $model,
            'page'=> $request->query('page'),
            /***************ROLES********************/
            /*The pluck method retrieves all of the values for a given key*/
            /*La variable Roles me guarda la consulta al modelo ROLE*/
            /*La consulta a la tabla de la base de datos se hace a traves de la columna 'display_name' y me despliega los resultados de forma ascende*/
            /*EL PLUCK utiliza dos keys : 'display:name' y 'id'*/
            /*De esta forma puedo obtener los resultados de los campos de la BD desde la vista del formulario*/

            'roles'=> $roles->orderBy('display_name', 'desc')->pluck('display_name', 'id'),

            /* Creo la variable para que me guarde la operacion ternaria
             *Si el ID de role_id existe algo dentro del campo role_id( not null) entonces se muestra el role_id que existe.
             *Sino se guarda un valor nuevo.
            *El role _id es el que va a identificar al campo del formulario por ID.
            */
            'role_id'=> (!is_null(old('role_id')))? old('role_id'):[],
            /*************** /ROLES********************/

            /*************** PERMISSIONS ********************/
            /*Llamo a la VAR permissions que cree arriba y la guardo en una VAR con el mismo nombre. Esta segunda me guarda la info ordenada*/
            'permissions'=> $permissions->orderBy('display_name', 'desc')->pluck('display_name', 'id'),

            /* Creo la variable para que me guarde la operacion ternaria
             *Si el ID de permission_id existe algo dentro del campo role_id( not null) entonces se muestra el role_id que existe.
             *Sino se guarda un valor nuevo.
             *El permission _id es el que va a identificar al campo del formulario por ID.
            */
            'permission_id'=> (!is_null(old('permission_id')))? old('permission_id'):[],
            /*************** /PERMISSIONS ********************/
            /*El boton de cancel me regresa al index de users*/
            'cancel_link'=> route('dashboard::users.index', ['page' => $page])
        ]);
    }

/******************* STORE*********************************/
    public function store(UserRequest $request)
    {
        /*El AUTHORIZE es un metodo del controller App\Http\Requests\UserRequest*/
        /*authorize este es un método opcional donde colocamos la lógica para la autorización del usuario que devolverá true si el usuario está autorizado para hacer la solicitud y false en caso contrario.*/
        $this->authorize('crear-usuarios');

        /*“Transactions” gives us power to commit a group of database operations, like bulk insert, or rollback the entire transaction if any error occurs.*/
        /*Laravel provides DB::beginTransaction() method to begin transaction and within try — catch block, to commit the transaction DB::commit() and to undo / rollback, we have DB::rollback().*/
        \DB::beginTransaction();

          /*Creamos variable User que me guarda el nuevo objeto de User::create*/
          $user = User::create(array_merge(
              [
                  'status' => $request->has('status') ?? 'inactive',
                  'hidden' => $request->has('hidden')
              ],
              $request->all()
          ));

          /*A esa variable user le adjuntamos lo que se escojio para ROLE_ID*/
          $user->roles()->attach($request->input('role_id'));
        /*Guardamos en la base de datos*/
        \DB::commit();

        /*Cuando el usuario nuevo a sido creado le enviamos un correo de bienvenida*/
        /*Tuvimos que ya haber importado el modelo MAIL y el mailable del correo que queremos enviar*/
        /*El correo se lo enviamos al user que acabamos de crear*/
        /*Y lo que le enviamos es el correo que se llama 'newUser' dentro de la carpeta de MAIL en los controladores*/
        /*Le pasamos la VAR del user que acaba de crearse para poder utilizar las propiedasd en el body del email*/
        \Mail::to($user)->send(new welcome($user));

        /****************************/
        /******* NOTIFICACION *******/
        /****************************/
        /* Creo una variable para que me guarde la informacion de quien deberia de ser informado de la creacion del usuario*/
        /*En este ejemplo envia la notificacion a todos los usuarios que tengan un ID diferente al del usuarios que ha sido creado*/
        /**/
        //$notificationReceiver =User::where('id','!=',auth()->user()->id)->get();
        /**/
        /*En este caso envio la notificacion a todos los usuarios que tengan el ROLE de super administrador*/
        /*Para ello cree un metodo en el MODELO de USER que se llama 'hasroles' y me permite llamar a los reloes desde el modelo USER*/
        //$notificationReceiver =User::hasRoles('super-administrador')->get();

        /* Esta notificacion la guardamos en la base de datos y tambien la enviamos por correo*/
        /*Lo que pasa es que es mejor enviar una notificacion y un carreo aparte porque aun no manejo bien el markdown desde toMail funciontion de la notificacion*/
        //Notification::send($notificationReceiver, new userCreated($user));
        /****************************/
        /******* /NOTIFICACION *******/
        /****************************/

        /****************************/
        /******* Evento *******/
        /****************************/
        //Tenemos que mencionar el evento en la cabecera del controlador, sino no lo puede llamar.
        //Este es para conseguir la info de quien realiza la accion
        $authUser = Auth::user();
        //STATE es una variable que cree dentro del evento, junto con USER. STATE me va a guardar un vor que retrive en el front-end.Por ahora es un string despues intentare con un array

        $state = 'creado';

        $name =$user->roles->pluck('display_name');

        //Esto es lo que sacamos en la vista. Todas las propiedades de los objetos que creamos. AUnque a estate solo le sacamos un string, lo podemos convertir en un array
        event(new userUpdate($user,$state,$name,$authUser));

        /****************************/
        /******* /Evento *******/
        /****************************/

        /*Finalmente nos redirige a la base de datos con un mensaje
        que incluya el nombre completo del nuevo usuario*/
        return redirect()->route('dashboard::users.index')->with([
            'message' => 'Se ha creado con éxito al usuario [' . $user->completeName() . ']',
            'level' => 'success'
        ]);
    }
/******************* /STORE*********************************/

/******************* EDITAR*********************************/
    /*Recibimos la REQ por URL y el ID del usuario*/
    public function edit(Request $request, $id)
    {   
        /*El AUTHORIZE es un metodo del controller App\Http\Requests\UserRequest
        /*authorize este es un método opcional donde colocamos la lógica para la autorización del usuario que devolverá true si el usuario está autorizado para hacer la solicitud y false en caso contrario.*/
        $this->authorize('editar-usuarios');

        /*Creo la variable PAge para guardar la request que recibo*/
        $page = $request->get('page');

        //Creamos una variable user para conseguir el objeto del ususario que estamos intentando editar. Utilizamos FIndOrFail para que nos devuelva un error en caso de que no exist aen la base de datos
        //Esta variable de userProfile es la que vamos a utilizar en el formulario para conseguir cada campo
        $user = User::findOrFail($id);

        /*Si el usuario tiene rol de Super-Admin
         no se va a mostrar en la caja que rol tiene*/
         /*Utiliza el TRAIT 'HasRoles' y el metodo de 'hasRole'*/
         /*Esto se logra porque se usan los modelo de SPATIE que ya a su vez incluyen los TRAITS*/
        if($user->hasRole('super-administrador')){

           /*The pluck method retrieves all of the values for a given key*/
            /*La variable 'roles' me guarda la consulta al modelo ROLE*/
            /*La consulta a la tabla de la base de datos se hace a traves de la columna 'display_name' y me despliega los resultados de forma ascende*/
            /*EL PLUCK utiliza dos keys : 'display:name' y 'id'*/
            /*De esta forma puedo obtener los resultados de los campos de la BD desde la vista del formulario*/
            /*Si es SUPER le aparecen todos los roles*/
            /*Este el modelo de SPATIE que incluye los TRAITS*/
              $roles = Role::orderBy('display_name', 'asc')->pluck('display_name', 'id');

            /*The pluck method retrieves all of the values for a given key*/
            /*La variable Roles me guarda la consulta al modelo PERMISSION*/
            /*La consulta a la tabla de la base de datos se hace a traves de la columna 'display_name' y me despliega los resultados de forma ascende*/
            /*EL PLUCK utiliza dos keys : 'display:name' y 'id'*/
            /*De esta forma puedo obtener los resultados de los campos de la BD desde la vista del formulario*/
            /*Este el modelo de SPATIE que incluye los TRAITS*/
              $permissions = Permission::orderBy('display_name', 'asc')->pluck('display_name', 'id'); 

        }else{

              /*Aqui es para que me pueda mostrar los roles en la caja de seleccion del formulario*/  
              /*Si no es SUPER significa que puede escojer cualquier role excepto el de SUPER*/
              /*Esto protege que un usuario no se pueda convertir en SUPER solo a menos que otro super se lo otorgue*/ 
              /*Este el modelo de SPATIE que incluye los TRAITS*/      
              $roles = Role::where('name','!=','super-administrador')->orderBy('display_name', 'asc')->pluck('display_name', 'id');

              /*Creo una VAR para que me guarde la busqueda de los permisos disponible en la base de datos con su nombre de manera asendente*/
              /*Cualquier otro usuario que no sea super admin podra ver listados sus permisos*/
              /*Este el modelo de SPATIE que incluye los TRAITS*/
              $permissions = Permission::orderBy('display_name', 'asc')->pluck('display_name', 'id');
        }

        return view('dashboard.users.edit', [

            /* Aqui se guarda la informacion del objeto que contiene las propiedades de la busqueda en la base de datos.
            *User utiliza todas las propiedades definidas en el MODELO user
            */
            /*****IMPORTANTE*****/
            /*'model' es la variable que llamo dentro del formulario para conseguir al USER*/
            'model' => $user,
            'page' => $request->query('page'),
            'hidden' => $request->old('hidden', $user->hidden),

            /****************** ROLES ************************/
            /*Le paso la VAR roles al formulario para que me muestre los roles
              *Esta es la informacion que va a utilizar el formulario para actualizar el usuario
            */
            'roles' => $roles, 

            /*Esto es para que me mantenga el rol que tenia el usuario anteriormente
            * El ID del SELECT en el formulario esta conectado con esto para que me popule el OLD value del roleID.
            */          
            'role_id' => $request->old('role_id', $user->roles->pluck('id')->toArray()),
            /****************** /ROLES ************************/

            /****************** PERMISSIONS ************************/
            /*Le paso la VAR permission al formulario para que me muestre los permisos*/
            'permissions'=>$permissions,

            /*Esto es para que me muestre los permisos que tiene el usuario anteriormente
             * El ID del SELECT en el formulario esta conectado con esto para que me popule el OLD value del roleID.
            */
            'permission_id' => $request->old('permission_id', $user->permissions->pluck('id')->toArray()),

            /****************** /PERMISSIONS ************************/

            'cancel_link'   => route('dashboard::users.index', ['page' => $page])
        ]);
    }
/******************* /EDITAR*********************************/



/******************* ACTUALIZAR *********************************/

    /*El UserRequest viene del controller App\Http\Requests\UserRequest
    *Como estamos utilizando un 'Request-Form de Laravel' tenemos que incluir el request dentro del controlador arriba y meterlo dentro de nuestro metodo como parametro*/
    /*De esta manera, el request que viene del formulario será evaluado por el Form Request antes de ejecutar las instrucciones de esta funcion UPDATE que está siendo llamada*/
    /*Es decir, la accion será ejecutada únicamente si el request pasa la validación.*/
    public function update(UserRequest $request, $id)
    {
        /*El AUTHORIZE es un metodo del controller App\Http\Requests\UserRequest*/
        /*$this->authorize('editar-usuarios');
        //Creamos una variable user para conseguir el objeto del usuario que estamos intentando editar. Utilizamos FIndOrFail para que nos devuelva un error en caso de que no exista en la base de datos*/
        $user = User::findOrFail($id);

        /*array_merge — Combina dos o más arrays
         *Combina los elementos de uno o más arrays juntándolos de modo que los valores de uno se anexan al final del anterior. 
         *Retorna el array resultante
        */
        $user->update(array_merge(
            [
                'status' => $request->has('status') ?? 'inactive',
                'hidden' => $request->has('hidden')
            ],
            /*Recojo todo de la request excepto el PSS y la confirmacion*/
            $request->except('password', 'password_confirmation')
        ));


        if (strlen(trim($request->get('password'))) > 0){
            $user->password = $request->get('password');
            $user->save();
        }
       
        /*De esta forma actualizo los roles del user*/
        /*'sync' es un metodo del TRAIT 'HasRoles' que recibe como parametro
         'roles' y remueve los roles de la base de datos e incluye los nuevos
        */
        $user->roles()->sync($request->input('role_id'));

        /*De esta forma actualizo los permisos del user*/
        /*'sync' es un metodo del TRAIT 'HasPermissions' que recibe como parametro
         'permissions' y remueve los roles de la base de datos e incluye los nuevos
        */
        $user->permissions()->sync($request->input('permission_id'));

        return redirect()->route('dashboard::users.index')->with([
            'message' => 'Se han actualizado los datos del usuario [' . $user->completeName() . ']',
            'level' => 'success'
        ]);
    }
/******************* /ACTUALIZAR *********************************/


/******************* DELETE *********************************/
    /* Para que la ruta de DELETE funcione es necesario un FORM en el View
     *Por ahora los browser por el momento no soportan el metodo DELETE
    * Necesitan recibir un POST request
     *Solo se logra con un submit button
    */
    public function destroy(Request $request,$id)
    {
        /*El AUTHORIZE es un metodo del controller App\Http\Requests\UserRequest*/
        /*authorize este es un método opcional donde colocamos la lógica para la autorización del usuario que devolverá true si el usuario está autorizado para hacer la solicitud y false en caso contrario.*/
        $this->authorize('eliminar-usuarios');
        //Ahora hacemos un find para conseguir el usuario que deseamos borrar

        $user = User::findOrFail($id);
    


        /****************************/
        /******* NOTIFICACION *******/
        /****************************/
        /* Creo una variable para que me guarde la informacion de quien deberia de ser informado de la creacion del usuario*/
        /*En este ejemplo envia la notificacion a todos los usuarios que tengan un ID diferente al del usuarios que ha sido creado*/
        /**/
        $notificationReceiver =User::where('id','!=',auth()->user()->id)->get();
        /*En este caso envio la notificacion a todos los usuarios que tengan el ROLE de super administrador*/
        /*Para ello cree un metodo en el MODELO de USER que se llama 'hasroles' y me permite llamar a los reloes desde el modelo USER*/
        $notificationReceiver =User::hasRoles('super-administrador')->get();
        /* Esta notificacion la guardamos en la base de datos y tambien la enviamos por correo*/
        /*Lo que pasa es que es mejor enviar una notificacion y un carreo aparte porque aun no manejo bien el markdown desde toMail funciontion de la notificacion*/
        //Notification::send($notificationReceiver, new userDeleted($user));
        /****************************/
        /******* /NOTIFICACION *******/
        /****************************/

        /****************************/
        /******* Evento *******/
        /****************************/
        //Tenemos que mencionar el evento en la cabecera del controlador, sino no lo puede llamar.
        //Me connecto al evento con todo el objeto USER, y ya dentro de la vista conmienzo a sacar los atributos.
        //Este es para conseguir la info de quien realiza la accion
        $authUser = Auth::user();
        //STATE es una variable que cree dentro del evento, junto con USER. STATE me va a guardar un vor que retrive en el front-end.Por ahora es un string despues intentare con un array
        $state = 'borrado';
        //ROLE me guarda la propiedad de 'roles' 'display_name' con un pluck.Podria sacar mas propiedades de roles.
        $role =$user->roles->pluck('display_name');

       //Tenemos que mencionar el evento en la cabecera del controlador, sino no lo puede llamar.
        //Me connecto al evento con todo el objeto USER, y ya dentro de la vista conmienzo a sacar los atributos. De igual forma utilzo las varibales que cree dentro del EVENTO y en la vista le comienzo a sacar los atributos
        event(new userUpdate($user,$state,$role,$authUser));

        /****************************/
        /******* /Evento *******/
        /****************************/



        //Finamente eliminar el registro del usuario de la base de datos
        User::destroy($id);


        //Lo ultimo que hace este metodo es redirigirnos a la pagina en que estabamos con el array de mensaje para que me diga si se elimino o no correctamente
        return redirect()->route('dashboard::users.index')->with([
            'message' => 'Se ha eliminado al usuario [' . $user->completeName() . ']',
            'level' => 'success'
        ]);
    }
/******************* /DELETE *********************************/


/*******************TOGGLE**************************************/
    /* Aqui recivo la REQUEST y el ID del usuario que me viene por la URL*/
    public function toggleAccess(Request $request, $id)
    {   
        /*Almaceno en la variable User el usuario que coincide con el ID 
          que me llega por la URL
         *Del lado del formulario lo que pedi fue el ($item->id)
         */
        $user = User::findOrFail($id);
        /*User va a llamar a la funcion del modelo USER 'toggleAccess'
         *Este metodo pide una variable TYPE
         *Entonces aqui recojo la variable de 'type' que vienen dentro del request
         que me llega por la URL
         */
        $user->toggleAccess($request->get('type'));

        /*Guardo el objeto en la base de datos*/
        $user->save();

        /*Redirijo a la base de datos con un mensaje que contiene el nombre completo del usuario*/
        return redirect()->route('dashboard::users.index', ['page' => $request->query('page')])->with([
            'message' => 'Se han actualizado los accesos del usuario [' . $user->completeName() . ']',
            'level' => 'success'
        ]);
    }
/*****************************************************************/


/******************* /TOGGLE**************************************/
/*
    public function export(Request $request)
    {
      $type = $request->get('type');
      switch ($type) {
        case 'collection':
            return (new UserCollectionExport)->download('UserCollectionExport.xlsx');
          break;
        case 'query':
            return (new UserQueryExport)->download('UserQueryExport.xlsx');
          break;
        case 'view':
            return (new UserViewExport)->download('UserViewExport.xlsx');
          break;
        case 'mapping':
            return (new UserMappingExport)->download('UserMappingExport.xlsx');
          break;
        default:
          return (new UserViewExport)->download('UserViewExport.xlsx');
          break;
      }
    }*/

}