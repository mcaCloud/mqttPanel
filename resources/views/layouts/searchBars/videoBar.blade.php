<!-- -------------SEARCH-BAR ------------------>
<!-- Aqui añadimos la ruta de buscar para funcione con el controlador.-->

<div style="padding: 5px">
	<form class="navbar-form navbar-left" role="search" action="{{url('/buscar')}}">
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Qué video buscas?" name="search">
    </div>
    <button type="submit" class="btn btn-success">
       <span class="glyphicon glyphicon-search"></span>
    </button>
</form>
</div>

<!-- -------------/SEARCH-BAR ------------------>