<!-- Ahora vamos a recorrer todos los videos que existen , utilizando el metodo PAGINATE que creamos en el controlador HOME -->
            <div id="videos-list">
                <!-- Aqui hacemos un IF ELSE para trabajar con la SEARCH. Si existe videos que coincidan con la busqueda entra en el bucle, sino me muestra una alerta -->
                @if(count($videos)>=1)

                    <!-- Al FOREACH le paso el nombre de la variable que le paso desde el controlador a la vista ($videos) y que en cada interaccion me cree una variable que se llame $video.-->
                    @foreach($videos as $video)

                    @if($video->status ==1)
                        <div class="video-item col-md-12 pull-left panel">

                            <!--------PANEL-BODY ------------------------------------->
                            <div class="panel-body">

                            <!--------MINIATURA----------------->
                            <!-- Para mostrar las imagenes de cada video hacemos un if para comprobar que realmente existen en el disco. Con (has) verifica-->
                            @if(Storage::disk('images')->has($video->image))
                                <!-- Meto la imagen dentro de unos DIV para poder maquetarla de mejor manera
                                    Ademas CREAR un fichero CSS en APP>PUBLIC para darle formato -->
                                <div class="video-image-thumb col-md-4 pull-left">
                                    <!--Le meto un video-image-mask para poder manipularla desde CSS-->
                                    <div class="video-image-mask">
                                         <!-- Le concateno a la ruta minitura la imagen que quiero ver, en este caso la que pertenesca al fichero que recibo por URL. Tambien le ponemos una clase para poder reducir su tamaño con CSS Video-->
                                         <!--Muy importante fijarse en la ruta por que si no puede provocar poroblema que no despliega la imagen-->
                                        <img src="{{url('/miniaturaVideo/'.$video->image)}}" class="video-image"/>
                                        

                                    </div>

                                </div>

                            @endif
                            <!-- ----------DATOS-VIDEO --------->
                                <div class="data">
                                    <!-- Para que el titulo me lleve al video tenemos que pararle el nombre de la ruta y el parametro del [video_id] que estamos recorriendo en este preciso instante-->
                                    <h3 class="video-title"><a href="{{route('detailVideo',['video_id' => $video ->id]) }}"> {{$video->title}}</a></h3>
                                    <!-- Para q nos lleve al canal de usuario al hacer click en el nombre
                                        debemos porner el nombre de la ruta y el user_id que necesita
                                        que lo podemos conseguir del objeto VIDEO user_id-->
                                    <p>{{$video->description}}</p>

                                    <small>Creado por {{$video->user->alias}} {{$video->created_at->diffForHumans()}}</small>
                                   
                                </div>

                                <!-------------BOTONES-------------->
                            <!-- Si estamos identificados nos muestra los botones de accion. Pero que tambien corresponda con el usuario que agrego el video. Entonces sacamos de USER el ID -->
                            @if(Auth::check()&& Auth::user()->id == $video->user->id)
                                
                                <a href="{{route('detailVideo',['video_id' => $video ->id]) }}" class="btn btn-success"><span class="glyphicon glyphicon-play-circle"></a>
                                    
                                <a href="{{route('dashboard::editVideo',['video_id' => $video ->id]) }}" class="btn btn-warning"><span class="glyphicon glyphicon-cog"></span></a>

                                
                                <!---------------------------------------------------------------------------->
                                <!---------------------------OVERLAY------------------------------------------>
                                <!-- Botón en HTML (lanza el modal en Bootstrap) -->
                                <!-- Lo primero que tengo es un boton que nos hace ancla al DIV de abajo con id="vidtorModal"
                                Hay que indicarle el ID del comentario para que no sean todos los mismos modals. Es decir para que cada ventanita y cada boton sea diferente. Sino me sale el mismo siempre ({{$video->id}})-->
                                <a href="#victorModal{{$video->id}}" role="button" class="btn btn-danger" data-toggle="modal"><span class="glyphicon glyphicon-trash"></a>
      
                                    <!-- Modal / Ventana / Overlay en HTML -->
                                    <div id="victorModal{{$video->id}}" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title">¿Estás seguro?</h4>
                                                </div>
                                            <div class="modal-body">
                                                <p>¿Seguro que quieres borrar este video?</p>
                                                <p class="text-warning"><small>{{$video->title}}</small></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                <!-- Para poder borrar losc comentarios tengo que hacer un nuevo metodo en el controlador de comentarios. Le paso por parametro a la ruta el ID del comentario que deseo borrar--> 
                                                <a href="{{url('dashboard/delete-video/'.$video->id)}}" type="button" class="btn btn-danger">Eliminar</a>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!---------------------------/OVERLAY---------------------------------------->
                            @endif
  
                            </div>
                            <!--------/PANEL-BODY ------------------------------------->
                        </div>
                        @endif
                    @endforeach
                <!-- EN el caso de que no hubieran files que coincida con la busqueda que muestre una alerta-->
                @else
                    <div class="alert alert-warning"> No hay archivos actualmente</div>
                @endif

            </div>