<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard::index') }}">
      <div class="sidebar-brand-text mx-3"><img src="/img/logo.png" alt="logo" class="img-thumbnail"></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="{{route('dashboard::index')}}">
        <i class="fas fa-fw fa-home"></i>
        <span>Inicio</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Administracíon
    </div>

    @hasanyrole('administrador|super-administrador')
      <!---------------------------------------------------------->
      <!---------------------- L1-ADMIN ----------------------------->
        <li class="nav-item">

          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Accesos</span>
          </a>

          <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" href="{{ route('dashboard::users.index') }}"><i class="fas fa-users"></i>   Usuarios</a>
              <a class="collapse-item" href="{{ route('dashboard::roles.index') }}"><i class="fas fa-briefcase"></i> Roles</a>
              <a class="collapse-item" href="{{ route('dashboard::permissions.index') }}"><i class="fa fa-unlock" aria-hidden="true"></i> Permisos</a>
            </div>
          </div>
        </li>  

      <!---------------------------------------------------------->
      <!---------------------- L2-ADMIN ----------------------------->
        <li class="nav-item">

          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#ordenesUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Portafolio</span>
          </a>

          <div id="ordenesUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" href="{{ route('dashboard::categorias.index') }}"><i class="fas fa-users"></i> Oferta de servicios</a>
              <a class="collapse-item" href="{{ route('dashboard::offices.index') }}"><i class="fas fa-briefcase"></i> Directorio</a>
              <a class="collapse-item" href="#') }}"><i class="fa fa-unlock" aria-hidden="true"> Productos</i> </a>
            </div>
          </div>
        </li>  

      <!---------------------------------------------------------->
      <!---------------------- L2-ADMIN ----------------------------->
        <li class="nav-item">

          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#websiteUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Website</span>
          </a>

          <div id="websiteUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" href="{{route('dashboard::noticiasIndex') }}"><i class="fas fa-users"></i>   Noticias</a>
              <a class="collapse-item" href="{{route('dashboard::videosIndex') }}"><i class="fas fa-briefcase"></i> Videos</a>
              <a class="collapse-item" href="{{route('dashboard::alertsIndex') }}"><i class="fas fa-briefcase"></i> Alertas</a>

              <a class="collapse-item" href="#"><i class="fa fa-unlock" aria-hidden="true"></i> Anuncios</a>
            </div>
          </div>
        </li>  
      @endhasanyrole

        <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Cuenta de cliente
    </div>
    <!---------------------------------------------------------->
     <!---------------------- LI-2 ----------------------------->
      <li class="nav-item">
        <!-- El 'data-target ' lo que hace es vincular el ID de lo que tiene que mostrar-->
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#procesosUtility" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-briefcase"></i>
          <span>Mis documentos</span>
        </a>
        <!-- El ID se vincula con el 'data-target' de arriba para poder mostrar el menu-->
        <div id="procesosUtility" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">

          <div class="bg-white py-2 collapse-inner rounded">

            <a class="collapse-item" href="{{route('dashboard::folders.index')}}"><i class="fa fa-file"></i> Carpetas</a>
            <a class="collapse-item" href="{{ route('dashboard::pdfs.index') }}"><i class="fa fa-file-pdf" aria-hidden="true"></i>  Exportar a pdf</a>
          </div>
        </div>
      </li>
    <!---------------------------------------------------------->
     <!---------------------- LI-2 ----------------------------->


      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#miPlanUtility" aria-expanded="true" aria-controls="collapseUtilities2">
          <i class="fas fa-credit-card"></i>
          <span>Mi plan</span>
        </a>
        <div id="miPlanUtility" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">

            <a class="collapse-item" href="#"><i class="fas fa-credit-card "></i> Pagos</a>
            <a class="collapse-item" href="#"><i class="fa fa-address-card" aria-hidden="true"></i></i> Suscripción</a>

            <a class="collapse-item" href="{{ route('dashboard::pdfs.index') }}"><i class="fas fa-key"></i> Cambiar contraseña</a>
          </div>
        </div>
      </li>

    <!---------------------------------------------------------->
    <!---------------------- LI-1 ----------------------------->
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Gestión de clientes
    </div>
    <!---------------------------------------------------------->
     <!---------------------- LI-2 ----------------------------->


      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#clientesUtility" aria-expanded="true" aria-controls="collapseUtilities2">
          <i class="fas fa-credit-card"></i>
          <span>Clientes</span>
        </a>
        <div id="clientesUtility" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">

            <a class="collapse-item" href="#"><i class="fas fa-credit-card "></i> Suscripciones</a>
            <a class="collapse-item" href="#"><i class="fa fa-address-card" aria-hidden="true"></i></i> Nuevo contrato</a>

            <a class="collapse-item" href="{{ route('dashboard::pdfs.index') }}"><i class="fas fa-key"></i> Cambiar contraseña</a>
          </div>
        </div>
      </li>

    <!---------------------------------------------------------->
    <!---------------------- LI-1 ----------------------------->
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

</ul>
<!-- End of Sidebar -->
