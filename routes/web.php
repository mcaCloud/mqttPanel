<?php

//\URL::forceScheme('https');

/***************LOGIN-LOGOUT******************************/

/*Esta ruta entra dentro del LoginController y no utiliza un metodo de ahi, sino que de una vez ahi llama un TRAIT (showLoginForm) porque dentro del controlador llame al TRAIT AuthenticatesUser*/
/*Entonces se puede mencionar el controlador y directamente un trait*/
/*El name se lo pongo en caso de que ocupe el codigo. Lo llamaria con un route('login.form')*/
/* Desde el TRAIT AuthenticateUsers llamo return view (auth.login)*/
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login.form');

Route::post('/login', 'Auth\LoginController@login')->name('login');

Route::get('auth/logout', 'Auth\LoginController@logout')->name('logout');
/*************** /LOGIN-LOGOUT /******************************/
/*
/*
/*
*/
/*************** INDEX/******************************/
Route::get('/', 'Dashboard\HomeController@index')->name('index');

/*
/*
/*
*/
/*************** RESET-PASSWORD ******************************/
/**/

/******   1  *****/
/*Esta es la ruta cuando el USER hace click en el 'Forgot Password', me lleva a la vista 'email' para que e ususario intoduzca el email*/
/*Dentro el controlador 'ForgotPasswordController' solo hay una referencia hacia el TRAIT de 'SendsPasswordresetEmails'*/
/*Dentro de ese TRAIT utilizo el metodo de 'showLinkRequestForm'*/
Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

/******   2   *****/
/*Una vez dentro de la vista 'email' se envia el POST del formulario de reset password*/
/*Dentro el controlador 'ForgotPasswordController' solo hay una referencia hacia el TRAIT de 'SendsPasswordresetEmails'*/
/*Dentro de ese TRAIT utilizo el metodo de 'sendResetLinkEmail'*/
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

/******   3   *****/
/*Cunado el user hace click en el link que recibe, lo envia a la vista para cambiar el password*/
/* Dentro del controlador de 'ResetPasswordController' solo hace referencia a el TRAIT de 'ResetPasswords' ubicado en'Illuminate/Foundation/Auth/ResetPasswords'*/
/*Dentro de ese TRAIT llamo al metodo 'showResetForm'*/
Route::get('/password/reset/{token} ', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

/******   4   *****/
/*Finalmente se envia el request con un POST para cambiar el password*/
/* Dentro del controlador de 'ResetPasswordController' solo hace referencia a el TRAIT de 'ResetPasswords' ubicado en'Illuminate/Foundation/Auth/ResetPasswords'*/
/*Dentro de ese TRAIT llamo al metodo 'reset'*/
Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
/**********/

/*************** RESET-PASSWORD ******************************/
/*
/*
/*
*/
/*Esto lo que hace es que pueda solicitar cuaquier ruta del dashboard con el prefijo*/
/*dashboard va a ir enfrente de todas las rutas*/
/*Utilizo name space porque todas las rutas de los controlladores estan dentro del folder dashboard*/
Route::group(['prefix' => 'dashboard', 'namespace' => 'Dashboard', 'as' => 'dashboard::'], function () {

 /*Todas estas rutas estan agrupadas con el middleware 'auth' que es un metodo dentro del controllador 'router.php' ubicado en'Illuminate/Routing*/
 /*aqui se pueden ver las diferentes rutas que el el metodo cubre*/
  Route::group(['middleware' => ['auth']], function () {

        Route::get('/', 'HomeController@index')->name('index');

        /*Maneja todos los metodos tipicos con una solo linea de codigo*/
        /*Al ser Resourceful ya tiene metodos preestablacidos para las operaciones mas basicas de crud*/
        /*El except significa que el controller maneja las defualt actions except for SHOW*/
        Route::resource('/users', 'UserController', ['except' => ['show']]);

        Route::get('/users/{user}/access', 'UserController@toggleAccess')->name('users.toggleAccess');

        Route::get('/users/export', 'UserController@export')->name('users.export');

        Route::resource('/roles', 'RoleController', ['except' => ['show']]);


        Route::resource('/permissions', 'PermissionController', ['except' => ['show']]);

        Route::get('/common/slug/{name}', 'CommonController@slug')->name('common.slug');

        Route::get('/pdfs', 'PdfController@index')->name('pdfs.index');

        Route::post('/pdfs/generate', 'PdfController@export_document_generate')->name('pdfs.export_document_generate');

        Route::post('/pdfs/url', 'PdfController@export_document_url')->name('pdfs.export_document_url');

        Route::get('/pdfs/view', 'PdfController@export_by_view')->name('pdfs.export_by_view');


  });



});

/******************** /PREFIX-NAMESPACE ***********************************/
/*************/
/************/
/******************** PERFIL-DE-USUARIO ***********************************/
/*Se recomienda poner las llamadas a los metodos antes de poner el RESOURCEFULL*/
Route::get('/editar/{id}','UserProfile@edit') ->name('perfil');

Route::post('/actualizar/{id}','UserProfile@update') ->name('updateUser');

/*------------GET-IMAGE------------------*/
/*Esta es la ruta que utilizo para obtener la informacion de los avatares*/
/*Tengo que realizar rutas parecidas para los otros controladores*/ 
Route::get('/miniatura/{filename}','UserProfile@getImage') ->name('miniatura');

 /*Maneja todos los metodos tipicos con una solo linea de codigo*/
 /*Al ser REsourceful ya tiene metodos preestablacidos para las operaciones mas basicas de crud*/
 /*El except significa que el controller maneja las default actions except for...*/
    Route::resource('/Perfil', 'UserProfile')->except([
    'create', 'store', 'show'
]);
/******************** PERFIL-DE-USUARIO ***********************************/
/*************/
/************/

/*************/
/************/
/*Esta es una funcion de testing para ver como se puede retrive la info de la notificacion y imprimirla en pantalla*/
/* Me imprime directamente lo que viene dentro del objeto*/
Route::get('/d', function(){

    /* Esto es importante ver como  funciona para poder imprimir toda la info*/
    /*Necesito imprimir algo aprecido dende un vista*/
    /* IMprime las notificaciones de usuario authenticado*/
    foreach (Auth::user()->notifications as $notification) {
        /*Esto es para que cuando se envie la notificacion se marque con leida dentro de la base de datos*/
        //$notification-> markAsRead();
        dd($notification);
    }

    /* Esto es importante ver como  funciona para poder imprimir toda la info*/
    /*Necesito imprimir algo aprecido dende un vista*/
    /* IMprime las notificaciones NO LEIDAS de usuario authenticado*/
    foreach (Auth::user()->unreadNotifications as $notification) {
        /*Esto es para que cuando se envie la notificacion se marque con leida dentro de la base de datos*/
        $notification-> markAsRead();
        dd($notification);
    }

});
/*Esta es una funcion de testing para ver como se puede retrive la info de la notificacion y imprimirla en pantalla*/
/* Me imprime directamente lo que viene dentro del objeto*/
Route::get('/notificaciones', function(){

 return view ('notifications.notificationTemplate');
});