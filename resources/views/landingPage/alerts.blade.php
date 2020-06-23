<!-- Ahora vamos a recorrer todos los videos que existen , utilizando el metodo PAGINATE que creamos en el controlador HOME -->
<div id="videos-list">

    <!-- Aqui hacemos un IF ELSE para trabajar con la SEARCH. Si existe videos que coincidan con la busqueda entra en el bucle, sino me muestra una alerta -->
    <!-- Puedo llamar a alerts porque esta el modelo importado dentro del homecontroller-->
    @if(count($alerts)>=1)

        <!-- Al FOREACH le paso el nombre de la variable que le paso desde el controlador a la vista ($docs) y que en cada interaccion me cree una variable que se llame $video.-->
        @foreach($alerts as $alert)

            @if($alert->status ==1)
                <div class="video-item col-md-12 pull-left panel">

                <!--------PANEL-BODY ------------------------------------->
                    <div class="alert alert-danger">

                        <!--------MINIATURA----------------->
                        <!-- Para mostrar las imagenes de cada video hacemos un if para comprobar que realmente existen en el disco. Con (has) verifica-->
                        @if(Storage::disk('images')->has($alert->image))
                            <!-- Meto la imagen dentro de unos DIV para poder maquetarla de mejor manera
                            Ademas CREAR un fichero CSS en APP>PUBLIC para darle formato -->
                            <div class="video-image-thumb col-md-4 pull-left">
                                <!--Le meto un video-image-mask para poder manipularla desde CSS-->
                                <div class="video-image-mask">
                                    <!-- Le concateno a la ruta minitura la imagen que quiero ver, en este caso la que pertenesca al fichero que recibo por URL. Tambien le ponemos una clase para poder reducir su tamaño con CSS Video-->
                                    <img src="{{url('/miniaturaAlert/'.$alert->image)}}" class="video-image"/>
                                </div>

                            </div>

                        @endif
                        <!-- ----------DATOS-VIDEO --------->
                        <div class="data">
                            <!-- Para que el titulo me lleve al alert tenemos que pararle el nombre de la ruta y el parametro del [alert_id] que estamos recorriendo en este preciso instante-->
                            <h3 class="video-title"><a href="{{route('detailAlert',['alert_id' => $alert->id]) }}"> {{$alert->title}}</a></h3>
                            <!-- Para q nos lleve al canal de usuario al hacer click en el nombre debemos porner el nombre de la ruta y el user_id que necesita que lo podemos conseguir del objeto VIDEO user_id-->
                            <p>{{$alert->description}}</p>

                            <small>Creada {{$alert->created_at->diffForHumans()}}</small>            
                        </div>
                    </div>
                    <!--------/PANEL-BODY ------------------------------------->
                </div>
            @endif
        @endforeach
    <!-- EN el caso de que no hubieran files que coincida con la busqueda que muestre una alerta-->
    @else
     
    @endif

</div>