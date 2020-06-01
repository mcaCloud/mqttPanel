<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <script src="https://js.pusher.com/6.0/pusher.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('97480f5849ba87e70ae4', {
      cluster: 'eu'
    });

    /*Esta es como una habitacion o ROOM donde podemos ver mensajes
      Lo podemos llamar como queramos*/
    var channel = pusher.subscribe('my-channel');
    /* Este es el event especifico que vamos a escuchar por este canal*/
    channel.bind('my-event', function(data) {
      /*Esto es lo que vamos a hacer si se escucha el evento*/
      alert(JSON.stringify(data));
    });
  </script>
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
  </p>
</body>