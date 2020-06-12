<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Response;

//Importo el trait de autenticacion del usuario
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use Log;

class LoginController extends Controller
{
    /* Aqui estamos utilizando un TRAIT ubicado en 
        vendor/laravel/framework/src/iluminate/foundation/auth/
        Importamos la clase arriba y ahora solo lo mencionamos en los modelos 
        Heredo automaticamente todas las clases y metodos de ese 
        TRAIT y las puedo usar aqui diretamente*/
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /*La ruta raiz esta protegida, solo usuario autorizado puede acceder*/
     protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'getLogout']]);
    }

    /**
     * @inheritdoc
     */
    protected function credentials(Request $request)
    {

        // User must be active to login
        return array_merge(
            ['access_web' => true],
            $request->only($this->username(), 'password')
        );

    }

    /**
     * @inheritdoc
     */
/* ********************AUTHENTICATED**************************/ 
    protected function authenticated(Request $request, $user)
    {
        // Registering last user login date and time
        $user->last_login = Carbon::now();
        $user->save();
    }
/* ******************** /AUTHENTICATED**************************/ 
    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
/* ********************LOGOUT**************************/ 
    public function logout(Request $request)
    {
        /*El usuario se deslogea por medio de una guardia*/
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/');
    }
/* ******************** /LOGOUT**************************/ 
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */

/* ********************LOGIN**************************/

    /* La request es para recibir por URL los datos del FORM*/ 
    public function login(Request $request)
    {
        /*Aqui llamo al TRAIT que importe de AuthenticateUsers*/
        /*Ahi estan las reglas de validacion para el formulario*/
        /*La funcion se llama (validateLogin)*/
        $this->validateLogin($request);
        /* Aqui llamo al TRAIT AuthenticationUser como puente para poder ingresar al TRAIT de Throttles y el metodo de hasTooManyLoginAttemts*/

        /*Si se cumple la funccion del trait ThrottlesLogin 
          (hasTooManyLoginAttempts)*/
        /*Esta funcion utiliza dos funciones dentro del mismo TRAIT*/
        /* Una para delimitar cuantas intentos hay (maxAttempts)*/
        /*Y otra utiliza el USERname y la IP desde la cual se ingresa como KEY para comparar (throttleKey)*/
        /*Ambas funciones estan dentro del ThrottlesLogins TRAIT*/

        if ($this->hasTooManyLoginAttempts($request)) {
            /*Si el usuario se pasó de intentos desde la mima IP*/
            /*Se procede a aplicar el metodo (fireLockOutEvent)*/
            /*Se crea un evento y un TILD al usuario*/
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        /*Ahora se el usuario ingresa credenciales incorrectas*/
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

/* ******************** /LOGIN**************************/ 


    protected function sendFailedLoginResponse(Request $request)
    {

        // Load user from database
        $user = User::where($this->username(), $request->{$this->username()})->first();

        if($user){

            if(!$user->access_web){
              return redirect()->back()->with([
                  'message' => 'La cuenta no tiene acceso a la web',
                  'level' => 'warning'
              ]);
            }

            if (\Hash::check($request->password, $user->password)) {
              return redirect()->back()->with([
                  'message' => 'Las credenciales son invalidas',
                  'level' => 'warning'
              ]);
            }

        }else{

          return redirect()->back()->with([
              'message' => 'Las credenciales son invalidas',
              'level' => 'warning'
          ]);
          
        }

    }

}
