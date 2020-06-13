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
use App\Doc;
use App\DocComment;

class DocController extends Controller
{


 /*************************************************************************************/
/*****************************/                            /*****************************/  
/**********************         CREAR-DOC                     ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
    //Simplemente una pagina que nos muetre los docs

    public function createDoc(){
    	return view('dashboard.docs.createDoc');
    }

/****************************************************************************************/
/*****************************/                            /*****************************/  
/**********************         GURDAR-DOC                     ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
    //Validar formulario
    //Le pasamos como primero parametro los datos que llegan por POST
    public function saveDoc (Request $request){
    	//Creamos una variable que se llama ValidateData
    	//Le pasamos en un array las reglas de validacion
    	$validateData = $this->validate($request, [
    		'title' =>'required | min:5',
    		'description'=> 'required',
    	]);

    	$validator = Validator::make($request->all(), [
            'resume'   => 'mimes:doc,pdf,docx,zip'
        ]);

    	//Ahora vamos a guardar el doc en la base de datos
    	//Utilizamos la entidad de DOC y creamos un objeto nuevo
    	$doc = new Doc();
    	//Ahora creo una variable USER para guardar la informacion del usuario identificado
    	$user = \Auth::user();
    	// Ahora al video le asigno un valor a cada una de las propiedades, con las variables que me llegan por POST
    	$doc->user_id = $user->id;
    	$doc->title = $request->input('title');
    	$doc->description = $request ->input('description');
    	//Ahora para guardar el nuevo objeto en la BD en la base de datos utilizo metodo SAVE()

    	// -----  UPLOAD IMAGE ----//
    	//Antes de salvar tenemos que recoger el fichero de la request que se llama IMAGE
    	$image = $request->file('image');
    	// Entonces comprobamos si la imagen nos llega
    	if ($image){
    		//Si nos llega recojemos el path de la imagen
    		//Obtenemos el nombre del fichero temporal
    		//Le concateno time() para evitar tener el mismo archivo
    		$imageDoc_path = time().$image ->getClientOriginalName();
    		//Ahora tenemos que utilizar el OBJETO storage y el metodo DISK para guardar todo dentro de la carpeta IMAGES el objeto $image que acabamos de conseguir
    		\Storage::disk('images')->put($imageDoc_path,\File::get($image));
    		//Por ultimo asignamos al objeto IMAGE el valor del $image_path
    		$doc->image = $imageDoc_path;
    	}

		// -----  UPLOAD DOC ----//
    	$doc_file = $request->file('doc');

    	if($doc_file){

    		$doc_path = time().$doc_file ->getClientOriginalName();
    		\Storage::disk('docs')->put($doc_path,\File::get($doc_file));

    		$doc->doc_path = $doc_path;

    	}
    	$doc ->save();
    	//Cuando termino le ahago una redireccion a HOME
    	//Ademas añado una alerta que diga que el video se ha subido correctamente
    	return redirect()->route ('index')->with(array(
    		'message'=> 'El documento se ha subido correctamente'
    	 ));
    //*********CARPETA STORAGE ******************//
    //Para que esto funcione correctamente necesito configurar los Drivers del Storage. Para ello CONFIG>fileSystems.php y como solo esta el Disk public me tengo que crear otros dos discos. Unos para IMAGES y otro para VIDEOS, o para todo lo que necesite.
    //*********************************************//
    }

 /****************************************************************************************/
/*****************************/                            /*****************************/  
/**********************         GET-DOC                   ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
    // TEnemos que pasar el $doc_ID que el el detalle del doc que deseamos mostrar

    public function getDocDetail ($doc_id){
        //Creamos una variable doc que haga un FIND a la BD para conseguir el registro que deseamos mostrar. Esto lo podemos hacer con ELOQUENT y el metodo find- Le solicitamos el doc_id. Diferente como se hace con el QUERY builder
        $doc = Doc::find($doc_id);
        //Cargamos una vista que se llma doc y un array con la infomracion del doc a cargar
        return view('doc.detailDoc', array(
            //DOC va a llevar dentro todo el contenido de la variable $doc
            'doc' =>$doc
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
/**********************         DELETE-DOC                     ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
    // ---------ELIMINAR DOC --------//
    /* Este metodo recibo por URL el nombre del fichero*/
    public function delete($doc_id){
        //Lo primero es conseguir una variable del usuario identificado
        $user = \Auth::user();
        //Ahora hacemos un find para conseguir el doc que deseamos borrar
        $doc = Doc::find($doc_id);
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
            \Storage::disk('docs')->delete($doc->doc_path);
            \Storage::disk('images')->delete($doc->image);
            //Finamente eliminar el registro del doc en la base de datos
            $doc->delete();
        
        //Lo ultimo que hace este metodo es redirigirnos a HOME con el aaray de mensaje para que me diga si se elimino o no correctamente
        return redirect()->route('index')->with(array(
            'message'=>'Documento eliminado correctamente'
        ));
    
    }


/****************************************************************************************/
/*****************************/                            /*****************************/  
/**********************         EDIT-DOC                     ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
	//Recibo la variable ID del doc por URL
	public function edit($doc_id){
	     //Lo primero es conseguir una variable del usuario identificado
	    $user = \Auth::user();
	    //Creamos una variable doc para conseguir el objeto del doc que estamos intentando editar. Utilizamos FindOrFail para que nos devuelva un error en caso de que no exista en la base de datos
	    $doc = Doc::findOrFail($doc_id);

	    //Ahora tenenmos que comprobar si el usuario existe y el que solamente cuando estemos identificados como el ususario dueño del doc podamos usarlo. SI otro lo intenta no va a poder
	    if($user && $doc->user_id == $user->id){
	        //Devolvemos la vista edit dentro de la carpeta de docs
	        return view('dashboard.docs.edit', array('doc' => $doc));
	    //Si esto no funcionara hacemos una redireccion a la HOME sin mensaje
	    }else{
	        return redirect()->route('docs');
	    }
	    //Ahora es necesario crear la vista de Edit
	}
/****************************************************************************************/
/*****************************/                            /*****************************/  
/**********************         UPDATE-DOC-DB                   ************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
	//Recibo la variable ID del video por URL, y tambien le paso la request para poder recibir los parametro que me lleguen por POST
	public function update($doc_id, Request $request){
	     ///Lo primero que vamos a hacer es validar el forrmulario y le pasamos la request para que recoja todos los datos que llegan por POST. Ademas le vamos a pasar un array con las reglas de validacion.
	    $validate = $this->validate($request, array(
	            'title' =>'required | min:5',
	            'description'=> 'required',
	            //Los formatos en los que puede venir el doc
	            'doc' => 'mimetypes:pdf'
	    ));

	    //Ahora toca conseguir el objeto del doc, con un FIND
	    $doc = Doc::findOrFail($doc_id);
	    //Tambien vamos a conseguir el usuario identificado
	    $user = \Auth::user();
	    //Ahora le asigno los valores a cada una de las propuedades del objeto del doc.
	    $doc->user_id = $user->id;
	    $doc->title = $request->input('title');
	    $doc->description = $request->input('description');

	    //Ahora lo que tenemos que hacer es recojer los ficheros del documento para guradarlos en la base de datos

	    // -----  UPLOAD DOC ----//
	    $doc_file = $request->file('doc');

	    if($doc_file){
	        //********OJO*************//
	        //Antes de actualizar el doc tenemos que eliminar el registro anterior para que el doc no se reporduzca una y otra vez. Es decir si no elimino el registro cada vez que se actualize el doc se crea una copia y nos satura la base de dato.
	        Storage::disk('docs')->delete($doc->doc_path);
	        //*************************//

	        ///Una vez borrado el registro ya se puede actualizar.
	         $doc_path = time().$doc_file ->getClientOriginalName();
	        \Storage::disk('docs')->put($doc_path,\File::get($doc_file));

	        $doc->doc_path = $doc_path;
	    }

	    //Ahora lo que tenemos que hacer es recojer los ficheros de imagen y video para guradarlos en la base de datos
	    //Creo la variable image que me recoja el archivo que que me llega por la request , en este caso image
	    $image = $request->file('image');
	    // Entonces comprobamos si la imagen nos llega
	    if ($image){
	        //********OJO*************//
	         //Antes de actualizar el video tenemos que eliminar el registro anterior para que La imagen no se reporduzca una y otra vez. Es decir si no elimino el registro cada vez que se actualize la imagen se crea una copia y nos satura la base de datos
	         \Storage::disk('images')->delete($doc->image);
	         //*************************//

	         //Si nos llega recojemos el path de la imagen
	        //Obtenemos el nombre del fichero temporal
	        //Le concateno time() para evitar tener el mismo archivo
	         $image_path = time().$image ->getClientOriginalName();
	        //Ahora tenemos que utilizar el OBJETO storage y el metodo DISK para guardar todo dentro de la carpeta IMAGES el objeto $image que acabamos de conseguir
	         \Storage::disk('images')->put($image_path,\File::get($image));
	        //Por ultimo asignamos al objeto IMAGE el valor del $image_path
	         $doc->image = $image_path;
	    }


	///Una vez que todo esto este listo ya podemos hacer un UPDARe en la base de datos.
	    $doc->update();

	    return redirect()->route('index')->with(array('message'=>'EL documento se ha actualizado correctamente'));
	    //Finalmente ceramos la ruta.

		}

/****************************************************************************************/
/*****************************/                            /*****************************/  
/**********************         UPDATE-VIDEO-DB                   ************************/ 
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
	           return redirect()->route('docs');
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
	        return redirect()->route('docSearch',array('search' =>$search, 'filter' =>$filter));
	    }
	    /**************Si hay filtro***********/
	    //Aqui vamos a optimizar la consulta para que queda perfecta
	    //Creamos dos variable que son las que va a utilizar el ORDERBY
	    //Estas con las variables que cambian en el filtro cunado seleccionamos las opciones
	    $colum ='id';
	    $order = 'desc';
	    //En caso de que el filtro exista, es decir que no es NULL
	    if (!is_null($filter)) {
	        //Hacemos el ordenamiento de los doc de acuerdo a los criterios del filtro
	        //Ahora tenemos que hacer un acomprobarcion con el IF
	        if ($filter == 'new') {
	            $colum ='id';
	            $order = 'desc';
	        }
	        if ($filter == 'old') {
	            $colum ='id';
	            $order = 'asc';
	        }
	        if ($filter == 'alfa') {                                
	            $colum ='title';
	            $order = 'asc';
	        }

	    }
	    /***************************************/
	    //Vamos a hacer una QUERY , para que busque en el titulo la informacion
	    //Cuando realicemos la busqueda, si el titulo es igual a lo que venga en SEARCH que nos de el resultado
	    //Sacame todos los doc cuando el titulo contenga lo que hemos buscado
	    //Los % los pongo para que me saque la coincidencias de la Primera letra y la Ultima, no solo el resultado completo
	    
	    $docs = Doc::where('title','LIKE','%'.$search.'%')
	                            //Ha esto le agregamos el ORDERBY con los valores de las variables de arriba y el paginate
	                            ->orderBy($colum,$order)
	                            ->paginate(5);

	    return view('doc.searchDoc', array(
	        'docs'=> $docs,
	        'search'=> $search
	    ));
	}
}
