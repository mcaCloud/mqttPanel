<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */
    // Si no especificamos que guardia deseamos utilizar por defautl utilizada el 'web'
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        
        /**Esto es lo que estan utilizando los usuarios normales*/
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        /* Esto es para n sistema de autenticacion basado en tokens*/
        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],

    /*************************************************/
    /*Creamos una guardia para customers*/
        /*'customers' => [
            'driver' => 'session',
            'provider' => 'customers',
        ],*/

    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [

        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],

        //Creamos el provider del customer y lo tenemos que registrar aqui
        //'customers' => [
            /*Vamos a utilizar Eloquent con el modelo de Customer que cramos al principio*/
            /*'driver' => 'eloquent',
            'model' => App\Customer::class,*/
            /*Una vez definido nuestro nuevo GUARD le tenemos que decir al controlador que lo utilice*/
        //],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    //La misma table de password reset se ùede utilizar para todos los modelos solo cambiando los valores de aqui

    'passwords' => [

        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 30,
        ],

        /* 'customers' => [
            'provider' => 'customers',
            'table' => 'password_resets',
            'expire' => 60,
        ],*/
    ],

];
