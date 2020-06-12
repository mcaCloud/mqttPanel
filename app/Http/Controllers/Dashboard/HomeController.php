<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


/*Importo el MODELO de User*/
use App\User;
/* Middleware vendor/laravel/framework/src/iluminate/auth/middleware/Authenticate*/
use Auth;

class HomeController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
    }



    public function index(){

    $user = User::findOrFail(1);
             /*Muestreme esta vista*/
        return view('dashboard.index');
    
    }
}
