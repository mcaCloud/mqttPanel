/***************BINDING 1*******************************/
      //Hace el BIND de la funcion al  Event (the full Laravel class)
      //En el EVENT hice un broadcastAs() para darle un nombre legible
      //EL parametro que le vamos a pasar a la fucnion es DATA
      //DATA es el objeto que contiene el conjento de atributos
      //En este ejemplo es EJEMPLO que recoje los que venga por texto 
      channel.bind('user-deleted', function(data) {
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
                  <strong class="notification-title">`+data.user.first_name+` ha sido eliminado en el sistema</strong>

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


    /***************BINDING 2*******************************/
          //Hace el BIND de la funcion al  Event (the full Laravel class)
          //En el EVENT hice un broadcastAs() para darle un nombre legible
          //EL parametro que le vamos a pasar a la fucnion es DATA
          //DATA es el objeto que contiene el conjento de atributos
          //En este ejemplo es EJEMPLO que recoje los que venga por texto 
          channel.bind('user-created', function(data) {
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
                      <strong class="notification-title">`+data.user.first_name+` ha sido creado  en el sistema</strong>

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
        /***************BINDING 2*******************************/