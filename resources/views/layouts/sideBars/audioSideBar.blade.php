@push('styles')
    <link href="{{ asset('css/mainSideBar.css') }}" rel="stylesheet">
@endpush

@push('scripts')
	<!--<script type="text/javascript" src="{{asset('js/mainSideBar.js')}}"></script> --> 
@endpush

<div class="sidebar" >
  <a href="">Home</a>
  <a href="#news">News</a>
  <a href="#contact">Contact</a>
   <a href="#">Link 1</a>
   <a href="#">Link 2</a>
   <a href="#">Link 3</a>
  <a href="#about">About</a>
</div>