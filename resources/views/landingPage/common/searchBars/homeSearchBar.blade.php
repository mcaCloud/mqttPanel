@section('searchBar')

<div style="padding: 5px">
    <form class="navbar-form navbar-left" role="search" action="#">
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Qué audio buscas?" name="search">
    </div>
    <button type="submit" class="btn btn-success">
       <span class="glyphicon glyphicon-search"></span>
    </button>
</form>
</div>	
 @endsection 