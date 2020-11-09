@extends('dashboard.layout')
@section('title','Inicio')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/panelMqttDashboard.css') }}">
@endpush

@section('content')


<!----------------------------------------------------------->
<!------------------------PAGE------------------------------>
<!----------------------------------------------------------->

	<div class="page">

		<div class="timeline__post">
				<div class="timeline__content">
					 <p> Ya {{Auth::user()->created_at->diffForHumans()}}</p>
            <p>Bienvenido <strong> {{Auth::user()->completeName()}}!.</strong></p>
				</div>
	  </div>

<!------------------------------------------------>
<!---------------SWITCHES------------------------>
<!------------------------------------------------>
    <h2>Toggle Switch</h2>
    <!-------- Switch 1------------>
    <div class="row">
      <div class="card col-md-3">
        <div class="card-body">
          <label class="switch">
            <input type="checkbox">
              <span class="slider"></span>
          </label>
        </div>
      </div>
      <!-------- /Switch 1------------>

      <!-------- Switch 2------------>
      <div class="card bg-primary text-white col-md-3">
        <div class="card-body">
          <label class="switch">
            <input type="checkbox">
              <span class="slider round"></span>
          </label>
        </div>
      </div>
      <!-------- /Switch 2------------>
    </div>
<!------------------------------------------------>
<!---------------/SWITCHES------------------------>
<!------------------------------------------------>


<!------------------------------------------------>
<!--------------- MONITORS------------------------>
<!------------------------------------------------>
    <h2>Monitors</h2>

    <div class="row">
      <div class="card col-md-3">
        <div class="card-body">
          <h4 class="card-title"><i class="fas fa-adjust" style="width:100%"> 12 </i></h4>
          <p class="card-text">Some example text </p>
          <a href="#" class="btn btn-primary">See Profile</a>
        </div>
      </div>
      <br>

      <div class="card col-md-3">
        <div class="card-body">
          <h4 class="card-title"><i class="fas fa-arrow-alt-circle-up" style="width:100%"> 12 </i></h4>
          <p class="card-text">Some example text </p>
          <a href="#" class="btn btn-primary">See Profile</a>
        </div>
      </div>
<!------------------------------------------------>
<!--------------- /MONITORS------------------------>
<!------------------------------------------------>

</div>
<!----------------------------------------------------------->
<!------------------------PAGE------------------------------>
<!----------------------------------------------------------->

@stop
