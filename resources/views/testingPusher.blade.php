<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Demo Application</title>

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="/css/bootstrap-notifications.min.css">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>


  <body>
    <nav class="navbar navbar-inverse">

      <div class="container-fluid">

        <!-- ------- HEADER -------------------->
        <div class="navbar-header">

          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-9" aria-expanded="false">
            <!-- 'SR-ONLY' es utiliza para ocultar la información destinada sólo para los lectores de pantalla desde el diseño de la página representada. Screen readers will have trouble with your forms if you don't include a label for every input. For these inline forms, you can hide the labels using the .sr-only class.-->
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <a class="navbar-brand" href="#">Notifications App</a>
        </div>
        
        <!-- ------- /HEADER -------------------->

        <div class="collapse navbar-collapse">

          <!-- ------ NAVBAR-------------------->
          <ul class="nav navbar-nav">

            <!-- ------------ LI 1 -------------------->
            <li class="dropdown dropdown-notifications">

              <!-- ----------- BEL-ICON --------------------->
              <a href="#notifications-panel" class="dropdown-toggle" data-toggle="dropdown">
                <i data-count="0" class="glyphicon glyphicon-bell notification-icon"></i>
              </a>

              <!------------------- SUB ------------------->
              <div class="dropdown-container">

                <!------------- sub1 ------------->
                <div class="dropdown-toolbar">

                  <div class="dropdown-toolbar-actions">
                    <a href="{{route('markAllAsRead')}}">Marcar como leídas</a>
                  </div>

                  <h3 class="dropdown-toolbar-title">Notifications (<span class="notif-count">0</span>)</h3>

                </div>

                <!------------- sub2 ------------->
                <ul class="dropdown-menu"></ul>

                <!------------- sub3 ------------->
                <div class="dropdown-footer text-center">
                  <a href="{{route('notifications')}}">Ver todas</a>
                </div>

              </div>
              <!------------------- /SUB ------------------->

            </li>

            <!-- ------------ LI 2 -------------------->
            <li><a href="#">Timeline</a></li>

            <!-- ------------ LI 3 -------------------->
            <li><a href="#">Friends</a></li>

          </ul>
          <!-- ------ /NAVBAR-------------------->
        </div>


      </div>
    </nav>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

     <script src="//js.pusher.com/3.1/pusher.min.js"></script>


    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<!----------------------------------------------------------------------->    
<!-------------BLOCK OF JAVASCRIPT--------------------------------------->

    <!--Este codigo lo que hace es inicializa la libreria de PUSHER  y se suscribe al CHANNEL
        Y setea un CALLBACK para llamar al evento cada vez que sea recivido en este canal-->
    <script type="text/javascript">
      //'dropdown notifications ' es la clase del li() que contiene a todas las notificaciones
      //Me guarda todas la notificaciones en el li()
      //Me hace un wrapper de todas la notificaciones
      var notificationsWrapper   = $('.dropdown-notifications');

      //Este es el dorpdown menu que constienen tambien a la campanita
      //Es un wrapper de cada notificacion
      var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');

      //Que me encuentre cada elemento que haya sido contabilizado/individual
      var notificationsCountElem = notificationsToggle.find('i[data-count]');

      //Convierte en enteros los elementos 
      var notificationsCount     = parseInt(notificationsCountElem.data('count'));

      var notifications          = notificationsWrapper.find('ul.dropdown-menu');

      if (notificationsCount <= 0) {
        notificationsWrapper.hide();
      }

      // Enable pusher logging - don't include this in production
      Pusher.logToConsole = true;

       /*Esta es la forma de hacerlo con JAVASCRIPT*/
      //Primero creo un nuevo objeto PUSHER que se conecta automaticamente con los canales
      //Primer parametro es el API KEY/Segundo parametro son las options en este caso a cual cluster se va a conectar

      /*Inicia la libreria de PUSHER JS*/
      var pusher = new Pusher('97480f5849ba87e70ae4', {
        //encrypted: true
        cluster: 'eu'
      });

/**************************CHANNEL-USERS***************************************************/
      /*Aqui se suscribe al CHANNEL que deseamos para poder escuchar eventos*/
      var channel = pusher.subscribe('users');

      /***************BINDING 1*******************************/
      //Hace el BIND de la funcion al  Event (the full Laravel class)
      //En el EVENT hice un broadcastAs() para darle un nombre legible
      //EL parametro que le vamos a pasar a la fucnion es DATA
      //DATA es el objeto que contiene el conjento de atributos
      //En este ejemplo es EJEMPLO que recoje los que venga por texto 
      channel.bind('user-update', function(data) {
        //Con esta opcion podemos sacar un pop-up alert
        //alert(JSON.stringify(data));

        /*Todo esto ocurre cuando la notificacion del Evento es recibida*/
        var existingNotifications = notifications.html();

        var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;

        var newNotificationHtml = `

          <li class="notification active">

              <div class="media">

              <!-- ------- AVATAR --------------->
                <div class="media-left">
                  <div class="media-object">
                    <img src="https://api.adorable.io/avatars/71/`+avatar+`.png" class="img-circle" alt="50x50" style="width: 50px; height: 50px;">
                  </div>

                </div>

                <!-- ------- BODY --------------->
                <div class="media-body">

                  <!-- Entonces como lo que queremos es ver la informacion que viene or DATA, le adjunto el atributo que deseo ver de esa DATA en este caso emeplo, que es un texto que me llega cuando alguien lo ingresa -->
                  <strong class="notification-title">`+data.role+` `+data.user.first_name+` `+data.user.father_surname+` `+data.state+` por `+data.authUser.first_name+`</strong>

                  <!--p class="notification-desc">Extra description can go here</p-->
                  <div class="notification-meta">
                    <small class="timestamp">`+data.user.created_at+`</small>
                  </div>
                </div>
                <!-- ------- /BODY --------------->

              </div>
          </li>

        `;

        notifications.html(newNotificationHtml + existingNotifications);

        notificationsCount += 1;
        notificationsCountElem.attr('data-count', notificationsCount);
        notificationsWrapper.find('.notif-count').text(notificationsCount);
        notificationsWrapper.show();
      });
    /***************BINDING 1*******************************/

/**************************CHANNEL-USERS***************************************************/
      /*Aqui se suscribe al CHANNEL que deseamos para poder escuchar eventos*/
      var channel = pusher.subscribe('roles');

      /***************BINDING 1*******************************/
      //Hace el BIND de la funcion al  Event (the full Laravel class)
      //En el EVENT hice un broadcastAs() para darle un nombre legible
      //EL parametro que le vamos a pasar a la fucnion es DATA
      //DATA es el objeto que contiene el conjento de atributos
      //En este ejemplo es EJEMPLO que recoje los que venga por texto 
      channel.bind('role-update', function(data) {
        //Con esta opcion podemos sacar un pop-up alert
        //alert(JSON.stringify(data));

        /*Todo esto ocurre cuando la notificacion del Evento es recibida*/
        var existingNotifications = notifications.html();

        var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;

        var newNotificationHtml = `

          <li class="notification active">

              <div class="media">

              <!-- ------- AVATAR --------------->
                <div class="media-left">
                  <div class="media-object">
                    <img src="https://api.adorable.io/avatars/71/`+avatar+`.png" class="img-circle" alt="50x50" style="width: 50px; height: 50px;">
                  </div>

                </div>

                <!-- ------- BODY --------------->
                <div class="media-body">

                  <!-- Entonces como lo que queremos es ver la informacion que viene or DATA, le adjunto el atributo que deseo ver de esa DATA en este caso emeplo, que es un texto que me llega cuando alguien lo ingresa -->
                  <strong class="notification-title">`+data.state+` </strong>

                  <!--p class="notification-desc">Extra description can go here</p-->
                  <div class="notification-meta">
                    <small class="timestamp">`+data.role.created_at+`</small>
                  </div>
                </div>
                <!-- ------- /BODY --------------->

              </div>
          </li>

        `;

        notifications.html(newNotificationHtml + existingNotifications);

        notificationsCount += 1;
        notificationsCountElem.attr('data-count', notificationsCount);
        notificationsWrapper.find('.notif-count').text(notificationsCount);
        notificationsWrapper.show();
      });
    /***************BINDING 1*******************************/

/**************************CHANNEL-ROLES***************************************************/

/**************************CHANNEL-PERMISSIONS***************************************************/
      /*Aqui se suscribe al CHANNEL que deseamos para poder escuchar eventos*/
      var channel = pusher.subscribe('permissions');

      /***************BINDING 1*******************************/
      //Hace el BIND de la funcion al  Event (the full Laravel class)
      //En el EVENT hice un broadcastAs() para darle un nombre legible
      //EL parametro que le vamos a pasar a la fucnion es DATA
      //DATA es el objeto que contiene el conjento de atributos
      //En este ejemplo es EJEMPLO que recoje los que venga por texto 
      channel.bind('permission-update', function(data) {
        //Con esta opcion podemos sacar un pop-up alert
        //alert(JSON.stringify(data));

        /*Todo esto ocurre cuando la notificacion del Evento es recibida*/
        var existingNotifications = notifications.html();

        var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;

        var newNotificationHtml = `

          <li class="notification active">

              <div class="media">

              <!-- ------- AVATAR --------------->
                <div class="media-left">
                  <div class="media-object">
                    <img src="https://api.adorable.io/avatars/71/`+avatar+`.png" class="img-circle" alt="50x50" style="width: 50px; height: 50px;">
                  </div>

                </div>

                <!-- ------- BODY --------------->
                <div class="media-body">

                  <!-- Entonces como lo que queremos es ver la informacion que viene or DATA, le adjunto el atributo que deseo ver de esa DATA en este caso emeplo, que es un texto que me llega cuando alguien lo ingresa -->
                  <strong class="notification-title">`+data.user+` </strong>

                  <!--p class="notification-desc">Extra description can go here</p-->
                  <div class="notification-meta">
                    <small class="timestamp">`+data.permission.created_at+`</small>
                  </div>
                </div>
                <!-- ------- /BODY --------------->

              </div>
          </li>

        `;

        notifications.html(newNotificationHtml + existingNotifications);

        notificationsCount += 1;
        notificationsCountElem.attr('data-count', notificationsCount);
        notificationsWrapper.find('.notif-count').text(notificationsCount);
        notificationsWrapper.show();
      });
    /***************BINDING 1*******************************/

/**************************CHANNEL-ROLES***************************************************/

    </script>
<!--------------------BLOCK OF JAVASCRIPT------------------------------->    
<!----------------------------------------------------------------------->
  </body>

</html>