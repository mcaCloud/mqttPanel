@extends('dashboard.layout')
@section('title','Inicio')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/timeLine.css') }}" >
@endpush

@section('content')

<!-- Page Heading -->


	<div class="card col-md-12">

 			<!----------------------------------------------------------->
 			<!------------------------Time-Line-------------------------->
 			<!----------------------------------------------------------->

			<div class="page">

			 <div class="timeline__box">

			 		<span class="timeline__date">
			          <span class="timeline__day"><i class="fa fa-flag-checkered" aria-hidden="true"></i> Inicias ahora!</span>
			        </span>
			 </div>

<!-------------------TIME-LINE----------------------------->
	<div class="timeline">

<!----------------------------------------------->
<!----------------------------------------------->
<!--------------- GROUP 1 ----------------------->
			<div class="timeline__group">


			    <!--------------- BOX AVATAR --------------->
			    <div class="timeline__box">

 					<span class="timeline__year">2014</span>

			      	<!--------- DATE------------------->
			      	<div class="timeline__date">
			          <span class="timeline__day">14</span>
			          <span class="timeline__month">Jul</span>
			        </div>
			        <!--------- DATE------------------->
			        <div class="timeline__post">
			          <div class="timeline__content">
			            <p> <img src="https://api.adorable.io/avatars/70/`+avatar+`.png" class="img-circle" alt="50x50" style="width: 50px; height: 50px;"> {{Auth::user()->first_name}}! </p>
			          </div>			          
			        </div>

			        <div class="timeline__post">
			          <div class="timeline__content">
			            <p> Ya {{Auth::user()->created_at->diffForHumans()}} que comenzaste tu proceso de regularización! Estos son los guientes pasos en tu proceso para completarlo.</p>
			          </div>			          
			        </div>

			      </div>
			</div>
<!----------------------------------------------->
<!----------------------------------------------->
<!----------------------------------------------->
<!----------------------------------------------->
<!--------------- GROUP 1 ----------------------->
			<div class="timeline__group">

 				<span class="timeline__year"style="background: green;">Paso 1</span>

			    <!--------------- BOX AVATAR --------------->
			    <div class="timeline__box">
			      	<!--------- DATE------------------->
			      	<div class="timeline__date">

			          <span class="timeline__day">24</span>
			          <span class="timeline__month">Nov</span>

			        </div>
			        <!--------- DATE------------------->
			        <div class="timeline__post">
			          <div class="timeline__content">
			          	<h3><strong>Recepcción de documentos</strong></h3>
			            <p> Según mi sistema comenzaste a entregar los documentos que te solicitamos {{Auth::user()->created_at->diffForHumans()}}! </p>
			            <p>Estos son los documentos que hemos recibido hasta la fecha:</p>
			            <ul>
			            	<li>
			            		JKJLKJKJ
			            	</li>

			            	<li>
			            		JKJLKJKJ
			            	</li>
			            </ul>
			          </div>			          
			        </div>


			</div>

			<div class="timeline__box">
				
			        <div class="timeline__post">
			          <div class="timeline__content">
			            <p> Test </p>
			          </div>			          
			        </div>
			</div>

			<div class="timeline__box">
				
					<div class="timeline__post">
			          <div class="timeline__content">
			          	<h5><strong>Pendientes</strong></h5>
			            <p> <img src="https://api.adorable.io/avatars/70/`+avatar+`.png" class="img-circle" alt="50x50" style="width: 50px; height: 50px;"> Ya {{Auth::user()->created_at->diffForHumans()}} que comenzaste tu proceso de regularización!</p>
			          </div>			          
			        </div>
			</div>
<!----------------------------------------------->
<!----------------------------------------------->


<!----------------------------------------------->
<!----------------------------------------------->
<!--------------- GROUP 2 ----------------------->
			<div class="timeline__group">

				<span class="timeline__year"style="background: lightgray;">Paso 2</span>

			     <!--------------- BOX 1 --------------->			      
			     <div class="timeline__box">
			      

			        <div class="timeline__post" style="background: lightgray;">
			          <div class="timeline__content">
			          	<h3><strong>Solicitar cita</strong></h3>
			            <p>Started from University of Pennsylvania. This is an important stage of my career. Here I worked in the local magazine. The experience greatly affected me</p>
			          </div>
			        </div>
			      </div>

			     <!--------------- BOX 2 --------------->	
			     <div class="timeline__box">

			     	<div class="timeline__date" style="background: lightgray;">
			          <span class="timeline__day"></span>
			          <span class="timeline__month"></span>
			        </div>
			      

			        <div class="timeline__post" style="background: lightgray;">
			          <div class="timeline__content">
			            <p>Started from University of Pennsylvania. This is an important stage of my career. Here I worked in the local magazine. The experience greatly affected me</p>
			          </div>
			        </div>
			    </div>

			    <!--------------- BOX 2 --------------->	
			     <div class="timeline__box">

			     	<div class="timeline__date" style="background: lightgray;">
			          <span class="timeline__day"></span>
			          <span class="timeline__month"></span>
			        </div>
			      

			        <div class="timeline__post" style="background: lightgray;">
			          <div class="timeline__content">

			            <p>Started from University of Pennsylvania. This is an important stage of my career. Here I worked in the local magazine. The experience greatly affected me</p>
			          </div>
			        </div>
			    </div>

			    <!--------------- BOX 2 --------------->	
			     <div class="timeline__box">

			     	<div class="timeline__date" style="background: lightgray;">
			          <span class="timeline__day"></span>
			          <span class="timeline__month"></span>
			        </div>
			      

			        <div class="timeline__post" style="background: lightgray;">
			          <div class="timeline__content">
			            <p>Started from University of Pennsylvania. This is an important stage of my career. Here I worked in the local magazine. The experience greatly affected me</p>
			          </div>
			        </div>
			    </div>

			 </div>
<!----------------------------------------------->
<!----------------------------------------------->

<!----------------------------------------------->
<!----------------------------------------------->
<!--------------- GROUP 3 ----------------------->			    

			<div class="timeline__group">
 			
 				<span class="timeline__year"style="background: lightgray;">Paso 3</span>


			      <div class="timeline__box">
			        <div class="timeline__date"style="background: lightgray;">
			          <span class="timeline__day"></span>
			          <span class="timeline__month"></span>
			        </div>
			        <div class="timeline__post"style="background: lightgray;">
			          <div class="timeline__content">
			          	<h3><strong>Alta Seguridad Social</strong></h3>
			            <p>Travels to France, Italy, Spain, and Peru. After completing fashion editorial in Lima, prolongs stay to make portraits of local people in a daylight studio</p>
			          </div>
			        </div>
			      </div>
			</div>

<!----------------------------------------------->
<!----------------------------------------------->

<!----------------------------------------------->
<!----------------------------------------------->
<!--------------- GROUP  ----------------------->
			<div class="timeline__group">
			      <span class="timeline__year"style="background: lightgray;">Paso 4</span>
			      <div class="timeline__box">
			        <div class="timeline__date"style="background: lightgray;">
			          <span class="timeline__day"></span>
			          <span class="timeline__month"></span>
			        </div>
			        <div class="timeline__post" style="background: lightgray;">
			          <div class="timeline__content">
			          	<h3><strong>Huellas</strong></h3>
			            <p>Upon moving to Brooklyn that summer, I began photographing weddings in Chicago</p>
			          </div>
			        </div>
			      </div>
			</div>
<!--------------- -------------------------------------->
<!----------------------------------------------->
<!----------------------------------------------->
			  </div>
			</div>


			<!---------------------------------------------------------------------->
			<!-------------- LINKEDIN ---------------------------------------------->
			<div class="linkedin">
			  <div class="linkedin__container">
			    <p class="linkedin__text">Bienvenido <strong> {{Auth::user()->completeName()}}!.</strong></p>

			    <p class="linkedin__text">Estás más cerca de lograrlo 👉 <a href="#" rel="noopener noreferrer" target="_blank">join to me on Patreon!</a></p>

			    
			  </div>
			</div>

 			<!----------------------------------------------------------->
 			<!----------------------------------------------------------->
 			<!----------------------------------------------------------->

@stop
