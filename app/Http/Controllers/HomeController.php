<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//Como esta informacion va a representarse en la pagina de Index, y existen diferentes tabs que van a interactuar con tablas diferentes. Debo mencionar a todos los modelos con los que voy a interactuar. Sino cuando intente hacer un retrive de la informacion no me va a encontrar la variable.
use App\File;
use App\Video;
use App\Doc;
//Para mostrar las alertas tengo que tener el modelo importado.
use App\Alert;
//Este modelo lo utilizo para poder llamar la lista de usuarios en el landing page.
use App\User;

use App\EmployeeInfo;


class HomeController extends Controller
{
       public function __construct()
    {
        //Le quitamos el 'auth' y le agregamos el 'web' para que no se necesite autenticacion para ver los videos pero si para modificarlos
        $this->middleware('web');
    }


//*******************************************//
    public function index()
    {

        //-------------PAGINATE----------------//
        /*Hay varias formas de hacerlo. Lo puedo hacer con el QUERY builder utilizando el metodo DB. EN este caso NO tengo que importar el modelo de USER

        $videos = DB::table('videos')->paginate(5);
        return view('home');
        */
        /*$docs = DB::table('docs')->paginate(5);
        return view('welcome');*/
        /*Tambien lo puedo hacer utilizando el modelo, de esta forma debo de importar el modelo FILE en el controlador. Tambien utilizo el ORDER BY para ordenar los videos de mas nuevo a mas antiguo*/
        $files = File::orderBy('id','desc')-> paginate(5);
        /*Ahora le tengo que pasar la informacion a la vista, para eso le paso un array al VIEW*/

        //Como en la vista de Index tengo tabs y cada una tiene informacion diferente los que voy a hacer es hacer un query en cada tabla y pasarle la info de todas las tablas que ocupo a la vista. 
        $videos = Video::orderBy('id','desc')-> paginate(5);

        $docs = Doc::orderBy('id','desc')-> paginate(5);
        
        $users = User::orderBy('id','desc')-> paginate(5);

        $alerts = Alert::orderBy('id','desc')-> paginate(5);
        
        $employees = EmployeeInfo::orderBy('id','desc')-> paginate(5);
        //Ahora lo que tengo que hacer es pasarle a la vista toda la informacion de estos objetos de la base de datos.
        //Le paso los tre por si tengo que intercalar en 
        return view ('welcome',array(
            /*Creo un indice FILES y le paso todos los files, de esta forma ya tengo accesible todos los files en la vista welcome*/
            'files' =>$files,
            'videos' =>$videos,
            'docs' =>$docs,
            'users' =>$users,
            'employees' =>$employees,
            'alerts' => $alerts
        ));


    }
}
