    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Con esto puedo agregar un tiulo individual a los tabs--->
    <title>MCA- @yield('title')</title>
<!------------------------------------------- -->
    <!---------------- Styles ---------->
    <!-- Este es importante para que funciones los Glyphicons.Por algun motivo solo asi me funciona -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    

    <!-- Cargamos el archivo de CSS particular que tenemos dentro del storage en la carpeta CSS que creamos. Utilizo un URL y la ruta ruta donde tengo el ASSET -->
     <link href="{{ asset('css/style.css') }}" rel="stylesheet">
     
  <!-- Con este link cargamos la configuracion del bootstrap.min.css, con todos los defaults-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

