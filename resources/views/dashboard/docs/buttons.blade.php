<!-------------BOTONES-------------->
                        <!-- Si estamos identificados nos muestra los botones de accion. Pero que tambien corresponda con el usuario que agrego el doc. Entonces sacamos de USER el ID -->
                        @if(Auth::check()&& Auth::user()->id == $doc->user->id)
                                        
                            <a href="{{route('detailDoc',['doc_id' => $doc ->id]) }}" class="btn btn-success">
                                <span class="glyphicon glyphicon-play-circle"></span>
                            </a>
                                            
                            <a href="{{route('dashboard::editDoc',['doc_id' => $doc ->id]) }}" class="btn btn-warning">
                                <span class="glyphicon glyphicon-cog"></span>
                            </a>

                                        
                            <!---------------------------------------------------------------------------->
                            <!---------------------------OVERLAY------------------------------------------>
                            <!-- Botón en HTML (lanza el modal en Bootstrap) -->
                            <!-- Lo primero que tengo es un boton que nos hace ancla al DIV     de abajo con id="vidtorModal"
                            Hay que indicarle el ID del comentario para que no sean todos los mismos modals. Es decir para que cada ventanita y cada boton sea diferente. Sino me sale el mismo siempre -->
                            <a href="#victorModal{{$doc->id}}" role="button" class="btn btn-danger" data-toggle="modal"><span class="glyphicon glyphicon-trash"></a>
              
                            <!-- Modal / Ventana / Overlay en HTML -->
                                            <div id="victorModal{{$doc->id}}" class="modal fade">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title">¿Estás seguro?</h4>
                                                        </div>
                                                    <div class="modal-body">
                                                        <p>¿Seguro que quieres borrar este documento?</p>
                                                        <p class="text-warning"><small>{{$doc->title}}</small></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                        <!-- Para poder borrar losc comentarios tengo que hacer un nuevo metodo en el controlador de comentarios. Le paso por parametro a la ruta el ID del comentario que deseo borrar--> 
                                                        <a href="{{url('dashboard/delete-doc/'.$doc->id)}}" type="button" class="btn btn-danger">Eliminar</a>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <!---------------------------/OVERLAY---------------------------------------->
                        @endif