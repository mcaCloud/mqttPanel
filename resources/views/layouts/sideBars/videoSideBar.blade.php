@push('styles')
    <link href="{{ asset('css/mainSideBar.css') }}" rel="stylesheet">
@endpush

@push('scripts')
	<!--<script type="text/javascript" src="{{asset('js/mainSideBar.js')}}"></script> --> 
@endpush
<div class="sidebar" >
	<!-- SI no estamos identificados nos muestra el login y registro -->
    
  		<a href="">Home</a>
  		<a href="#news">News</a>
  		<a href="#contact">Contact</a>
 	<!-- SI  estamos identificados nos muestra la pagina de USUARIO -->
   
    	<a href="#">Link 1</a>
   		<a href="#">Link 2</a>
   		<a href="#">Link 3</a>
 		<a href="#about">About</a>
        <!-- NEW-VIDEO -->
        <!-- Es usuario identificado puede subir nuevos videos -->
        
        <a href="{{route('createVideo')}}"> <span class="glyphicon glyphicon-circle-arrow-up">-</span>Subir Video</a>
        
        <!-- /NEW-VIDEO -->
</div>