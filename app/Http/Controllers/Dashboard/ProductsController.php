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

/* Middleware vendor/laravel/framework/src/iluminate/auth/middleware/Authenticate*/
use Auth;

use DB;

/*Para recibir las notificacion desde la base de datos y desplegarlas en el panel de control*/
use Illuminate\Support\Facades\Notification;

/*Esto es para poder utilizar el ojeto REQUEST*/
use Illuminate\Http\Request;


class ProductsController extends Controller
{
   /*******************INDEX*********************************/
    /*Recojo la request que me llega por URL*/
      public function index(Request $request) {
          /*THIS es un puntero que hace referencia a un OBJETO*/
          /*El AUTHORIZE es un metodo del controller App\Http\Requests\UserRequest
          /* Se autoriza a quien tenga permiso de 'listar-usuarios'*/
          //$this->authorize('listar-usuarios');
          /*Creo un variable PRODUCTS para que me guarde el QUERY el modelo de products*/
          $products = Product::query();

          $files =  DB::table('files')->get();

          return view('dashboard.products.index', [
              'items'   => $products->paginate(config('ui.admin.page_size')),
              'page'    => $request->query('page'),
              'files'   => $files
          ]);
      }
/******************* /INDEX*********************************/

//*******************************************//
    //-------------CREAR UN PRODUCT------------------
    //Simplemente una pagina que nos muetre los docs

    public function create(Request $request){

        //Saco el ROLE del usuario que crea el file
        $roleId = Auth::getUser()->role_id;

        //La variable me guarda la busqueda en la base de datos donde el campo de created_id es igual al ID del ususario actual. Y finalmente cuento las veces.
        $userFilesCount = Product::where('created_by_id', Auth::getUser()->id)->count();

        $folder = $request->id;

        //Esta variable me guarda la query a la tabla de PRODUCTS paar sacar el objeto que tenga este ID..
        $folderName = Folder::find($request->id);


        $created_bies = User::get()->pluck('name', 'id');

        return view('dashboard.products.create', compact('folder','folderName', 'created_bies', 'userFilesCount', 'roleId'));
    }

    //*******************************************//
    //-------------GUARDAR UN PRODUCT------------------
    //Validar formulario
    //Le pasamos como primero parametro los datos que llegan por POST
    public function store (Request $request){
    	//Creamos una variable que se llama ValidateData

        $validateData = $this->validate($request, [
            'title' =>'required | min:5',
        ]);

    	//Ahora vamos a guardar el PRODUCT en la base de datos
    	//Utilizamos la entidad de PRODUCT y creamos un objeto nuevo
    	$product = new Product();
    	//Ahora creo una variable USER para guardar la informacion del usuario identificado
    	$user = \Auth::user();

    	// Ahora al product le asigno un valor a cada una de las propiedades, con las variables que me llegan por POST

    	$product ->created_by_id = $user->id;

        //Me llama el INPUT del formulario create que tiene por nombre 'title'
    	$product ->name = $request->input('title');
    	
        //Me llama el IMPUT del formulario con nombre 'product' esto lo hago para conseguir el ID del product. Esto lo guarde en un input de typo hidden.
        $folderID = $request->input('folder');

        //Ahora creo una variable USER para guardar la informacion del usuario identificado
        $user = \Auth::user();

        // Ahora al objeto file que cree  le asigno un valor a cada una de las propiedades, con las variables que me llegan por POST
        $product ->created_by_id = $user->id;

        $product ->folder_id = $folderID;

        //Ahora para guardar el nuevo objeto en la BD en la base de datos utilizo metodo SAVE()
    	$product ->save();

        //Cuando termino le ahago una redireccion a HOME
        //Ademas añado una alerta que diga que el doc se ha subido correctamente
        return redirect('dashboard/folders/'.$request->input('folder'))->with(array(
            'message'=> 'El trámite se ha subido correctamente'
         ));

    //*********CARPETA STORAGE ******************//
    //Para que esto funcione correctamente necesito configurar los Drivers del Storage. Para ello CONFIG>fileSystems.php y como solo esta el Disk public me tengo que crear otros dos discos. Unos para IMAGES y otro para DOCS, o para todo lo que necesite.
    //*********************************************//
    	
    }

    //*****************DOWNLOAD******************//
    // TEnemos que pasar el $ID que el el detalle del products que deseamos mostrar
    public function show($id){

        $files = File::where('product_id', $id)->get();
        //Creamos una variable folder que haga un FIND a la BD para conseguir el registro que deseamos mostrar. Esto lo podemos hacer con ELOQUENT y el metodo find- Le solicitamos el doc_id. Diferente como se hace con el QUERY builder
        $products = Product::findOrFail($id);

        $userFilesCount = File::where('created_by_id', Auth::getUser()->id)->count();

        //Cargamos una vista que se llma doc y un array con la infomracion del doc a cargar

        return view('dashboard.products.show', compact('products','files','userFilesCount'));
    }


// *******************************************//
    // ---------ELIMINAR DOC --------//
    /* Este metodo recibo por URL el nombre del fichero*/
    public function destroy(Request $request,$id){
        //Lo primero es conseguir una variable del usuario identificado
        $user = \Auth::user();
        //Ahora hacemos un find para conseguir el doc que deseamos borrar
        $product = Product::findOrFail($id);
        
        $product->delete();
    
        //Lo ultimo que hace este metodo es redirigirnos a HOME con el aaray de mensaje para que me diga si se elimino o no correctamente
        return redirect('dashboard/folders')->with(array(
            'message'=>'Tramite eliminado correctamente'
        ));
    }

// *******************************************//
// ---------EDITAR DOC --------//
//Recibo la variable ID del doc por URL
public function edit(Request $request, $product_id){
     //Lo primero es conseguir una variable del usuario identificado
    $user = \Auth::user();
    //Creamos una variable doc para conseguir el objeto del doc que estamos intentando editar. Utilizamos FindOrFail para que nos devuelva un error en caso de que no exista en la base de datos
    $product = Product::findOrFail($product_id);
    //Ahora tenenmos que comprobar si el usuario existe y el que solamente cuando estemos identificados como el ususario dueño del doc podamos usarlo. SI otro lo intenta no va a poder
    if($user && $product->created_by_id == $user->id){
        //Devolvemos la vista edit dentro de la carpeta de docs
        return view('dashboard.products.edit', array(

            'product' => $product

        ));
    //Si esto no funcionara hacemos una redireccion a la HOME sin mensaje
    }else{
        return redirect()->route('products');
    }
    //Ahora es necesario crear la vista de Edit
}
//*******************************************//
// ---------ACTUALIZAR DOC EN BD--------//
//Recibo la variable ID del doc por URL, y tambien le paso la request para poder recibir los parametro que me lleguen por POST
public function update($product_id, Request $request){
     ///Lo primero que vamos a hacer es validar el forrmulario y le pasamos la request para que recoja todos los datos que llegan por POST. Ademas le vamos a pasar un array con las reglas de validacion.
    $validate = $this->validate($request, array(
            'title' =>'required | min:5',
    ));

    //Ahora toca conseguir el objeto del doc, con un FIND
    $product = Product::findOrFail($product_id);
    
    //Tambien vamos a conseguir el usuario identificado
    $user = \Auth::user();

    $product->name = $request->input('title');

    $product->description = $request->input('description');

///Una vez que todo esto este listo ya podemos hacer un UPDARe en la base de datos.
    $product->update();

    //Session::flash('flash_message', 'product successfully added!');

return redirect()->route('dashboard::folders.show',['id' => $product->folder_id])->with(array('message'=>'El trámite se ha actualizado correctamente'));

}


    public function massDestroy(Request $request)
    {
        if (! Gate::allows('product_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Product::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
}

    // Restore Product from storage.

    public function restore($id)
    {
        if (! Gate::allows('product_delete')) {
            return abort(401);
        }
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.index');
    }

 
     // Permanently delete Products from storage.

    public function perma_del($id)
    {
        if (! Gate::allows('product_delete')) {
            return abort(401);
        }
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();

        return redirect()->route('admin.products.index');
    }

/*******************TOGGLE**************************************/
    /* Aqui recivo la REQUEST y el ID del usuario que me viene por la URL*/
    public function toggleAccess(Request $request, $id)
    {   
        /*Almaceno en la variable User el usuario que coincide con el ID 
          que me llega por la URL
         *Del lado del formulario lo que pedi fue el ($item->id)
         */
        $product = Product::findOrFail($id);
        /*User va a llamar a la funcion del modelo USER 'toggleAccess'
         *Este metodo pide una variable TYPE
         *Entonces aqui recojo la variable de 'type' que vienen dentro del request
         que me llega por la URL
         */
        $product->toggleAccess($request->get('type'));

        /*Guardo el objeto en la base de datos*/
        $product->save();

        /*Redirijo a la base de datos con un mensaje que contiene el nombre completo del usuario*/
       return redirect()->back()->with([
            'message' => 'Se el acceso al  producto:  [' . $product->name . ']',
            'level' => 'success'
        ]);
    }
/*****************************************************************/

}
