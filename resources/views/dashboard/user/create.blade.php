@extends('layouts.app')

@section('content')
@include('layouts.header')
<form action="{{ route("user.store") }}" method="POST">
    @include('dashboard.user._form', ['pasw'=>true])
</form>

@endsection