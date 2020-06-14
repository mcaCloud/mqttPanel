<?php

//\URL::forceScheme('https');

/*Ponemos el evento aqiu para poder usarlo desde este controlador, pero hay que ponerlo en el controlador desde el cual se va a utilizar*/

Route::get('/', 'HomeController@index')->name('index');

/****************************************************************************************/
/***************************/                            /*****************************/  
/******************************     *//*LOGIN-LOGOUT*//*   *******************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/

/*Esta ruta entra dentro del LoginController y no utiliza un metodo de ahi, sino que de una vez ahi llama un TRAIT (showLoginForm) porque dentro del controlador llame al TRAIT AuthenticatesUser*/
/*Entonces se puede mencionar el controlador y directamente un trait*/
/*El name se lo pongo en caso de que ocupe el codigo. Lo llamaria con un route('login.form')*/
/* Desde el TRAIT AuthenticateUsers llamo return view (auth.login)*/
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login.form');

Route::post('/login', 'Auth\LoginController@login')->name('login');

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');




/****************************************************************************************/
/*****************************/                            /*****************************/  
/******************************     *//*RESET-PSS*//*      *******************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/
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


/****************************************************************************************/
/*****************************/                            /*****************************/  
/******************************     *//*DASHBOARD*//*      *******************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/


/****************************************************************/
/*************** PREFIX-DASHBOARD ******************************/

/*Esto lo que hace es que pueda solicitar cuaquier ruta del dashboard con el prefijo*/
/*dashboard va a ir enfrente de todas las rutas*/
/*Utilizo name space porque todas las rutas de los controlladores estan dentro del folder dashboard*/
Route::group(['prefix' => 'dashboard', 'namespace' => 'Dashboard', 'as' => 'dashboard::'], function () {

 /*Todas estas rutas estan agrupadas con el middleware 'auth' que es un metodo dentro del controllador 'router.php' ubicado en'Illuminate/Routing*/
 /*aqui se pueden ver las diferentes rutas que el el metodo cubre*/

/****************************************************************/
/******************  MIDDLEWARE ***********************************/
  Route::group(['middleware' => ['auth']], function () {

        //Al final la ruta seria 'dashboard/'porque estamos dentro del namespace de 'Dashboard' entonces cualquier ruta aqui adentro comienza con dashboard como prefijo
        Route::get('/', 'HomeController@index')->name('index');
        /*Maneja todos los metodos tipicos con una solo linea de codigo*/
        /*Al ser Resourceful ya tiene metodos preestablacidos para las operaciones mas basicas de crud*/
        /*El except significa que el controller maneja las defualt actions except for SHOW*/

        /******************************************/
         /*------------*ARCHIVOS*-------------------*/
        /******************************************/
        Route::resource('/users', 'UserController', ['except' => ['show']]);

                Route::get('/users/{user}/access', 'UserController@toggleAccess')->name('users.toggleAccess');

                 Route::get('/users/export', 'UserController@export')->name('users.export');


         /******************************************/
         /*------------*ROLES*-------------------*/
        /******************************************/
        Route::resource('/roles', 'RoleController', ['except' => ['show']]);


         /******************************************/
         /*------------*PERMISSIONS*-------------------*/
        /******************************************/
        Route::resource('/permissions', 'PermissionController', ['except' => ['show']]);


         /******************************************/
         /*------------*COMMONS*-------------------*/
        /******************************************/
        Route::get('/common/slug/{name}', 'CommonController@slug')->name('common.slug');


         /******************************************/
         /*------------*PDF*-------------------*/
        /******************************************/
        Route::get('/pdfs', 'PdfController@index')->name('pdfs.index');

        Route::post('/pdfs/generate', 'PdfController@export_document_generate')->name('pdfs.export_document_generate');

        Route::post('/pdfs/url', 'PdfController@export_document_url')->name('pdfs.export_document_url');

        Route::get('/pdfs/view', 'PdfController@export_by_view')->name('pdfs.export_by_view');


        /******************************************/
         /*------------*FOLDERS*-------------------*/
        /******************************************/

         //Aqui ya tenemos 2 prefijos . El del namespace 'dashboard' y el resource 'folders'
        //Cualquier ruta de aqui llevara los dos
         Route::resource('/folders', 'FoldersController');
                //Esta ruta por ejemplo seria:  /dashboard/folders/crear
                Route::get('/crear','FoldersController@create')->name('folder-create');
                //dashboard/folder/store
                Route::get('/store','FoldersController@store')->name('folder-store');

                //Route::post('/folders/borrar',  'UserController@destroy')->name('folders.delete');
                Route::get('show/{id}/','FoldersController@show')->name('folder-edit');
          
                //Route::post('folders_restore/{id}','UserController@restore')->name('folders.restore');

                //Route::delete('folders_perma_del/{id}', 'UserController@restore') ->name('folders.perma_del');

        /******************************************/
         /*------------*ARCHIVOS*-------------------*/
        /******************************************/
        //Aqui ya tenemos 2 prefijos . El del namespace 'dashboard' y el resource 'archivos'
        //Cualquier ruta de aqui llevara los dos
         Route::resource('/archivos', 'FileController');

            //Route::get('/folders','FoldersController@index')->name('folder-index');
            // dashboard/archivos/crear
            Route::get('/crear','FileController@create')->name('file-create');
            Route::get('/store','FileController@store')->name('file-store');
            Route::get('/download/{id}','FileController@show')->name('file-download');

        /******************************************/
         /*------------*VIDEOS*-------------------*/
        /******************************************/

            Route::get('/videos','VideoController@index')->name('videosIndex');

             Route::get('/videos/{user}/access', 'VideoController@toggleAccess')->name('videos.toggleAccess');


            /*Creamos la ruta hacia la pagina y utilizamos un array para pasarle los parametros que estaremos utilizando*/
            Route::get ('/crear-video', array(
                //Este va a ser el nombre de la ruta
                'as' => 'createVideo', 
                //Uso el AUTH para que solo pueda crear videos si estoy identificados
               // 'middleware'=> 'auth',
                //Ahora le indico que clase y que controlador(accion) va a utilizar
                'uses' => 'VideoController@createVideo'
            ));

            /*------------GUARDAR------------------*/
            /*Creamos la ruta para guardar el video una vez creado*/

            Route::post ('/guardar-video', array(
                //Este va a ser el nombre de la ruta
                'as' => 'saveVideo', 
                //Uso el AUTH para que solo pueda crear videos si estoy identificados
                'middleware'=> 'auth',
                //Ahora le indico que clase y que controlador(accion) va a utilizar
                'uses' => 'VideoController@saveVideo'
            ));

            /*------------ADD-COMMENT------------------*/
            //Indicamos el nombre de la ruta y metodo que va a cargar
            Route::post('/comment',array(
                'as'=> 'comment',
                //'middleware'=>'auth',
                'uses'=> 'CommentController@store'
            ));

            /*------------DELETE-COMMENT------------------*/
            //Indicamos el nombre de la ruta y metodo que va a cargar
            //---OJO---Si no le pasamos el segundo parametro me da error NotFoundHttpException
            //Esto porque es el parametro que le estamos pasando por el metodo del controlador. MUST BE HERE ALSO
            Route::get('/delete-comment/{comment_id}',array(
                'as'=> 'commentDelete',
               // 'middleware'=>'auth',
                'uses'=> 'CommentController@delete'
            ));

            /*------------DELETE-VIDEO------------------*/
            //Indicamos el nombre de la ruta y metodo que va a cargar
            //---OJO---Si no le pasamos el segundo parametro me da error NotFoundHttpException
            //Esto porque es el parametro que le estamos pasando por el metodo del controlador. MUST BE HERE ALSO
            Route::get('/delete-video/{video_id}',array(
                'as'=> 'videoDelete',
                //'middleware'=>'auth',
                'uses'=> 'VideoController@delete'
            ));

            /*------------EDITAR VIDEO------------------*/
            /*Creamos la ruta para editar el video y le pasamos el parametro de video_id*/
            Route::get('/editar-video/{video_id}', array(
                //Este va a ser el nombre de la ruta
                'as' => 'editVideo', 
                //Uso el AUTH para que solo pueda crear videos si estoy identificados
                //'middleware'=> 'auth',
                //Ahora le indico que clase y que controlador(accion) va a utilizar
                'uses' => 'VideoController@edit'
            ));
            /*------------GUARDAR-UPDATE------------------*/
            /*Creamos la ruta para guardar el video una vez creado*/
            Route::post ('/update-video/{video_id}', array(
                //Este va a ser el nombre de la ruta
                'as' => 'updateVideo', 
                //Uso el AUTH para que solo pueda crear videos si estoy identificados
                //'middleware'=> 'auth',
                //Ahora le indico que clase y que controlador(accion) va a utilizar
                'uses' => 'VideoController@update'
            ));
            /*------------SEARCH------------------*/
            //El parametro search es un parametro opcional, me puede venir o no
            //Para que el FILTRO funcione le tengo que pasar a la ruta otro parametro FILTER. Tambien va a ser opcional (?)
            Route::get('/buscar/{search?}/{filter?}',array(
                'as'=>'videoSearch',
                'uses'=> 'VideoController@search'
            ));
        /******************************************/
         /*------------*VIDEOS*-------------------*/
        /******************************************/

        /******************************************/
         /*------------*Docs*-------------------*/
        /******************************************/

        Route::resource('/noticias', 'DocController');

            Route::get('/noticias/{user}/access', 'DocController@toggleAccess')->name('noticias.toggleAccess');

            Route::get('/index', 'DocController@index')->name('noticiasIndex');
            /*Creamos la ruta hacia la pagina y utilizamos un array para pasarle los parametros que estaremos utilizando*/
            Route::get ('/crear-doc', array(
                //Este va a ser el nombre de la ruta
                'as' => 'createDoc', 
                //Uso el AUTH para que solo pueda crear docs si estoy identificados
               // 'middleware'=> 'auth',
                //Ahora le indico que clase y que controlador(accion) va a utilizar
                'uses' => 'DocController@createDoc'
            ));

            /*------------GUARDAR------------------*/
            /*Creamos la ruta para guardar el doc una vez creado*/
            Route::post ('/guardar-doc', array(
                //Este va a ser el nombre de la ruta
                'as' => 'saveDoc', 
                //Uso el AUTH para que solo pueda crear docs si estoy identificados
                //'middleware'=> 'auth',
                //Ahora le indico que clase y que controlador(accion) va a utilizar
                'uses' => 'DocController@saveDoc'
            ));


            /*------------ADD-COMMENT------------------*/
            //Indicamos el nombre de la ruta y metodo que va a cargar
            Route::post('/comment-doc',array(
                'as'=> 'commentDoc',
                //'middleware'=>'auth',
                'uses'=> 'CommentControllerDoc@store'
            ));

            /*------------DELETE-COMMENT------------------*/
            //Indicamos el nombre de la ruta y metodo que va a cargar
            //---OJO---Si no le pasamos el segundo parametro me da error NotFoundHttpException
            //Esto porque es el parametro que le estamos pasando por el metodo del controlador. MUST BE HERE ALSO
            Route::get('/delete-comment-doc/{comment_id}',array(
                'as'=> 'commentDelete',
                //'middleware'=>'auth',
                'uses'=> 'CommentControllerDoc@delete'
            ));

            /*------------DELETE-DOC------------------*/
            //Indicamos el nombre de la ruta y metodo que va a cargar
            //---OJO---Si no le pasamos el segundo parametro me da error NotFoundHttpException
            //Esto porque es el parametro que le estamos pasando por el metodo del controlador. MUST BE HERE ALSO
            Route::get('/delete-doc/{doc_id}',array(
                'as'=> 'docDelete',
              //  'middleware'=>'auth',
                'uses'=> 'DocController@delete'
            ));

            /*------------EDITAR DOC------------------*/
            /*Creamos la ruta para editar el doc y le pasamos el parametro de doc_id*/
            Route::get('/editar-doc/{doc_id}', array(
                //Este va a ser el nombre de la ruta
                'as' => 'editDoc', 
                //Uso el AUTH para que solo pueda crear docs si estoy identificados
               // 'middleware'=> 'auth',
                //Ahora le indico que clase y que controlador(accion) va a utilizar
                'uses' => 'DocController@edit'
            ));
            /*------------GUARDAR-UPDATE------------------*/
            /*Creamos la ruta para guardar el doc una vez creado*/
            Route::post ('/update-doc/{doc_id}', array(
                //Este va a ser el nombre de la ruta
                'as' => 'updateDoc', 
                //Uso el AUTH para que solo pueda crear docs si estoy identificados
               // 'middleware'=> 'auth',
                //Ahora le indico que clase y que controlador(accion) va a utilizar
                'uses' => 'DocController@update'
            ));
            /*------------SEARCH------------------*/
            //El parametro search es un parametro opcional, me puede venir o no
            //Para que el FILTRO funcione le tengo que pasar a la ruta otro parametro FILTER. Tambien va a ser opcional (?)
            Route::get('/buscar-doc/{search?}/{filter?}',array(
                'as'=>'docSearch',
                'uses'=> 'DocController@search'
            ));
        /******************************************/
         /*------------*Docs*-------------------*/
        /******************************************/


  });
/****************************************************************/
/******************  /MIDDLEWARE ***********************************/
});
/****************************************************************/
/******************  /DASHBOARD ***********************************/



/****************************************************************************************/
/*****************************/                            /*****************************/  
/******************************     *//*USER-PROFILE*//*   *******************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/

/*Se recomienda poner las llamadas a los metodos antes de poner el RESOURCEFULL*/
Route::get('/editar/{id}','UserProfile@edit') ->name('perfil');

Route::post('/actualizar/{id}','UserProfile@update') ->name('updateUser');

/******************************************/
/*------------*GET-IMAGE*-------------------*/
/******************************************/
/*Esta es la ruta que utilizo para obtener la informacion de los avatares*/
/*Tengo que realizar rutas parecidas para los otros controladores*/ 
Route::get('/miniatura/{filename}','UserProfile@getImage') ->name('miniatura');
Route::get('/miniaturaVideo/{filename}','UserProfile@getVideoImage') ->name('miniaturaFile');
Route::get('/miniaturaDoc/{filename}','UserProfile@getDocImage') ->name('miniaturaDoc');

 /******************************************/
/*------------*GET-IMAGE*-------------------*/
/******************************************/
 /*Maneja todos los metodos tipicos con una solo linea de codigo*/
 /*Al ser REsourceful ya tiene metodos preestablacidos para las operaciones mas basicas de crud*/
 /*El except significa que el controller maneja las default actions except for...*/
Route::resource('/Perfil', 'UserProfile')->except([
    'create', 'store', 'show'
]);

 /******************************************/
/*------------*CANAL-DE USUARIO*-----------*/
/******************************************/
//El user_id es obligatorio
Route::get('/canal/{user_id}',array(
    'as'=> 'channel',
    'uses'=> 'UserProfile@channel'
));

 /******************************************/
/*------------*VIDEO*--------------*/
/******************************************/

/*------------VIDEO-DETAIL------------------*/
/* Le pasamos por URL el parametro obligatorio del video y un array con las caracteristicas del video*/
/*Lo hacemos aqui porque es una ruta que no necesita autenticacion.Esto es para que un usuario no atenticado pueda ver el video*/
Route::get('/video/{video_id}',array(
            'as'=> 'detailVideo',
            'uses'=> 'UserProfile@getVideoDetail'
));

/*------------GET-VIDEO------------------*/
//A la ruta le tengo que pasar el parametro que llega obligatoriamente. 
Route::get('/video-file/{filename}', array(
            //Como segundo parametro le paso un array con el nombre que va a tenr la ruta
            'as' => 'fileVideo',
            //Que controlador va a utilizar y que metodo dentro de ese controlador
            'uses' =>'UserProfile@getVideo'
));
/*------------SEARCH-VIDEO------------------*/
//El parametro search es un parametro opcional, me puede venir o no
//Para que el FILTRO funcione le tengo que pasar a la ruta otro parametro FILTER. Tambien va a ser opcional (?)
Route::get('/buscar-video/{search?}/{filter?}',array(
            'as'=>'videoSearch',
            'uses'=> 'UserProfile@searchVideo'
));

 /******************************************/
/*------------*DOC-DETAIL*--------------*/
/******************************************/
/* Le pasamos por URL el parametro obligatorio del video y un array con las caracteristicas del video*/
/*Lo hacemos aqui porque es una ruta que no necesita autenticacion.Esto es para que un usuario no atenticado pueda ver el video*/
Route::get('/doc/{doc_id}',array(
            'as'=> 'detailDoc',
            'uses'=> 'UserProfile@getDocDetail'
));

/*------------GET-DOC------------------*/
//A la ruta le tengo que pasar el parametro que llega obligatoriamente. 
Route::get('/doc-file/{filename}', array(
            //Como segundo parametro le paso un array con el nombre que va a tenr la ruta
            'as' => 'fileDoc',
            //Que controlador va a utilizar y que metodo dentro de ese controlador
            'uses' =>'UserProfile@getDoc'
));
/*------------SEARCH-DOC------------------*/
//El parametro search es un parametro opcional, me puede venir o no
//Para que el FILTRO funcione le tengo que pasar a la ruta otro parametro FILTER. Tambien va a ser opcional (?)
Route::get('/buscar-documento/{search?}/{filter?}',array(
            'as'=>'docSearch',
            'uses'=> 'UserProfile@searchDoc'
));


 /******************************************/
/*------------*INFORMACION DE TABS*--------------*/
/******************************************/
Route::get('/contacto', function () {
        return view('contacto');
});


 /******************************************/
/*------------*SHOW-ALL-USERS*--------------*/
/******************************************/
/*Creamos la ruta para editar el perfil del usuario  y le pasamos el parametro de user_id*/
Route::get('/users', array(
    //Este va a ser el nombre de la ruta
    'as' => 'showUsers', 
    //Ahora le indico que clase y que controlador(accion) va a utilizar
    'uses' => 'UserController@showUsers'
));


/****************************************************************************************/
/*****************************/                            /*****************************/  
/******************************   *//*NOTIFICATIONS*//*    *******************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/

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


/****************************************************************************************/
/*****************************/                            /*****************************/  
/******************************     *//*PUSHER*//*         *******************************/ 
/*****************************/                            /*****************************/ 
/****************************************************************************************/


/********* Muestra la pagina*************/
/*Prueba la funcionalidad dentro de laravel ya ingresada el API keys*/
/*Esto me lleva a una pagina donde puedo enviar mensajes*/
Route::get('/pusherTestPage',function(){
    return view('pusherSenderTest');
});

/*********ENVIA*************/
/*Esto recibe el post de la pagina de prueba*/
Route::post('/pusherSenderTest',function(){
    
    /*La variable ejemplo me va a cojer lo que venga en el request como TEXT y guardarlo*/
    $ejemplo = request()->text;
    /* Esto es una linea de prueba para debugear si me llega el contenido*/
    /*Lo hice porque me estaba dando NULL el PAYLOAD*/
    /*Indico que lo que me llegue de este formulario debe de ser enviado como un event*/
    /*Para que esto funcione arriba tengo que incluir use\App\Events\FormSubmitted*/
    /*Dentro del event podemos incluir cualquier variable que desemos
     *Este PAYLOAD es la misma que vamos a utilizar en el contructor del evento*/
    event(new FormSubmitted($ejemplo));

    return view('pusherSenderTest');
});

/***********RECIBE*************/
/*Prueba la funcionalidad con la debug console en PUSHER site*/
Route::get('/pusherReceiverTest',function(){
    return view('testingPusher');
});

