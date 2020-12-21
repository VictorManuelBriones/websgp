@extends('layouts.app')

@section('content')

<form action="{{ route("user.update",$user->id) }}" method="POST">
    @method('PUT')
    @include('dashboard.user._form', ['pasw'=>false])
</form>

@endsection