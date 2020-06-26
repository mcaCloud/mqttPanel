<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

//Todas las request que nos llegan por HTT
use App\Http\Requests;

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
use App\Cathegory;
use App\Product;
use App\Office;

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
    //-------------CREAR UN FOLDER------------------
    //Simplemente una pagina que nos muetre los docs

    public function create(Request $request){

        //Saco el ROLE del usuario que crea el file
        $roleId = Auth::getUser()->role_id;

        //La variable me guarda la busqueda en la base de datos donde el campo de created_id es igual al ID del ususario actual. Y finalmente cuento las veces.
        $userFilesCount = Folder::where('created_by_id', Auth::getUser()->id)->count();

        $cathegory = $request->id;


        $offices = Office::query()->get();

        //Esta variable me guarda la query a la tabla de FOLDER paar sacar el objeto que tenga este ID..
        $cathegoryName = Cathegory::find($request->id);

        $created_bies = User::get()->pluck('name', 'id');

        return view('dashboard.folders.create', compact('cathegory','offices','cathegoryName', 'created_bies', 'userFilesCount', 'roleId'));
    }


//*******************************************//
    //-------------GUARDAR UN FOLDER------------------
    //Validar formulario
    //Le pasamos como primero parametro los datos que llegan por POST
    public function store (Request $request){
    	//Creamos una variable que se llama ValidateData

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

        //Me llama el INPUT del formulario create que tiene por nombre 'title'
    	$folder ->name = $request->input('title');
    	
        //Me llama el IMPUT del formulario con nombre 'cathegory' esto lo hago para conseguir el ID del Cathegory. Esto lo guarde en un input de typo hidden.
        $cathegoryID = $request->input('cathegory');

        /****************************************************/
        //Aqui recojo la informacion del select box en la vista
        $officeID = $request->input('office_id');
        /****************************************************/

        //Ahora creo una variable USER para guardar la informacion del usuario identificado
        $user = \Auth::user();

        // Ahora al objeto file que cree  le asigno un valor a cada una de las propiedades, con las variables que me llegan por POST
        $folder ->created_by_id = $user->id;

        $folder ->cathegory_id = $cathegoryID;

        $folder ->office_id = $officeID;


        //Ahora para guardar el nuevo objeto en la BD en la base de datos utilizo metodo SAVE()
    	$folder ->save();

        //Cuando termino le ahago una redireccion a HOME
        //Ademas añado una alerta que diga que el doc se ha subido correctamente
        return redirect('dashboard/categorias/'.$request->input('cathegory'))->with(array(
            'message'=> 'El servicio se ha creado correctamente'
         ));

    //*********CARPETA STORAGE ******************//
    //Para que esto funcione correctamente necesito configurar los Drivers del Storage. Para ello CONFIG>fileSystems.php y como solo esta el Disk public me tengo que crear otros dos discos. Unos para IMAGES y otro para DOCS, o para todo lo que necesite.
    //*********************************************//
    	
    }

    //*****************DOWNLOAD******************//
    // TEnemos que pasar el $ID que el el detalle del folder que deseamos mostrar
    public function show($id){

        $product = Product::where('folder_id', $id)->get();
        //Creamos una variable folder que haga un FIND a la BD para conseguir el registro que deseamos mostrar. Esto lo podemos hacer con ELOQUENT y el metodo find- Le solicitamos el doc_id. Diferente como se hace con el QUERY builder
        $folder = Folder::findOrFail($id);

        $userFilesCount = File::where('created_by_id', Auth::getUser()->id)->count();

        //Cargamos una vista que se llma doc y un array con la infomracion del doc a cargar

        return view('dashboard.folders.show', compact('folder','product','userFilesCount'));
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
        return redirect()->route('dashboard::categorias.show',['id' => $folder->cathegory_id]);
    }

// *******************************************//
// ---------EDITAR DOC --------//
//Recibo la variable FOLDER_ID de la categoria por URL junto con el REQUEST para poder utilizar los datos
public function edit(Request $request,$folder_id){
     //Lo primero es conseguir una variable del usuario identificado
    $user = \Auth::user();

    //Creamos una variable doc para conseguir el objeto del doc que estamos intentando editar. Utilizamos FindOrFail para que nos devuelva un error en caso de que no exista en la base de datos
    $folder = Folder::findOrFail($folder_id);

    $cathegory = Cathegory::where('id',$folder->cathegory_id);

    $offices = Office::query()->get();
    //Ahora tenenmos que comprobar si el usuario existe y el que solamente cuando estemos identificados como el ususario dueño del doc podamos usarlo. SI otro lo intenta no va a poder
    if($user && $folder->created_by_id == $user->id){
        //Devolvemos la vista edit dentro de la carpeta de docs
        return view('dashboard.folders.edit', array(

            'folder' => $folder,
            'offices' =>$offices,
            'page' => $request->query('page'),

            /*Esto es para que me mantenga la oficina que tenia el servicio ('folder') anteriormente
            * El ID del SELECT en el formulario esta conectado con esto para que me popule el OLD value del officeID.
            */   
            /* 'office_id' me pasa el 'office_id' anterior que me llego por la request, entonces de la QUERY de 'Folder' hago un pluck del 'office_id' y lo envio como un array*/      
            'office_id' => $request->old('office_id',$folder->pluck('office_id')->toArray()),
        ));
    //Si esto no funcionara hacemos una redireccion a la HOME sin mensaje
    }else{
        return redirect()->route('folders');
    }
    //Ahora es necesario crear la vista de Edit
}
//*******************************************//
// ---------ACTUALIZAR DOC EN BD--------//
//Recibo la variable ID del doc por URL, y tambien le paso la request para poder recibir los parametro que me lleguen por POST
public function update($folder_id, Request $request){
     ///Lo primero que vamos a hacer es validar el forrmulario y le pasamos la request para que recoja todos los datos que llegan por POST. Ademas le vamos a pasar un array con las reglas de validacion.
    $validate = $this->validate($request, array(
            'title' =>'required | min:5',
    ));

    //Ahora toca conseguir el objeto del doc, con un FIND
    $folder = Folder::findOrFail($folder_id);
    
    //Tambien vamos a conseguir el usuario identificado
    $user = \Auth::user();

    $folder->name = $request->input('title');

    $folder->appt_req = $request->input('appt_req');

    $folder->notes = $request->input('notes');
    $folder->description = $request->input('description');
    
    /****************************************************/
    //Aqui recojo la informacion del select box en la vista
    $officeID = $request->input('office_id');
    /****************************************************/

    $folder ->office_id = $officeID;
///Una vez que todo esto este listo ya podemos hacer un UPDARe en la base de datos.
    $folder->update();

    //Session::flash('flash_message', 'Folder successfully added!');


return redirect()->route('dashboard::categorias.show',['id' => $folder->cathegory_id])->with(array('message'=>'El servicio se ha actualizado correctamente'));

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

/*******************TOGGLE**************************************/
    /* Aqui recivo la REQUEST y el ID del usuario que me viene por la URL*/
    public function toggleAccess(Request $request, $id)
    {   
        /*Almaceno en la variable User el usuario que coincide con el ID 
          que me llega por la URL
         *Del lado del formulario lo que pedi fue el ($item->id)
         */
        $folder = Folder::findOrFail($id);
        /*User va a llamar a la funcion del modelo USER 'toggleAccess'
         *Este metodo pide una variable TYPE
         *Entonces aqui recojo la variable de 'type' que vienen dentro del request
         que me llega por la URL
         */
        $folder->toggleAccess($request->get('type'));

        /*Guardo el objeto en la base de datos*/
        $folder->save();

        /*Redirijo a la base de datos con un mensaje que contiene el nombre completo del usuario*/
       return redirect()->back();
    }
/*****************************************************************/


}
