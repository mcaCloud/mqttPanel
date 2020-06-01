<?php

//\URL::forceScheme('https');

use \App\Events\FormSubmitted;

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
/******************** Notifications ***********************************/
/*************/
/************/
/*/*********** ALL-READ ************/
/*Esta es una funcion de testing para ver como se puede retrive la info de la notificacion y imprimirla en pantalla*/
/* Me imprime directamente lo que viene dentro del objeto*/

Route::get('/allRead','NotificationsController@allRead') ->name('markAllAsRead');

/*/*********** ALL-UNREAD ************/
/*Esta es una funcion de testing para ver como se puede retrive la info de la notificacion y imprimirla en pantalla*/
/* Me imprime directamente lo que viene dentro del objeto*/

Route::get('/allUnRead','NotificationsController@allUnRead')->name('markAllAsUnRead');



/*/*********** Notification-Page ************/

/*Esta vista no da la pantalla completa de las notificaciones*/
Route::get('/notificaciones','NotificationsController@index') ->name('notifications');

/*Esta vista nos da el detalle de la notificaion*/
Route::get('/notificacion/{id}','NotificationsController@show') ->name('notificationDetail');


/************* ONE-Destroy******************/
/*Esta vista nos da el detalle de la notificaion*/
Route::delete('/deleteNotification/{id}','NotificationsController@destroy') ->name('notificationDelete');

/************* ONE-READ******************/
Route::get('/readNotification/{id}','NotificationsController@oneRead') ->name('oneRead');
Route::get('/unReadNotification/{id}','NotificationsController@oneUnRead') ->name('oneUnRead');

Route::get('/emptyNotification','NotificationsController@empty') ->name('emptyNotifications');


/************* ONE-READ******************/

/******************** Notifications ***********************************/
/*************/
/************/
/******************** PUSHER ***********************************/
/*Prueba la funcionalidad con la debug console en PUSHER site*/
Route::get('/pusherCluster',function(){
    return view('pusherCluster');
});
/*Prueba la funcoinalidad dentro de laravel ya ingresada el API keys*/
/*Esto me lleva a una pagina donde puedo enviar mensajes*/
Route::get('/pusherSenderTest',function(){
    return view('pusherSenderTest');
});
/*Esto recibe el post de la pagina de prueba*/
Route::post('/pusherSenderTest',function(){
    
    /*La variable ejemplo me va a cojer lo que venga en el request y guardarlo*/
    $ejemplo = request()->ejemplo;
    /*Indico que lo que me llegue de este formulario debe de ser enviado como un event*/
    /*Para que esto funcione arriba tengo que incluir use\App\Events\FormSubmitted*/
    /*Dentro del event podemos incluir cualquier variable que desemos
     *Este PAYLOAD es la misma que vamos a utilizar en el contructor del evento*/
    event(new FormSubmitted($ejemplo));
});


/******************** PUSHER ***********************************/
/*************/
/************/