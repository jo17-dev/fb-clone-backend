@extends('acceuil.layout')

@section('title')
Acceuil: Login
@endsection

@section('content')

<a href="{{ url('/home/create') }}">sign-up</a>
<form action="/home" method="post">
    @csrf
    @method('POST')
    <div class="">
        <label for="email">Enter your email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">
    </div>
    <div class="">
        <label for="password">Enter your password</label>
        <input type="password" name="password" id="password">
    </div>
    <div class="">
        <input type="submit" value="Log in" name="login">
    </div>
</form>
@endsection