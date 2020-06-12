           <!-- Ahora vamos a recorrer todos los videos que existen , utilizando el metodo PAGINATE que creamos en el controlador HOME -->
            <div id="videos-list">
                <!-- Aqui hacemos un IF ELSE para trabajar con la SEARCH. Si existe videos que coincidan con la busqueda entra en el bucle, sino me muestra una alerta -->
                @if(count($files)>=1)

                    <!-- Al FOREACH le paso el nombre de la variable que le paso desde el controlador a la vista ($videos) y que en cada interaccion me cree una variable que se llame $video.-->
                    @foreach($files as $file)
                        <div class="video-item col-md-10 pull-left panel panel-default">

                            <!--------PANEL-BODY ------------------------------------->
                            <div class="panel-body">

                            <!--------MINIATURA----------------->
                            <!-- Para mostrar las imagenes de cada video hacemos un if para comprobar que realmente existen en el disco. Con (has) verifica-->
                            @if(Storage::disk('images')->has($file->image))
                                <!-- Meto la imagen dentro de unos DIV para poder maquetarla de mejor manera
                                    Ademas CREAR un fichero CSS en APP>PUBLIC para darle formato -->
                                <div class="video-image-thumb col-md-4 pull-left">
                                    <!--Le meto un video-image-mask para poder manipularla desde CSS-->
                                    <div class="video-image-mask">
                                         <!-- Le concateno a la ruta minitura la imagen que quiero ver, en este caso la que pertenesca al fichero que recibo por URL. Tambien le ponemos una clase para poder reducir su tamaño con CSS file-->
                                        <img src="{{url('/miniatura/'.$file->image)}}" class="video-image"/>
                                    </div>

                                </div>

                            @endif
                            <!-- ----------DATOS-VIDEO --------->
                                <div class="data">
                                    <!-- Para que el titulo me lleve al video tenemos que pararle el nombre de la ruta y el parametro del [video_id] que estamos recorriendo en este preciso instante-->
                                    <h3 class="video-title"><a href="#"> {{$file->filename}}</a></h3>
                                    <!-- Para q nos lleve al canal de usuario al hacer click en el nombre
                                        debemos porner el nombre de la ruta y el user_id que necesita
                                        que lo podemos conseguir del objeto VIDEO user_id-->
                                   
                                </div>
  
                            </div>
                            <!--------/PANEL-BODY ------------------------------------->
                        </div>
                    @endforeach
                <!-- EN el caso de que no hubieran files que coincida con la busqueda que muestre una alerta-->
                @else
                    <div class="alert alert-warning"> No hay archivos actualmente</div>
                @endif

                <!-- ----------PAGINACION -------------->
                <!-- Para pintar la paginacion utilizo el objeto $files que tenemos del controlador y el metodo LINKS -->
                <!-- EL clear fix e s para evitar el overflow y que quede donde tien que ir el pagination-->
                <div class="clearfix"></div>
                {{$files-> links()}}
            </div>