<?php
namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Todas las request que nos llegan por HTT
use App\Http\Requests;

use Illuminate\Support\Facades\Validator;
//Todo el tema de la bases de datos
use Illuminate\Support\Facades\DB;
//Para poder almacenar en el Storage
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

//Ahora importo los modelos
use App\Folder;
use App\User;
use App\File;
use App\Product;
use Auth;
class FileController extends Controller
{

    //-------------CREAR UN DOC------------------
    //Simplemente una pagina que nos muetre los docs

    public function create(Request $request){

    	//Saco el ROLE del usuario que crea el file
    	$roleId = Auth::getUser()->role_id;

    	//La variable me guarda la busqueda en la base de datos donde el campo de created_id es igual al ID del ususario actual. Y finalmente cuento las veces.
        $userFilesCount = File::where('created_by_id', Auth::getUser()->id)->count();
        //Si el user es 'usuario' y ya ha subido mas de 5 archivos, que se redirija

        /*if ( (!Auth::user()->hasRole('usuario')) && $userFilesCount > 5) {
            return redirect('folders')->with(array(
    		'message'=> 'El máximo de documentos permitidos es de 5 por carpeta'
    	 ));
        }*/

        $product = $request->id;

        //Esta variable me guarda la query a la tabla de FOLDER paar sacar el objeto que tenga este ID..
        $productName = Product::find($request->id);

        $created_bies = User::get()->pluck('name', 'id');

        return view('dashboard.files.create', compact('product','productName', 'created_bies', 'userFilesCount', 'roleId'));

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

        $validator = Validator::make($request->all(), [
            'resume'   => 'mimes:doc,pdf,docx,zip'
        ]);

    	//Ahora vamos a guardar el FILE en la base de datos
    	//Utilizamos la entidad de FILE y creamos un objeto nuevo
    	$file = new File();

        //Me llama el INPUT del formulario create que tiene por nombre 'title'
        $fileName = $request->input('title');

        //Me llama el IMPUT del formulario con nombre 'folder' esto lo hago para conseguir el ID del folder. Esto lo guarde en un input de typo hidden.
        $productID = $request->input('product');

    	//Ahora creo una variable USER para guardar la informacion del usuario identificado
    	$user = \Auth::user();

    	// Ahora al objeto file que cree  le asigno un valor a cada una de las propiedades, con las variables que me llegan por POST

    	$file ->created_by_id = $user->id;

    	$file ->filename = $fileName;

    	$file ->product_id = $productID;

    	// -----  UPLOAD DOC ----//
        //Aqui solicitamos el dato de tipo FILE dentro de la request que se llame 'doc'
        //Es el input del boton de crear
    	$file_upload = $request->file('doc');

    	if($file_upload){
            //Todas con forma de obtener el path del archivo
            //Las puse todas para probar como se refleja en la base de datos
    		$file_path = time().$file_upload ->getClientOriginalName();
            $file_path1 = time().$file_upload ->getClientOriginalExtension();
            $file_path2 = time().$file_upload ->getClientMimeType();
            $file_path3 = time().$file_upload ->getClientSize();

    		Storage::disk('docs')->put($file_path,\File::get($file_upload));

    		$file->file_path = $file_path;

    	}



        //Ahora para guardar el nuevo objeto en la BD en la base de datos utilizo metodo SAVE()
    	$file->save();



    	//Cuando termino le ahago una redireccion a HOME
    	//Ademas añado una alerta que diga que el doc se ha subido correctamente
    	return redirect('dashboard/folders/'.$request->input('folder'))->with(array(
    		'message'=> 'El documento se ha subido correctamente'
    	 ));

    //*********CARPETA STORAGE ******************//
    //Para que esto funcione correctamente necesito configurar los Drivers del Storage. Para ello CONFIG>fileSystems.php y como solo esta el Disk public me tengo que crear otro  disco. 
    //*********************************************//

    }

    // ----PAGINA DETALLE DEL DOC------//
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

// *******************************************//
    // ---------DOWNLOAD --------//
    /* Este metodo recibo por URL el nombre del fichero*/
    public function show($id){

         $files = File::where('product_id', $id)->get();

        $file = File::find('id',$id)->first();

        return Storage::disk('docs')->download($file->file_path,$file->filename);
    }


// *******************************************//
    // ---------ELIMINAR DOC --------//
    /* Este metodo recibo por URL el nombre del fichero
        En este caso el ID del FIle que estamos recorriendo con el FOREACH*/
    public function destroy($id){
        //Lo primero es conseguir una variable del usuario identificado
        $user = \Auth::user();
        //Ahora hacemos un find para conseguir el archivo que deseamos borrar
        //Utilizamos como parametro el parametro ID que recibimos en el metodo 
        $doc = File::find($id);

            //Despues tenemos que eliminar los archivos a nivel de disco fisico. Eliminarlos del Storage. Utilizamos el OBJETO  doc y la PROPIEDAD file_path.
            Storage::disk('docs')->delete($doc->file_path);
            //Finamente eliminar el registro del doc en la base de datos
            $doc->delete();
        
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

/*******************TOGGLE**************************************/
    /* Aqui recivo la REQUEST y el ID del usuario que me viene por la URL*/
    public function toggleAccess(Request $request, $id)
    {   
        /*Almaceno en la variable User el usuario que coincide con el ID 
          que me llega por la URL
         *Del lado del formulario lo que pedi fue el ($item->id)
         */
        $file = File::findOrFail($id);
        /*User va a llamar a la funcion del modelo USER 'toggleAccess'
         *Este metodo pide una variable TYPE
         *Entonces aqui recojo la variable de 'type' que vienen dentro del request
         que me llega por la URL
         */
        $file->toggleAccess($request->get('type'));

        /*Guardo el objeto en la base de datos*/
        $file->save();

        /*Redirijo a la base de datos con un mensaje que contiene el nombre completo del usuario*/
       return redirect()->back()->with([
            'message' => 'Se modificó el acceso al archivo:  [' . $file->name . ']',
            'level' => 'success'
        ]);
    }
/*****************************************************************/
}
