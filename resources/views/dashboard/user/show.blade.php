@extends('layouts.app')

@section('content')

<div class="form-group">
    <label for="name">Nombre</label>
    <input readonly class="form-control" type="text" name="name" id="name" value="{{ $user->name }}">
</div>
<div class="form-group">
    <label for="email">Email</label>
    <input readonly class="form-control" type="email" name="email" id="email" value="{{ $user->email }}">
</div>
<div class="form-group">
    <label for="phone">Teléfono</label>
    <input readonly class="form-control" type="phone" name="phone" id="phone" value="{{ $user->phone }}">
</div>
<!--<div class="form-group">
    <label for="password">Contraseña</label>
    <input readonly class="form-control" type="password" name="password" id="password" value="{{ $user->password }}">
</div>-->


@endsection