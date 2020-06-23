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

class OfficeController extends Controller
{
    /*******************INDEX*********************************/
    /*Recojo la request que me llega por URL*/
      public function index(Request $request) {
          /*THIS es un puntero que hace referencia a un OBJETO*/
          /*El AUTHORIZE es un metodo del controller App\Http\Requests\UserRequest
          /* Se autoriza a quien tenga permiso de 'listar-usuarios'*/
          //$this->authorize('listar-usuarios');
          /*Creo un variable FOLDERS para que me guarde el QUERY el modelo de folders*/
          $offices = Office::query();

          //$files =  File::where('folder_id',);

          return view('dashboard.offices.index', [
              'items'   => $offices->paginate(config('ui.admin.page_size')),
              'page'    => $request->query('page'),
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
        $userFilesCount = Office::where('created_by_id', Auth::getUser()->id)->count();

        $office = $request->id;

        //Esta variable me guarda la query a la tabla de FOLDER paar sacar el objeto que tenga este ID..
        $officeName = Office::find($request->id);

        $created_bies = User::get()->pluck('name', 'id');

        return view('dashboard.offices.create', compact('office','officeName', 'created_bies', 'userFilesCount', 'roleId'));
    }


//*******************************************//
    //-------------GUARDAR UN FOLDER------------------
    //Validar formulario
    //Le pasamos como primero parametro los datos que llegan por POST
    public function store (Request $request){
    	//Creamos una variable que se llama ValidateData

        $validateData = $this->validate($request, [
            'name' =>'required | min:5',
            'street_name' =>'required | min:5',
            'street_number' =>'required',

        ]);

    	//Ahora vamos a guardar el FOLDER en la base de datos
    	//Utilizamos la entidad de FOLDER y creamos un objeto nuevo
    	$office = new Office();
    	//Ahora creo una variable USER para guardar la informacion del usuario identificado
    	$user = \Auth::user();
    	// Ahora al doc le asigno un valor a cada una de las propiedades, con las variables que me llegan por POST
    	$office ->created_by_id = $user->id;

        //Me llama el INPUT del formulario create que tiene por nombre 'title'
    	$office ->name = $request->input('name');
    	$office ->description = $request->input('description');
    	$office ->street_name = $request->input('street_name');
    	$office ->street_number = $request->input('street_number');
    	$office ->floor = $request->input('floor');
    	$office ->floor_door = $request->input('floor_door');
    	$office ->floor_letter = $request->input('floor_letter');
    	$office ->zip_code = $request->input('zip_code');
    	$office ->manual_directions = $request->input('manual_directions');
    	$office ->metro_station_1 = $request->input('metro_station_1');
    	$office ->metro_line_1 = $request->input('metro_line_1');
    	$office ->metro_station_2 = $request->input('metro_station_2');
    	$office ->metro_line_2 = $request->input('metro_line_2');
    	$office ->bus_line = $request->input('bus_line');
    	$office ->bus_line_letter = $request->input('bus_line_letter');
    	$office ->renfe_line = $request->input('renfe_line');
    	$office ->renfe_line_letter = $request->input('renfe_line_letter');
    	$office ->schedule_days = $request->input('schedule_days');
    	$office ->schedule_hours = $request->input('schedule_hours');
    	$office ->email = $request->input('email');
    	$office ->phone_number = $request->input('phone_number');
    	$office ->website = $request->input('website');


        //Me llama el INPUT del formulario con nombre 'office' esto lo hago para conseguir el ID del OFFICE. Esto lo guarde en un input de typo hidden.
        $folderID = $request->input('folder');

        //Ahora creo una variable USER para guardar la informacion del usuario identificado
        $user = \Auth::user();

        // Ahora al objeto file que cree  le asigno un valor a cada una de las propiedades, con las variables que me llegan por POST
        $office ->created_by_id = $user->id;

        $office ->folder_id = $folderID;

        //Ahora para guardar el nuevo objeto en la BD en la base de datos utilizo metodo SAVE()
    	$office ->save();

        //Cuando termino le ahago una redireccion a HOME
        //Ademas añado una alerta que diga que el doc se ha subido correctamente
        return redirect('dashboard/offices')->with(array(
            'message'=> 'La dirección se ha cargado correctamente'
         ));

    //*********CARPETA STORAGE ******************//
    //Para que esto funcione correctamente necesito configurar los Drivers del Storage. Para ello CONFIG>fileSystems.php y como solo esta el Disk public me tengo que crear otros dos discos. Unos para IMAGES y otro para DOCS, o para todo lo que necesite.
    //*********************************************//
    	
    }

    //*****************DOWNLOAD******************//
    // TEnemos que pasar el $ID que el el detalle del folder que deseamos mostrar
    public function show($id){


        //Creamos una variable folder que haga un FIND a la BD para conseguir el registro que deseamos mostrar. Esto lo podemos hacer con ELOQUENT y el metodo find- Le solicitamos el doc_id. Diferente como se hace con el QUERY builder
        $office = Office::findOrFail($id);

        $userFilesCount = File::where('created_by_id', Auth::getUser()->id)->count();

        //Cargamos una vista que se llma doc y un array con la infomracion del doc a cargar

        return view('dashboard.offices.show', compact('office','userFilesCount'));
    }


// *******************************************//
    // ---------ELIMINAR DOC --------//
    /* Este metodo recibo por URL el nombre del fichero*/
    public function destroy(Request $request,$id){
        //Lo primero es conseguir una variable del usuario identificado
        $user = \Auth::user();
        //Ahora hacemos un find para conseguir el doc que deseamos borrar
        $office = Office::findOrFail($id);
        
        $office->delete();
    
        //Lo ultimo que hace este metodo es redirigirnos a HOME con el aaray de mensaje para que me diga si se elimino o no correctamente
        return redirect('dashboard/offices')->with(array(
            'message'=>'Oficina eliminada correctamente'
        ));
    }

// *******************************************//
// ---------EDITAR OFFICE --------//
//Recibo la variable ID del doc por URL
public function edit($office_id){
     //Lo primero es conseguir una variable del usuario identificado
    $user = \Auth::user();
    //Creamos una variable doc para conseguir el objeto del doc que estamos intentando editar. Utilizamos FindOrFail para que nos devuelva un error en caso de que no exista en la base de datos
    $office = Office::findOrFail($office_id);
    //Ahora tenenmos que comprobar si el usuario existe y el que solamente cuando estemos identificados como el ususario dueño del doc podamos usarlo. SI otro lo intenta no va a poder
    if($user && $office->created_by_id == $user->id){
        //Devolvemos la vista edit dentro de la carpeta de docs
        return view('dashboard.offices.edit', array(

            'office' => $office

        ));
    //Si esto no funcionara hacemos una redireccion a la HOME sin mensaje
    }else{
        return redirect()->route('offices');
    }
    //Ahora es necesario crear la vista de Edit
}
//*******************************************//
// ---------ACTUALIZAR DOC EN BD--------//
//Recibo la variable ID del doc por URL, y tambien le paso la request para poder recibir los parametro que me lleguen por POST
public function update($office_id, Request $request){
     ///Lo primero que vamos a hacer es validar el forrmulario y le pasamos la request para que recoja todos los datos que llegan por POST. Ademas le vamos a pasar un array con las reglas de validacion.
    $validate = $this->validate($request, array(
            'name' =>'required | min:5',
    ));

    //Ahora toca conseguir el objeto del doc, con un FIND
    $office = Office::findOrFail($office_id);
    
    //Tambien vamos a conseguir el usuario identificado
    $user = \Auth::user();

        //Me llama el INPUT del formulario create que tiene por nombre 'title'
    	$office ->name = $request->input('name');
    	$office ->description = $request->input('description');
    	$office ->street_name = $request->input('street_name');
    	$office ->street_number = $request->input('street_number');
    	$office ->floor = $request->input('floor');
    	$office ->floor_door = $request->input('floor_door');
    	$office ->floor_letter = $request->input('floor_letter');
    	$office ->zip_code = $request->input('zip_code');
    	$office ->manual_directions = $request->input('manual_directions');
    	$office ->metro_station_1 = $request->input('metro_station_1');
    	$office ->metro_line_1 = $request->input('metro_line_1');
    	$office ->metro_station_2 = $request->input('metro_station_2');
    	$office ->metro_line_2 = $request->input('metro_line_2');
    	$office ->bus_line = $request->input('bus_line');
    	$office ->bus_line_letter = $request->input('bus_line_letter');
    	$office ->renfe_line = $request->input('renfe_line');
    	$office ->renfe_line_letter = $request->input('renfe_line_letter');
    	$office ->schedule_days = $request->input('schedule_days');
    	$office ->schedule_hours = $request->input('schedule_hours');
    	$office ->email = $request->input('email');
    	$office ->phone_number = $request->input('phone_number');
    	$office ->website = $request->input('website');
    

///Una vez que todo esto este listo ya podemos hacer un UPDARe en la base de datos.
    $office->update();

    //Session::flash('flash_message', 'Folder successfully added!');


return redirect()->route('dashboard::offices.show',['id' => $office->cathegory_id])->with(array('message'=>'La oficina se ha actualizado correctamente'));

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
        $office = Office::findOrFail($id);
        /*User va a llamar a la funcion del modelo USER 'toggleAccess'
         *Este metodo pide una variable TYPE
         *Entonces aqui recojo la variable de 'type' que vienen dentro del request
         que me llega por la URL
         */
        $office->toggleAccess($request->get('type'));

        /*Guardo el objeto en la base de datos*/
        $office->save();

        /*Redirijo a la base de datos con un mensaje que contiene el nombre completo del usuario*/
       return redirect()->back()->with([
            'message' => 'Se actualizo la información de la oficina [' . $office->name . ']',
            'level' => 'success'
        ]);
    }
/*****************************************************************/

}

