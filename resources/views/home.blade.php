@extends('layouts.app')

@section('content')
<body>
<!--Barra de navegación superior-->
  @include('layouts.header')
<!--/Barra de navegación superior-->
  <div class="container-fluid">
    <div class="row">
      <!--Barra de navegación derecha-->
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="sidebar-sticky pt-3">
          @if (auth()->user()->rol_id == 1)<!--Solo si el id del usuario es 1(administrador)-->
          <ul class="nav flex-column">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
                <i class="fas fa-file-alt"></i>
                Proyectos</a>
              <a class="nav-link" href="{{ route('user.index') }}"><i class="fas fa-users"></i>
                Administrar Usuarios</a>
              <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false"><i class="fa fa-list-ul" aria-hidden="true"></i>
                Administrar tipo de Proyecto</a>
              <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false"><i class="fa fa-list-ul" aria-hidden="true"></i>
                Administrar tipo de Servicio</a>
            </div>
          </ul>
          @endif
        </div>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Mis datos</h5>
            <h6 class="card-text text-muted">{{ Auth::user()->name }}</h6>
            <p class="card-text text-muted">{{ Auth::user()->phone }}</p>
            <p class="card-text text-muted">{{ Auth::user()->email }}</p>
          </div>
        </div>
      </nav>
      <!--/Barra de navegación derecha-->
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          @if (auth()->user()->rol_id == 1)
          <h5>Administrador</h5>
          @else
            @if (auth()->user()->rol_id == 2)
            <h5 class="text-muted">Bienvenido {{ Auth::user()->name }} </h5>
            @endif
          @endif
        </div>
        <!--Contenido-->
          <div class="container">
            @if (auth()->user()->rol_id == 2)
            <create-projects-component></create-projects-component>
            @else
              @if (auth()->user()->rol_id == 1)
              <div class="row">
                <div class=" w-auto col-12">
                  <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab"><view-proyectos-component></view-proyectos-component></div>
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">

                    </div>
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab"><form-tipo-proyecto-component></form-tipo-proyecto-component></div>
                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab"><form-servicio-component></form-servicio-component></div>
                  </div>
                </div>
              </div>
              @endif
            @endif
          </div>
        <!--/Contenido-->
      </main>
    </div>
  </div>
</body>
@endsection
            