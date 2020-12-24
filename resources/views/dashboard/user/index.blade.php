@extends('layouts.app')

@section('content')
@include('layouts.header')
<div class="container-fluid">
    <div class="row">
      <!--Barra de navegación derecha-->
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="sidebar-sticky pt-3">
          @if (auth()->user()->rol_id == 1)<!--Solo si el id del usuario es 1(administrador)-->
          <ul class="nav flex-column">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link active"  href="{{ route('home') }}" aria-selected="true">
                <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
                Regresar</a>
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
          <h1 class="h2">Usuarios</h1>
        </div>
        <!--Contenido-->
          <div class="container">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoUser">
              Nuevo Administrador
            </button>
            <hr>
            {{ $users->links() }}
            <!--Mostrar Usuarios-->
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->rol->key }}</td>
                        <td>
                            <a href="{{ route('user.edit',$user->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarUsuario">Editar</a>
                            <form id="formDelete" method="POST" action="{{ route('user.destroy',$user->id) }}"
                            data-action="{{ route('user.destroy',$user->id)}}">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Borrar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!--/Mostrar Usuarios-->
            <!-- Modal agregar Usuario -->
            <div class="modal fade" id="nuevoUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Nuevo administrador</h5>
                  </div>
                  <div class="modal-body">
                    <form action="{{ route("user.store") }}" method="POST">
                      @csrf
                      <div class="form-group">
                          <label for="name">Nombre</label>
                          <input class="form-control" type="text" name="name" id="name" value="">
                      </div>
                      <div class="form-group">
                          <label for="email">E-mail</label>
                          <input class="form-control" type="email" name="email" id="email" value="">
                          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                      </div>
                      <div class="form-group">
                          <label for="phone">Teléfono</label>
                          <input class="form-control" type="cel" name="phone" id="phone" value="">
                      </div>
                      <div class="form-group">
                          <label for="password">Contraseña</label>
                          <input class="form-control" type="password" name="password" id="password" value="">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- /Modal agregar Usuario -->
            <!-- Modal editar Usuario-->
            <div class="modal fade" id="editarUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="{{ route("user.update",$user->id) }}" method="POST">
                      @method('PUT')
                      @include('dashboard.user._form', ['pasw'=>false])
                  </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /Modal editar Usuario -->
          </div>
        <!--/Contenido-->
      </main>
    </div>
  </div>
@endsection