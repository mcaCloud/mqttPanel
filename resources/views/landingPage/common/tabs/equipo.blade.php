<div class="row">
<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-body">
			<img src="{{asset('img/logo.png')}}">
		</div>

	</div>
 </div>
</div>


<div class="row">
<div class="col-md-12">
	<div class="panel ">
		<div class="panel-group">
		<div>
			
		
		<div class="col-md-12">
			<div class="row">
			@foreach(Auth::user()->get() as $user)

			<div class="col-md-4">
				<div class="panel-body">

					{{$user->first_name}}

				</div>

				<div class="panel-footer">
					Es parte del equipo {{$user->created_at->diffForHumans()}}
				</div>
			</div>
			  
			@endforeach
		</div>
		</div>
	</div>

	</div>
 </div>
</div>
