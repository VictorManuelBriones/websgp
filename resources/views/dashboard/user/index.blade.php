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
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarUsuario{{ $user->id }}">Editar</button>
                             <!-- Modal editar Usuario-->
                            <div class="modal fade" id="editarUsuario{{ $user->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Editar Usuario</h5>
                                  </div>
                                  <div class="modal-body">
                                    <form action="{{ route("user.update",$user->id) }}" method="POST">
                                      @method('PUT')
                                      @include('dashboard.user._form', ['pasw'=>false])
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <input type="submit" value="Guardar" class="btn btn-primary">
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- /Modal editar Usuario -->
                            <button data-toggle="modal" data-target="#deleteModal{{ $user->id }}" data-id="{{ $user->id }}"
                              class="btn btn-danger">Eliminar</button>
                              <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content ">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel"></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Seguro que desea borrar {{ $user->name }}?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            
                                            <form id="formDelete" method="POST" action="{{ route('user.destroy',$user->id) }}"
                                              data-action="{{ route('user.destroy',$user->id)}}">
                                              @method('DELETE')
                                              @csrf
                                              <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Borrar</button>
                                              </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                          <small id="emailHelp" class="form-text text-muted">Nunca compartiremos tu correo electrónico con nadie más.</small>
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
                        <button type="submit" class="btn btn-primary">Guardar</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- /Modal agregar Usuario -->
          </div>
        <!--/Contenido-->
      </main>
    </div>
    
  </div>

  <script>
    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      
        action = $('#formDelete').attr('data-action').slice(0,-1)
        action += id
        console.log(action)
      
        $('#formDelete').attr('action',action)
      
        var modal = $(this)
        modal.find('.modal-title').text('Vas a borrar la categoría: ' + id)
      })
  </script>
@endsection