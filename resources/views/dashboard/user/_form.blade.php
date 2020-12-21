@csrf
<a class="btn btn-primary" href="{{ route('user.create') }}">
    Crear
</a>
<div class="form-group">
    <label for="name">Nombre</label>
    <input class="form-control" type="text" name="name" id="name" value="{{ old('name',$user->name) }}">
</div>
<div class="form-group">
    <label for="email">E-mail</label>
    <input class="form-control" type="email" name="email" id="email" value="{{ old('email',$user->email) }}">
</div>
<div class="form-group">
    <label for="phone">Teléfono</label>
    <input class="form-control" type="cel" name="phone" id="phone" value="{{ old('phone',$user->phone) }}">
</div>
@if($pasw)
<div class="form-group">
    <label for="password">Contraseña</label>
    <input class="form-control" type="password" name="password" id="password" value="{{ old('password',$user->password) }}">
</div>
@endif
<input type="submit" value="Enviar" class="btn btn-primary">