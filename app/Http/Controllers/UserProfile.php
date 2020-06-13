<?php

namespace App\Http\Controllers;

/*Esto es para poder utilizar el ojeto REQUEST*/
use Illuminate\Http\Request;

//Todas las request que nos llegan por HTT
use App\Http\Requests;
//Todo el tema de la bases de datos
use Illuminate\Support\Facades\DB;
//Para poder almacenar en el Storage
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Controllers\Controller;
/*Con esto importo los metodos (authorize,rules,message)*/
/*Es unicamente para la creacion y actualizacion de usuarios*/
use App\Http\Requests\UserRequest;

/*Aqui importo los MODELOS de Role y Permissions*/
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission; 

/*Importo el MODELO de User*/
use App\User;
//Ahora importo los modelos
use App\Video;
use App\VideoComment;

use App\Doc;
use App\DocComment;
/* Middleware vendor/laravel/framework/src/iluminate/auth/middleware/Authenticate*/
use Auth;


class UserProfile extends Controller
{
        public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function show($id)
    {
        //
    }

/****************************************************************************************/
/*****************************/                            /*****************************/  
/******************************     EDIT                   *******************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
    /*Recibimos la REQ por URL y el ID del usuario*/
    public function edit(Request $request, $id)
    {   
        /*El AUTHORIZE es un metodo del controller App\Http\Requests\UserRequest
        /*authorize este es un método opcional donde colocamos la lógica para la autorización del usuario que devolverá true si el usuario está autorizado para hacer la solicitud y false en caso contrario.*/
        /*$this->authorize('editar-usuarios');
        /*Creo la variable PAge para guardar la request que recibo*/
        $page = $request->get('page');

        //Creamos una variable userProfile para conseguir el objeto del ususario que estamos intentando editar. Utilizamos FIndOrFail para que nos devuelva un error en caso de que no exist aen la base de datos
        //Esta variable de userProfile es la que vamos a utilizar en el formulario para conseguir cada campo
        $user = User::findOrFail($id);

        /*The pluck method retrieves all of the values for a given key*/
        /*La variable Roles me guarda la consulta al modelo ROLE*/
        /*La consulta a la tabla de la base de datos se hace a traves de la columna 'display_name' y me despliega los resultados de forma ascende*/
        /*EL PLUCK utiliza dos keys : 'display:name' y 'id'*/
        /*De esta forma puedo obtener los resultados de los campos de la BD desde la vista del formulario*/
        $roles = Role::orderBy('display_name', 'asc')->pluck('display_name', 'id');

        /*The pluck method retrieves all of the values for a given key*/
        /*La variable Roles me guarda la consulta al modelo PERMISSION*/
        /*La consulta a la tabla de la base de datos se hace a traves de la columna 'display_name' y me despliega los resultados de forma ascende*/
        /*EL PLUCK utiliza dos keys : 'display:name' y 'id'*/
        /*De esta forma puedo obtener los resultados de los campos de la BD desde la vista del formulario*/
        $permissions = Permission::orderBy('display_name', 'asc')->pluck('display_name', 'id');


        return view('dashboard.users.userProfile', [
            /* Aqui se guarda la informacion del objeto que contiene las propiedades de la busqueda en la base de datos.
            *User utiliza todas las propiedades definidas en el MODELO user
            */
            'user' => $user,
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

/****************************************************************************************/
/*****************************/                            /*****************************/  
/******************************     ACTUALIZAR                   ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************//*

    /*El UserRequest viene del controller App\Http\Requests\UserRequest
    *Como estamos utilizando un 'Request-Form de Laravel' tenemos que incluir el request dentro del controlador arriba y meterlo dentro de nuestro metodo como parametro*/
    /*De esta manera, el request que viene del formulario será evaluado por el Form Request antes de ejecutar las instrucciones de esta funcion UPDATE que está siendo llamada*/
    /*Es decir, la accion será ejecutada únicamente si el request pasa la validación.*/
    /*En este caso no lo utilizo ya que los campos para editar en el perfil del usuario son muy pcos*/
    /*Entonces lo hago de la manera tradicional con la validacion dentro del metodo*/
    public function update(Request $request, $id)
    {
        /*Lo primero que vamos a hacer es validar el formulario y le pasamos la request para que recoja todos los datos que llegan por POST. Ademas le vamos a pasar un array con las reglas de validacion que ocupamos*/
        $validate = $this->validate($request, array(
                /*Ocupamos que siempre haya un email*/
                'email' =>'required',
                /*Ocupamos que el passwor pueda ser NULL si el usuario no lo quiere acutalizar, pero que sea requerido si el usuario no tiene un ID asignado*/
                /*En caso de que el usuario lo queira acutalizar , es necesario la confirmacion, y que tenga un minimo de 8 caracters*/
                'password'  => 'nullable|required_without:id|confirmed|min:8|max:30'
        ));

        //Creamos una variable user para conseguir el objeto del usuario que estamos intentando editar. Utilizamos FIndOrFail para que nos devuelva un error en caso de que no exista en la base de datos*/
        $userProfile = User::findOrFail($id);

        //Tambien vamos a conseguir el usuario identificado
        //  $user = \Auth::user();

        /*Ahora le asigno los valores a cada una de las propiedades del objeto del usuario que puedo recibir */
        /* En este caso los usuarios desde el perfil solo podran editar el email y la contraseña, ademas de cabiar la forto de perfil*/
        $userProfile->email = $request->input('email');
        $userProfile->password = $request->input('password');

        // -----  UPLOAD IMAGE ----//
          //Antes de salvar tenemos que recoger el fichero de la request que se llama IMAGE
          $image = $request->file('image');
          // Entonces comprobamos si la imagen nos llega
          if ($image){

            //********OJO*************//
            //Antes de actualizar la imagen tenemos que eliminar el registro anterior para que La imagen no se reporduzca una y otra vez. Es decir si no elimino el registro cada vez que se actualize la imagen se crea una copia y nos satura la base de datos
            Storage::disk('avatars')->delete($userProfile->image);
            //*************************//
            //Si nos llega recojemos el path de la imagen
            //Obtenemos el nombre del fichero temporal
            //Le concateno time() para evitar tener el mismo archivo
            $image_path = time().$image ->getClientOriginalName();

            //Ahora tenemos que utilizar el OBJETO storage y el metodo DISK para guardar todo dentro de la carpeta AVATARS el objeto $image que acabamos de conseguir
            \Storage::disk('avatars')->put($image_path,\File::get($image));
            //Por ultimo asignamos al objeto IMAGE el valor del $image_path
            $userProfile->image = $image_path;
          }

        /*CUnado ya tengo todos los campos asignados le hago el update del objeto en la base de datos.*/
        $userProfile->update();

        return redirect()->route('dashboard::index')->with([
            'message' => 'Se han actualizado los datos del usuario [' . $userProfile->completeName() . ']',
            'level' => 'success'
        ]);
    }
/****************************************************************************************/
/*****************************/                            /*****************************/  
/******************************     GET-AVATAR                   ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
/* Este metodo recibo por URL el nombre del fichero*/
public function getImage($filename){
    //Creamos una variable $file para acceder al STORAGE y con el metodo (disk) le indicamos en que carpeta esta nuestra imagen. COn el metodo get le indicamos cual fichero queremos. CUAL?. Pues el que nos llegue por parametro $filename
    $file = Storage::disk('avatars')->get($filename);
    //POr ultimo regresamos un response con un $file que nos devuelve el fichero en si
    return new Response($file,200);
    /* Ahora necesitamos crear una ruta para este metodo en web.php*/
}

/****************************************************************************************/
/*****************************/                            /*****************************/  
/******************************     GET-IMAGE-VIDEO        ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
/* Este metodo recibo por URL el nombre del fichero*/
public function getVideoImage($filename){
    //Creamos una variable $file para acceder al STORAGE y con el metodo (disk) le indicamos en que carpeta esta nuestra imagen. COn el metodo get le indicamos cual fichero queremos. CUAL?. Pues el que nos llegue por parametro $filename
    $file = \Storage::disk('images')->get($filename);
    //POr ultimo regresamos un response con un $file que nos devuelve el fichero en si
    return new Response($file,200);
    /* Ahora necesitamos crear una ruta para este metodo en web.php*/
}

/****************************************************************************************/
/*****************************/                            /*****************************/  
/******************************     DESTROY                   ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/


    public function destroy($id)
    {
        //
    }

/****************************************************************************************/
/*****************************/                            /*****************************/  
/**************************     CANAL-USUARIO                   ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
   //Aqui vamos a capturar toda la informacion del usuario que nos llegue por un parametro de la URL
   public function channel($user_id){
        // A traves del user_id (que llega por la URL) solicitamos al modelo USER toda la informacion del OBJETO del usuario 
        $user = User::find($user_id);

        /******SI NO EXISTE EL USUARIO **************/
        //Si el usuario no existe que me redirija al Home
        if (!is_object($user)) {
            return redirect()-> route('home');
        }
        //Vamos a sacar todos los videos asociados a ese usuario
        //Sacame todos los videos cuyo user_id sea igual al user_id que me llega por la URL
        $videos = Video::where('user_id',$user_id)->paginate(5);
        //Finalmente devolvemos una vista con un array que contenga los datos del objeto de usuario y el objeto de video.
        return view ('user.channel', array(
            'user'=> $user,
            'videos'=> $videos
        ));
   }

/****************************************************************************************/
/*****************************/                            /*****************************/  
/**************************     SHOW-USUARIO                   ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/

    public function showUsers(){

        $users = User::all();
        /*Ahora le tengo que pasar la informacion a la vista, para eso le paso un array al VIEW*/
        return view('user.users', compact('users'));
    }

/****************************************************************************************/
/*****************************/                            /*****************************/  
/**************************     VIDEO-DETAIL                   ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
    // TEnemos que pasar el $video_ID que el el detalle del video que deseamos mostrar

    public function getVideoDetail ($video_id){
        //Creamos una variable video que haga un FIND a la BD para conseguir el registro que deseamos mostrar. Esto lo podemos hacer con ELOQUENT y el metodo find- ÑLe solicitamos el video_id. Diferente como se hace con el QUERY builder
        $video = Video::find($video_id);
        //Cargamos una vista que se llma video y un array con la infomracion del video a cargar
        return view('dashboard.videos.detail', array(
            //Video va a llevar dentro todo el contenido de la variable $video
            'video' =>$video
        //POr ultimo es necesario crear la vista para este metodo
        ));

    }

/****************************************************************************************/
/*****************************/                            /*****************************/  
/**************************     SHOW-VIDEO                  ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
    /* Este metodo recibo por URL el nombre del fichero*/
    public function getVideo($filename){
        $file = Storage::disk('videos')->get($filename);
        return new Response($file,200);
    }


/****************************************************************************************/
/*****************************/                            /*****************************/  
/**********************         SEARCH-VIDEO                     ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/

//Le pasamos por parametro la busqueda que vamos a realizar
//POr defecto el parametro va a ser NULL porque puede que el parametro venga por la URL con busqueda o sin busqueda
//Tambien pasamos el parametro filter para poder utilizarlo
public function searchVideo($search = null, $filter = null){

    //Si el parametro de SEARCH es nulo entonces le vamos a asignar un valor a search que es que que vienen en la request
    if (is_null($search)) {
        //De esta forma siempre va a tener un valor que es el que ingresa en la barra de busqueda.
        //Esta es la variable que nos llega por get
        $search= \Request::get('search');

        /**************SI PRESIONO EL BOTON SIN NINGUNA BUSQUEDA*************/
        //Si presiono el boton de busqueda sin nada nos redirige al listado principal en el HOME
        if (is_null($search)) {
           return redirect()->route('home');
        }
        /*******************************************************************/
        //Esto es para que nos llegue un parametro limpia cuando nos redirija
        //De esta manera a la hora de buscar algo, la direccion sale con lo que escribi en search
        //Le pasamos el contenido que tiene la variable por GET
        return redirect()->route('videoSearch',array('search' =>$search));
    }

    //-----FILTRO--------
    /*Si no existe el parametro FILTER es decir es NULO,
     *Si existe el parametro que me llega por GET
     *Pero no es nulo SEARCH, entonces ...
      me hace una redireccion con el filtro capturando el parametro GET sino nada*/
    if (is_null($filter) && \Request::get('filter') && !is_null($search)) {
        //Creamos variable filter para capturar el parametro por GET
        $filter= \Request::get('filter');
        //Esto es para que nos llegue un parametro limpia cuando nos redirija
        //De esta manera a la hora de buscar algo, la direccion sale con lo que escribi en search
        //Le pasamos el contenido que tiene la variable por GET, es decir los dos parametros
        return redirect()->route('videoSearch',array('search' =>$search, 'filter' =>$filter));
    }
    /**************Si hay filtro***********/
    //Aqui vamos a optimizar la consulta para que queda perfecta
    //Creamos dos variable que son las que va a utilizar el ORDERBY
    //Estas con las variables que cambian en el filtro cunado seleccionamos las opciones
    $colum ='id';
    $order = 'desc';
    //En caso de que el filtro exista, es decir que no es NULL
    if (!is_null($filter)) {
        //Hacemos el ordenamiento de los video de acuerdo a los criterios del filtro
        //Ahora tenemos que hacer un acomprobarcion con el IF
        if ($filter == 'new') {
            $colum ='id';
            $order = 'desc';;
        }
        if ($filter == 'old') {
            $colum ='id';
            $order = 'asc';;
        }
        if ($filter == 'alfa') {                                
            $colum ='title';
            $order = 'asc';;
        }

    }
    /***************************************/
    //Vamos a hacer una QUERY , para que busque en el titulo la informacion
    //Cuando realicemos la busqueda, si el titulo es igual a lo que venga en SEARCH que nos de el resultado
    //Sacame todos los video cuando el titulo contenga lo que hemos buscado
    //Los % los pongo para que me saque la coincidencias de la Primera letra y la Ultima, no solo el resultado completo
    
    $videos = Video::where('title','LIKE','%'.$search.'%')
                            //Ha esto le agregamos el ORDERBY con los valores de las variables de arriba y el paginate
                            ->orderBy($colum,$order)
                            ->paginate(5);

    return view('dashboard.videos.search', array(
        'videos'=> $videos,
        'search'=> $search
    ));
}
    
/****************************************************************************************/
/*****************************/                            /*****************************/  
/**************************     DOC-DETAIL                   ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
    // TEnemos que pasar el $doc_ID que el el detalle del doc que deseamos mostrar

    public function getDocDetail ($doc_id){
        //Creamos una variable DOC que haga un FIND a la BD para conseguir el registro que deseamos mostrar. Esto lo podemos hacer con ELOQUENT y el metodo find- ÑLe solicitamos el video_id. Diferente como se hace con el QUERY builder
        $doc = Doc::find($doc_id);
        //Cargamos una vista que se llma doc y un array con la infomracion del doc a cargar
        return view('dashboard.docs.detail', array(
            //Video va a llevar dentro todo el contenido de la variable $doc
            'doc' =>$doc
        //POr ultimo es necesario crear la vista para este metodo
        ));

    }

/****************************************************************************************/
/*****************************/                            /*****************************/  
/**************************     SHOW-DOC                  ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
    /* Este metodo recibo por URL el nombre del fichero*/
    public function getDoc($filename){
        $file = Storage::disk('docs')->get($filename);
        return new Response($file,200);
    }


/****************************************************************************************/
/*****************************/                            /*****************************/  
/**********************         SEARCH-DOC                     ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/

//Le pasamos por parametro la busqueda que vamos a realizar
//POr defecto el parametro va a ser NULL porque puede que el parametro venga por la URL con busqueda o sin busqueda
//Tambien pasamos el parametro filter para poder utilizarlo
public function searchDoc($search = null, $filter = null){

    //Si el parametro de SEARCH es nulo entonces le vamos a asignar un valor a search que es que que vienen en la request
    if (is_null($search)) {
        //De esta forma siempre va a tener un valor que es el que ingresa en la barra de busqueda.
        //Esta es la variable que nos llega por get
        $search= \Request::get('search');

        /**************SI PRESIONO EL BOTON SIN NINGUNA BUSQUEDA*************/
        //Si presiono el boton de busqueda sin nada nos redirige al listado principal en el HOME
        if (is_null($search)) {
           return redirect()->route('index');
        }
        /*******************************************************************/
        //Esto es para que nos llegue un parametro limpia cuando nos redirija
        //De esta manera a la hora de buscar algo, la direccion sale con lo que escribi en search
        //Le pasamos el contenido que tiene la variable por GET
        return redirect()->route('docSearch',array('search' =>$search));
    }

    //-----FILTRO--------
    /*Si no existe el parametro FILTER es decir es NULO,
     *Si existe el parametro que me llega por GET
     *Pero no es nulo SEARCH, entonces ...
      me hace una redireccion con el filtro capturando el parametro GET sino nada*/
    if (is_null($filter) && \Request::get('filter') && !is_null($search)) {
        //Creamos variable filter para capturar el parametro por GET
        $filter= \Request::get('filter');
        //Esto es para que nos llegue un parametro limpia cuando nos redirija
        //De esta manera a la hora de buscar algo, la direccion sale con lo que escribi en search
        //Le pasamos el contenido que tiene la variable por GET, es decir los dos parametros
        return redirect()->route('videoSearch',array('search' =>$search, 'filter' =>$filter));
    }
    /**************Si hay filtro***********/
    //Aqui vamos a optimizar la consulta para que queda perfecta
    //Creamos dos variable que son las que va a utilizar el ORDERBY
    //Estas con las variables que cambian en el filtro cunado seleccionamos las opciones
    $colum ='id';
    $order = 'desc';
    //En caso de que el filtro exista, es decir que no es NULL
    if (!is_null($filter)) {
        //Hacemos el ordenamiento de los video de acuerdo a los criterios del filtro
        //Ahora tenemos que hacer un acomprobarcion con el IF
        if ($filter == 'new') {
            $colum ='id';
            $order = 'desc';;
        }
        if ($filter == 'old') {
            $colum ='id';
            $order = 'asc';;
        }
        if ($filter == 'alfa') {                                
            $colum ='title';
            $order = 'asc';;
        }

    }
    /***************************************/
    //Vamos a hacer una QUERY , para que busque en el titulo la informacion
    //Cuando realicemos la busqueda, si el titulo es igual a lo que venga en SEARCH que nos de el resultado
    //Sacame todos los video cuando el titulo contenga lo que hemos buscado
    //Los % los pongo para que me saque la coincidencias de la Primera letra y la Ultima, no solo el resultado completo
    
    $docs = Doc::where('title','LIKE','%'.$search.'%')
                            //Ha esto le agregamos el ORDERBY con los valores de las variables de arriba y el paginate
                            ->orderBy($colum,$order)
                            ->paginate(5);

    return view('dashboard.docs.search', array(
        'docs'=> $docs,
        'search'=> $search
    ));
}
    
}