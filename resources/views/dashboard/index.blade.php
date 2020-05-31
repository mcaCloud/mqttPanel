@extends('dashboard.layout')
@section('title','Panel de control')
@section('content')

<!-- Page Heading -->

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	 <h1 class="h3 mb-0 text-gray-800">{{Auth::user()->completeName()}}</h1>
	 <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>



<div class="row">

	<div class="card col-md-8">
		<div class="card-header">
 			
 		</div>

 		<div class="card-body">
 			

 			
 		</div>
 	</div>

 	<div class="card col-md-4">

 		<div class="card-header">
 			
 		</div>


  		
  	</div>

</div>

 

@stop
