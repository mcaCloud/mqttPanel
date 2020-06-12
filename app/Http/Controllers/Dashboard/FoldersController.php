<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
/*Con esto importo los metodos (authorize,rules,message)*/
/*Es unicamente para la creacion y actualizacion de usuarios*/
use App\Http\Requests\UserRequest;

//Para poder almacenar en el Storage
use Illuminate\Support\Facades\Storage;

/********IMPORTANTE***********************/
/*Aqui importo los MODELOS de Role y Permissions*/
/*Dentro de estos modelos ya se encuentran importados los TRAIT de HasRoles y HasPermissions*/
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
/********IMPORTANTE***********************/
/*Importo el MODELO de User*/
use App\User;
use App\File;
use App\Folder;

/* Middleware vendor/laravel/framework/src/iluminate/auth/middleware/Authenticate*/
use Auth;

use DB;

/*Para recibir las notificacion desde la base de datos y desplegarlas en el panel de control*/
use Illuminate\Support\Facades\Notification;

/*Esto es para poder utilizar el ojeto REQUEST*/
use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Gate;
//use App\Http\Controllers\Controller;
//use App\Http\Requests\Admin\StoreFoldersRequest;
//use App\Http\Requests\Admin\UpdateFoldersRequest;
//use Illuminate\Support\Facades\Session;
//use Illuminate\Support\Facades\Input;

class FoldersController extends Controller
{
/*******************INDEX*********************************/
    /*Recojo la request que me llega por URL*/
      public function index(Request $request) {
          /*THIS es un puntero que hace referencia a un OBJETO*/
          /*El AUTHORIZE es un metodo del controller App\Http\Requests\UserRequest
          /* Se autoriza a quien tenga permiso de 'listar-usuarios'*/
          //$this->authorize('listar-usuarios');
          /*Creo un variable FOLDERS para que me guarde el QUERY el modelo de folders*/
          $folders = Folder::query();

          $files =  DB::table('files')->get();

          //$files =  File::where('folder_id',);

          return view('dashboard.folders.index', [
              'items'   => $folders->paginate(config('ui.admin.page_size')),
              'page'    => $request->query('page'),
              'files'   => $files
          ]);
      }
/******************* /INDEX*********************************/

//*******************************************//
    //-------------CREAR UN DOC------------------
    //Simplemente una pagina que nos muetre los docs

    public function create(){
    	return view('dashboard.folders.create');
    }


//*******************************************//
    //-------------GUARDAR UN DOC------------------
    //Validar formulario
    //Le pasamos como primero parametro los datos que llegan por POST
    public function store (Request $request){
    	//Creamos una variable que se llama ValidateData
    	//Le pasamos en un array las reglas de validacion
        /*
    	$validateData = $this->validate($request, [
    		'title' =>'required | min:5',
    		'description'=> 'required',
    		//Los formatos en los que puede venir el doc
    		'doc' => 'mimetypes:application/pdf,application/msword,application/vnd.ms-powerpoint, application/x-rar-compressed,application/x-tar,application/zip, application/x-7z-compressed,application/octet-stream,application/vnd.ms-excel,application/vnd.ms-powerpoint,application/vnd.ms-access'
    	]);*/
        $validateData = $this->validate($request, [
            'title' =>'required | min:5',
        ]);

    	//Ahora vamos a guardar el FOLDER en la base de datos
    	//Utilizamos la entidad de FOLDER y creamos un objeto nuevo
    	$folder = new Folder();
    	//Ahora creo una variable USER para guardar la informacion del usuario identificado
    	$user = \Auth::user();
    	// Ahora al doc le asigno un valor a cada una de las propiedades, con las variables que me llegan por POST
    	$folder ->created_by_id = $user->id;
        
    	$folder ->name = $request->input('title');
    	
    	$folder ->save();

    	//Cuando termino le ahago una redireccion a HOME
    	//Ademas añado una alerta que diga que el doc se ha subido correctamente
    	return redirect('dashboard/folders')->with(array(
    		'message'=> 'El folder se ha creado correctamente'
    	 ));


    //*********CARPETA STORAGE ******************//
    //Para que esto funcione correctamente necesito configurar los Drivers del Storage. Para ello CONFIG>fileSystems.php y como solo esta el Disk public me tengo que crear otros dos discos. Unos para IMAGES y otro para DOCS, o para todo lo que necesite.
    //*********************************************//
    	
    }

    //*****************DOWNLOAD******************//
    // TEnemos que pasar el $ID que el el detalle del doc que deseamos mostrar
    public function show($id){

        $files = File::where('folder_id', $id)->get();
        //Creamos una variable folder que haga un FIND a la BD para conseguir el registro que deseamos mostrar. Esto lo podemos hacer con ELOQUENT y el metodo find- Le solicitamos el doc_id. Diferente como se hace con el QUERY builder
        $folder = Folder::findOrFail($id);

        $userFilesCount = File::where('created_by_id', Auth::getUser()->id)->count();

        //Cargamos una vista que se llma doc y un array con la infomracion del doc a cargar

        return view('dashboard.folders.show', compact('folder','files','userFilesCount'));
    }


// *******************************************//
    // ---------ELIMINAR DOC --------//
    /* Este metodo recibo por URL el nombre del fichero*/
    public function destroy(Request $request,$id){
        //Lo primero es conseguir una variable del usuario identificado
        $user = \Auth::user();
        //Ahora hacemos un find para conseguir el doc que deseamos borrar
        $folder = Folder::findOrFail($id);
        
        $folder->delete();
    
        //Lo ultimo que hace este metodo es redirigirnos a HOME con el aaray de mensaje para que me diga si se elimino o no correctamente
        return redirect('dashboard/folders')->with(array(
            'message'=>'Documento eliminado correctamente'
        ));
    }

// *******************************************//
// ---------EDITAR DOC --------//
//Recibo la variable ID del doc por URL
public function edit($doc_id){
     //Lo primero es conseguir una variable del usuario identificado
    $user = \Auth::user();
    //Creamos una variable doc para conseguir el objeto del doc que estamos intentando editar. Utilizamos FindOrFail para que nos devuelva un error en caso de que no exista en la base de datos
    $doc = Doc::findOrFail($doc_id);

    //Ahora tenenmos que comprobar si el usuario existe y el que solamente cuando estemos identificados como el ususario dueño del doc podamos usarlo. SI otro lo intenta no va a poder
    if($user && $doc->user_id == $user->id){
        //Devolvemos la vista edit dentro de la carpeta de docs
        return view('doc.editDoc', array('doc' => $doc));
    //Si esto no funcionara hacemos una redireccion a la HOME sin mensaje
    }else{
        return redirect()->route('docs');
    }
    //Ahora es necesario crear la vista de Edit
}
//*******************************************//
// ---------ACTUALIZAR DOC EN BD--------//
//Recibo la variable ID del doc por URL, y tambien le paso la request para poder recibir los parametro que me lleguen por POST
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


///Una vez que todo esto este listo ya podemos hacer un UPDARe en la base de datos.
    $doc->update();

    return redirect()->route('docs')->with(array('message'=>'EL documento se ha actualizado correctamente'));
    //Finalmente ceramos la ruta.
}


    public function massDestroy(Request $request)
    {
        if (! Gate::allows('folder_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Folder::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
}

    // Restore Folder from storage.

    public function restore($id)
    {
        if (! Gate::allows('folder_delete')) {
            return abort(401);
        }
        $folder = Folder::onlyTrashed()->findOrFail($id);
        $folder->restore();

        return redirect()->route('admin.folders.index');
    }

 
     // Permanently delete Folder from storage.

    public function perma_del($id)
    {
        if (! Gate::allows('folder_delete')) {
            return abort(401);
        }
        $folder = Folder::onlyTrashed()->findOrFail($id);
        $folder->forceDelete();

        return redirect()->route('admin.folders.index');
    }

}
