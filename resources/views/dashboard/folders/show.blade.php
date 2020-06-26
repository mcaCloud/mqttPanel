@extends('dashboard.layout')
@section('title','Servicios')

@section('content')

<!-- Esto me verifica si tiene cualquiera de los dos roles-->
@hasanyrole('super-administrador|administrador')
<!-- Como la ruta esta en DASHBOARD no debemos olvidar ponerlo porque sino no encuentra la ruta-->
<a href="{{ route('dashboard::productos.create',['id' =>$folder->id])}}" class="btn btn-success">Crear trámite</a>

<!------------------------------>
<!----------OPTIONs------------->
<!------------------------------>
<p>
<!-- Esto es para que no nos pongo bullt points-->
  <ul style="list-style: none;">
    <li>
      <a href="{{route('dashboard::categorias.index')}}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">Inicio
      </a>

      <span class="separador">| </span>
      <a href="{{ URL::previous() }}" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">Atrás
      </a> 
      <span class="separador">| </span>
      <a href="#" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">Borrados
      </a> 
    </li>  
  </ul>
</p>
<!------------------------------>
<!----------OPTIONs------------->
<!------------------------------>
@endhasrole

<!-- ----------------CARD--------------------- -->
<div class="card shadow mb-6">
  <!-------------------------------------->
  <!--------- Header---------------------->
  <div class="card-header py-3">
    <button class="btn-info btn-lg"><strong>{{$folder->name}}</strong></button>
  </div>

  <!-------------------------------------->
  <!--------- BODY---------------------->
  <div class="card-body table-responsive">
    <!---------------------Table------------------->
    <!---(dabatable-responsive) es el ID que utilizo en el dashboard/layout-->
    <!---De esta forma el JS sabe que esta tabla utiliza DATATABLES--->
    <table id="datatable-responsive" class="table table-striped  dt-responsive display" style="width: 100%">
      <!----------------->
      <thead>
        <tr>
          <th>Nombre del trámite</th>
          <th>Acciones</th>
        </tr>
      </thead>

      <tbody>
      <!--Aqui tomo la variable ('products') que cree en el metodo Index
      del controloador de User-->
      @foreach ($product as $product)
        <!------------------------------------------->
        <!-------------------ROW--------------------->
        <!-- Es row es super importante para que funcione la Datatable con el search
          Al final lo que hago para agregar el search es añadir la opcion en el template de layout donde tengo el JS. -->
        <tr>
          <!--Me recorre cada uno de los resultados-->
          <!-------------------------------------->
          <td>
            <div class="col-md-4">
              {{$product->name}} 
            </div>  
          </td>
          <!-------------------------------------->
          <td>
            <div class="col-md-8">
                <a  href="{{ route('dashboard::products.toggleAccess', ['product' => $product->id, 'type' => 'status']) }}"
                  data-toggle="tooltip" data-placement="top" title="" class="status-icons d-flex justify-content-center" data-original-title="Acceder a la aplicación">

                    <i class="fa @if( $product->status ) fa-toggle-on @else fa-toggle-off @endif fa-2x"></i>
                </a>
            </div> 
          </td>
          <!--------------------------------------->
          <!------------ BOTONES ------------------>
          <td class="d-flex justify-content-center">
            @include('dashboard.folders.partials.buttons')                  
          </td>
          <!------------ /BOTONES ------------------>
          <!--------------------------------------->
        </tr>
      @endforeach
    </tbody>         
  </table>
  </div>
</div>
@stop