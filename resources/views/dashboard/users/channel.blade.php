@extends('landingPage.layout')


@section('content')

<div class="container">
    <div class="row">

        <!----------------------------------------->
      	<div class="container">
   	         		<!--Vamos a saber lo que estamos buscando--->
					<h2>Canal de {{$user->name.' '.$user->surname}}</h2>     				

			<div class="clearfix"></div>
	        @include('dashboard.videos.videosList')
	    </div>
        <!----------------------------------------->     		


    </div>
</div>

@endsection