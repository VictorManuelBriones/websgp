@extends('layouts.app')

@section('content')
<body>
    @include('layouts.header')
    <a class="btn btn-primary" href="{{ route('user.create') }}"><i class="fas fa-user-plus"></i>
        Crear
    </a>
    <ul class="list-group my-12">
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
                        <!--<a href="{{ route('user.show',$user->id) }}" class="btn btn-primary">Ver</a>-->
                        <a href="{{ route('user.edit',$user->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form id="formDelete" method="POST" action="{{ route('user.destroy',$user->id) }}"
                        data-action="{{ route('user.destroy',$user->id)}}">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Borrar</button>
                        </form>
<!--<button data-toggle="modal" data-target="#deleteModal" data-id="{{ $user->id }}" class="btn btn-danger">Eliminar</button>-->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </ul>
    {{ $users->links() }}

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Seguro que desea borrar el registro seleccionado?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                    <form id="formDelete" method="POST" action="{{ route('user.destroy',4) }}"
                        data-action="{{ route('user.destroy',4)}}">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">Borrar</button>
                    </form>


                </div>
            </div>
        </div>
    </div>
</body>
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