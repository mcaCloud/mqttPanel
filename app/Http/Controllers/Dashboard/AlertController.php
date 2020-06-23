<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//Todas las request que nos llegan por HTT
use App\Http\Requests;
//Para validar los fromatos de los documentos
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facade\DB;
use Illuminate\Support\Facade\Storage;
use Symfony\Component\HttpFoundation\Response;
//Ahora importo los modelos
use App\Alert;
USE Auth;

class AlertController extends Controller
{
 /***********************************************************************************/
/*****************************/                            /*************************/  
/**********************         INDEX                     ***************************/ 
/*****************************/                            /*************************/ 
/************************************************************************************/
    /*Recojo la request que me llega por URL*/
    public function index(Request $request)
    {
        /*THIS es un puntero que hace referencia a un OBJETO*/
        /*El AUTHORIZE es un metodo del controller App\Http\Requests\UserRequest
        /* Se autoriza a quien tenga permiso de 'listar-usuarios'*/
        //$this->authorize('listar-usuarios');

        /*Creo un variable DOCS para que me guarde el QUERY el modelo de docs*/
        $alerts = Alert::query();

        /*Si el usuario autenticado tiene otro rol diferente a
          'super-admin' entonces: */
        /*Utiliza el TRAIT 'HasRoles' y el metodo de 'hasRole'*/
        /*Esto se logra porque se usan los modelo de SPATIE que ya a su vez incluyen los TRAITS*/
        if (!Auth::user()->hasRole('super-administrador')){
            /*Se le muestra la info, no se le oculta */
            /*Si el valor estuviera en TRUE solo el super admin la podria ver*/
            $alert = $alerts->where('hidden', false);
        }
        /*Muestreme esta vista*/
        return view('dashboard.alerts.index', [
            /*Donde la variable 'items' me muestra el QUERY dentro de la variable USERS de forma paginada
              *CONFIG es parte de un helper to Get / set the specified configuration value. Y poder utilizar el User Interface*/ 
            /*La variable 'page' me da el objeto de la request dentro de la pagina
            */
            /*Se hace asi para poder utilizar el JS de DataTables*/
            'items' => $alerts->paginate(config('ui.dashboard.page_size')),
            'page' => $request->query('page')
        ]);
    }
/******************* /INDEX*********************************/

 /*************************************************************************************/
/*****************************/                            /*****************************/  
/**********************         CREAR-DOC                     ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
    //Simplemente una pagina que nos muetre los docs

    public function createAlert(){
    	return view('dashboard.alerts.createAlert');
    }

/****************************************************************************************/
/*****************************/                            /*****************************/  
/**********************         GURDAR-ALert                     ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
    //Validar formulario
    //Le pasamos como primero parametro los datos que llegan por POST
    public function saveAlert (Request $request){
    	//Creamos una variable que se llama ValidateData
    	//Le pasamos en un array las reglas de validacion
    	$validateData = $this->validate($request, [
    		'title' =>'required | min:5',
    		'description'=> 'required',
    	]);


    	//Ahora vamos a guardar el alert en la base de datos
    	//Utilizamos la entidad de Alert y creamos un objeto nuevo
    	$alert = new Alert();
    	//Ahora creo una variable USER para guardar la informacion del usuario identificado
    	$user = \Auth::user();
    	// Ahora al alert le asigno un valor a cada una de las propiedades, con las variables que me llegan por POST
    	$alert->user_id = $user->id;
    	$alert->title = $request->input('title');
    	$alert->description = $request ->input('description');
    	//Ahora para guardar el nuevo objeto en la BD en la base de datos utilizo metodo SAVE()

    	// -----  UPLOAD IMAGE ----//
    	//Antes de salvar tenemos que recoger el fichero de la request que se llama IMAGE
    	$image = $request->file('image');
    	// Entonces comprobamos si la imagen nos llega
    	if ($image){
    		//Si nos llega recojemos el path de la imagen
    		//Obtenemos el nombre del fichero temporal
    		//Le concateno time() para evitar tener el mismo archivo
    		$imageAlert_path = time().$image ->getClientOriginalName();
    		//Ahora tenemos que utilizar el OBJETO storage y el metodo DISK para guardar todo dentro de la carpeta IMAGES el objeto $image que acabamos de conseguir
    		\Storage::disk('images')->put($imageAlert_path,\File::get($image));
    		//Por ultimo asignamos al objeto IMAGE el valor del $image_path
    		$alert->image = $imageAlert_path;
    	}

    	$alert ->save();
    	//Cuando termino le ahago una redireccion a HOME
    	//Ademas añado una alerta que diga que el video se ha subido correctamente
    	return redirect()->route ('dashboard::index')->with(array(
    		'message'=> 'La alerta  se ha guardado correctamente'
    	 ));
    //*********CARPETA STORAGE ******************//
    //Para que esto funcione correctamente necesito configurar los Drivers del Storage. Para ello CONFIG>fileSystems.php y como solo esta el Disk public me tengo que crear otros dos discos. Unos para IMAGES y otro para VIDEOS, o para todo lo que necesite.
    //*********************************************//
    }

 /****************************************************************************************/
/*****************************/                            /*****************************/  
/**********************         GET-ALERT                   ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
    // TEnemos que pasar el $doc_ID que el el detalle del doc que deseamos mostrar

    public function getAlertDetail ($alert_id){
        //Creamos una variable alert que haga un FIND a la BD para conseguir el registro que deseamos mostrar. Esto lo podemos hacer con ELOQUENT y el metodo find- Le solicitamos el alert_id. Diferente como se hace con el QUERY builder
        $alert = Alert::find($alert_id);
        //Cargamos una vista que se llma doc y un array con la infomracion del doc a cargar
        return view('alert.detailAlert', array(
            //DOC va a llevar dentro todo el contenido de la variable $doc
            'alert' =>$alert
        //POr ultimo es necesario crear la vista para este metodo
        ));

    }
/****************************************************************************************/
/*****************************/                            /*****************************/  
/**********************         GET-IMAGE                     ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
    /* Este metodo recibo por URL el nombre del fichero*/
    public function getImage($filename){
    	//Creamos una variable $file para acceder al STORAGE y con el metodo (disk) le indicamos en que carpeta esta nuestra imagen. COn el metodo get le indicamos cual fichero queremos. CUAL?. PUes el que nos llegue por parametro $filename
        //La \ se la pongo adelante al Storage porque aunque tengo importado el metodo de Storage arriba, por algun motivo no fucniona sin la raya
    	$file = \Storage::disk('images')->get($filename);
    	//POr ultimo regresamos un response con un $file que nos devuelve el fichero en si
    	return new Response($file,200);
    	/* Ahora necesitamos crear una ruta para este metodo en web.php*/

    }


/****************************************************************************************/
/*****************************/                            /*****************************/  
/**********************         DELETE-ALERT                    ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
    // ---------ELIMINAR DOC --------//
    /* Este metodo recibo por URL el nombre del fichero*/
    public function delete($alert_id){
        //Lo primero es conseguir una variable del usuario identificado
        $user = \Auth::user();
        //Ahora hacemos un find para conseguir el doc que deseamos borrar
        $alert = Alert::find($alert_id);
        //Tambien hacemos un find de los comentarios que deseamos borrar. Asegurarse de tener importado el modelo de comment
        //Esto nos va a sacar todos los comentarios cuyo doc_id sea el correspondiente
        //$comments = CommentDoc::where('doc_id',$doc_id)->get();
        //$comments = CommentDoc::where('doc_id',$doc_id);
        //Ahora tenenmos que comprobar si el usuario existe y el que solamente cuando estemos identificados como el ususario dueño del doc podamos usarlo. SI otro lo intenta no va a poder
        //if($user && $doc->user_id == $user->id){
            //Antes de borrar el doc tenemos que borar los comentarios
            //Method delete does not exist----Para evitar este error hacemos un IF antes de borra comentarios para asegurarnos de que existan comentarios. Lo hacemos con un IF

            /*******Warning: count(): Parameter must be an array or an object that implements Countable***/
            //if($comments && count($comments)>=1) esto no provoca el error. EL is_array lo soluciona
            /*if(is_array($comments) && count($comments)>=1){
                foreach ($comments as $comment) {
                     $comments->delete();                 
                }            
            }*/
            //Despues tenemos que eliminar las imagenes y los docs a nivel de disco fisico. Eliminarlos del Storage. Utilizamos el OBJETO  doc y la PROPIEDAD image.
            \Storage::disk('images')->delete($doc->image);
            //Finamente eliminar el registro del doc en la base de datos
            $alert->delete();
        
        //Lo ultimo que hace este metodo es redirigirnos a HOME con el aaray de mensaje para que me diga si se elimino o no correctamente
        return redirect()->route('index')->with(array(
            'message'=>'Alerta eliminada correctamente'
        ));
    
    }


/****************************************************************************************/
/*****************************/                            /*****************************/  
/**********************         EDIT-ALERT                    ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
	//Recibo la variable ID del alert por URL
	public function edit($alert_id){
	     //Lo primero es conseguir una variable del usuario identificado
	    $user = \Auth::user();
	    //Creamos una variable alert para conseguir el objeto del alert que estamos intentando editar. Utilizamos FindOrFail para que nos devuelva un error en caso de que no exista en la base de datos
	    $alert = Alert::findOrFail($alert_id);

	    //Ahora tenenmos que comprobar si el usuario existe y el que solamente cuando estemos identificados como el ususario dueño del alert podamos usarlo. SI otro lo intenta no va a poder
	    if($user && $alert->user_id == $user->id){
	        //Devolvemos la vista edit dentro de la carpeta de alerts
	        return view('dashboard.alerts.edit', array('alert' => $alert));
	    //Si esto no funcionara hacemos una redireccion a la HOME sin mensaje
	    }else{
	        return redirect()->route('alerts');
	    }
	    //Ahora es necesario crear la vista de Edit
	}
/****************************************************************************************/
/*****************************/                            /*****************************/  
/**********************         UPDATE-ALERT-DB                   ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
	//Recibo la variable ID del video por URL, y tambien le paso la request para poder recibir los parametro que me lleguen por POST
	public function update($alert_id, Request $request){
	     ///Lo primero que vamos a hacer es validar el forrmulario y le pasamos la request para que recoja todos los datos que llegan por POST. Ademas le vamos a pasar un array con las reglas de validacion.
	    $validate = $this->validate($request, array(
	            'title' =>'required | min:5',
	            'description'=> 'required',

	    ));

	    //Ahora toca conseguir el objeto del alert, con un FIND
	    $alert = Alert::findOrFail($alert_id);
	    //Tambien vamos a conseguir el usuario identificado
	    $user = \Auth::user();
	    //Ahora le asigno los valores a cada una de las propuedades del objeto del doc.
	    $alert->user_id = $user->id;
	    $alert->title = $request->input('title');
	    $alert->description = $request->input('description');

	    //Ahora lo que tenemos que hacer es recojer los ficheros de imagen y video para guradarlos en la base de datos
	    //Creo la variable image que me recoja el archivo que que me llega por la request , en este caso image
	    $image = $request->file('image');
	    // Entonces comprobamos si la imagen nos llega
	    if ($image){
	        //********OJO*************//
	         //Antes de actualizar el video tenemos que eliminar el registro anterior para que La imagen no se reporduzca una y otra vez. Es decir si no elimino el registro cada vez que se actualize la imagen se crea una copia y nos satura la base de datos
	         \Storage::disk('images')->delete($alert->image);
	         //*************************//

	         //Si nos llega recojemos el path de la imagen
	        //Obtenemos el nombre del fichero temporal
	        //Le concateno time() para evitar tener el mismo archivo
	         $image_path = time().$image ->getClientOriginalName();
	        //Ahora tenemos que utilizar el OBJETO storage y el metodo DISK para guardar todo dentro de la carpeta IMAGES el objeto $image que acabamos de conseguir
	         \Storage::disk('images')->put($image_path,\File::get($image));
	        //Por ultimo asignamos al objeto IMAGE el valor del $image_path
	         $alert->image = $image_path;
	    }


	///Una vez que todo esto este listo ya podemos hacer un UPDARe en la base de datos.
	    $alert->update();

	    return redirect()->route('index')->with(array('message'=>'La alerta se ha actualizado correctamente'));
	    //Finalmente ceramos la ruta.

		}


/****************************************************************************************/
/*****************************/                            /*****************************/  
/**********************         TOGGLE ACCESS                   ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/

    /* Aqui recivo la REQUEST y el ID del usuario que me viene por la URL*/
    public function toggleAccess(Request $request, $id)
    {   
        /*Almaceno en la variable DOc el documento que coincide con el ID 
          que me llega por la URL
         *Del lado del formulario lo que pedi fue el ($item->id)
         */
        $alert = Alert::findOrFail($id);
        /*User va a llamar a la funcion del modelo DOC 'toggleAccess'
         *Este metodo pide una variable TYPE
         *Entonces aqui recojo la variable de 'type' que vienen dentro del request
         que me llega por la URL
         */
        $alert->toggleAccess($request->get('type'));

        /*Guardo el objeto en la base de datos*/
        $alert->save();

        /*Redirijo a la base de datos con un mensaje que contiene el nombre completo del usuario*/
        return redirect()->route('dashboard::alertsIndex', ['page' => $request->query('page')])->with([
            'message' => 'Se han actualizado la publicacion de esta alerta',
            'level' => 'success'
        ]);
}

/****************************************************************************************/
/*****************************/                            /*****************************/  
/**********************         TOGGLE ACCESS 1                  ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/

    /* Aqui recivo la REQUEST y el ID del usuario que me viene por la URL*/
    public function toggleAccess1(Request $request, $id)
    {   
        /*Almaceno en la variable DOc el documento que coincide con el ID 
          que me llega por la URL
         *Del lado del formulario lo que pedi fue el ($item->id)
         */
        $alert = Alert::findOrFail($id);
        /*User va a llamar a la funcion del modelo DOC 'toggleAccess'
         *Este metodo pide una variable TYPE
         *Entonces aqui recojo la variable de 'type' que vienen dentro del request
         que me llega por la URL
         */
        $alert->toggleAccess1($request->get('type'));

        /*Guardo el objeto en la base de datos*/
        $alert->save();

        /*Redirijo a la base de datos con un mensaje que contiene el nombre completo del usuario*/
        return redirect()->route('dashboard::alertsIndex', ['page' => $request->query('page')])->with([
            'message' => 'Se han actualizado la publicacion de esta alerta',
            'level' => 'success'
        ]);
}
}
