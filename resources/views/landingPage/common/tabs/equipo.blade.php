
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<img src="{{asset('img/logo.png')}}">
			</div>

		</div>
 	</div>




	<div class="col-md-12">
		<div class="panel ">
			<div class="panel-group">

				<!-------------------------------------------------->
				<div>
					<!----------- COL-MD-12-------------------->
					<div class="col-md-12">
						<div class="row">
							<!--Para poder dar el nombre de la persona que trabaja para la compañia en el landing page , primero tuve que llamar el modelo de USer en el homeController, y pasarlo por parametro para poder utilizar la variable $users-->
							@foreach($users as $user)

								<!------------- PANEL-INDIVIDUAL------------>
								<div class="panel col-md-4">
									<div class="panel-body">
									<!--------MINIATURA----------------->
						              <!-- Para mostrar las imagenes de cada video hacemos un if para comprobar que realmente existen en el disco. Con (has) verifica-->
						              <!-- Debode utilizar el AUTHUSER para que la miniatura me funcione en todas la paginas-->
						              @if(Storage::disk('avatars')->has($user->image))
						                <!-- Le concateno a la ruta minitura la imagen que quiero ver-->
						                <!-- Aqui estoy utilizando el metodo del UserProfile ('getImage')-->
						                <!-- Como segundo parametro la ruta necesita el 'filename', entonces le paso el path de la image que guardé en el metodo update-->
						                <!--La quiero centrar entonces utilizo una posicion relativa y 25% hacia la izquierda-->

						                		<img src="{{url('/miniatura/'.$user->image)}}" style="vertical-align: middle;width:220px;height:200px;box-shadow: 0 0 8px rgba(0,0,0,0.8);" />   

						           
						              @else
						                  <img src="{{ URL::to('/') }}/img/avatar.png" class="img-responsive center-block"/>
						              @endif
                         
									</div>
									<!---------FOOTER------------------------>
									<div class="panel-footer">

										<h3>{{$user->first_name}}  							{{$user->father_surname}}
										</h3>

										<p>{{$user->first_name}} ha sido un gran colaborador del equipo desde  {{$user->created_at->diffForHumans()}}.<p>

											<!--Aqui comenzamos a sacar la informacion de la tabla de empleados-->
											@foreach($employees as $employee)
												<!---- Aqui enlazamos la tabla de emploee con la de user y comenzamos a extraer la infromacion especifica del usuario-->
												@if($user->id == $employee->user_id)
												<!-- Aqui ya estamos importando info de esa tabla-->
													<p>Se desempeña como {{$employee->job_title}} dentro de la empresa. Tiene gran experiencia en  {{$employee->studies}}. </p>		

													<p>{{$user->first_name}} nació en la ciudad de {{$employee->cityOfBirth}} pero actualmente recide en la cuidad de {{$employee->city}}. Dentro de sus intereses principales está {{$employee->interest}}.</p>

									           <a href="#" class="fa fa-facebook fa-2x"></a>
									           <a href="#" class="fa fa-instagram fa-2x"></a>  

												@endif
											@endforeach

									</div>
									<!---------/FOOTER------------------------>
								</div>
			  					<!------------- /PANEL-INDIVIDUAL------------>
							@endforeach
						</div>
					</div>
					<!----------- /COL-MD-12-------------------->
				</div>

			</div>
 		</div>
	</div>

