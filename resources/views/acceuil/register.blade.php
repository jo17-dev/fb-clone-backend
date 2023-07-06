@extends("acceuil.layout")

@section('title')
Acceuil: Register
@endsection

@section("content")
<a href="/home">login in</a>
<form action="/home" method="post">
    @csrf
    @method('POST')
    <div class="">
        <label for="username">Enter your username</label>
        <input type="text" name="username" id="username" value="{{ old('username') }}" required>
    </div>
    <div class="">
        <label for="email">Enter your email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">
    </div>
    <div class="">
        <label for="born_day">Enter your born day:</label>
        <input type="date" name="born_day" id="born_day" value="{{ old('born_day') }}" required>
    </div>
    <div class="">
        <label for="password">Enter your password</label>
        <input type="password" name="password" id="password">
    </div>
    <div class="">
        <label for="confirm_pass">confirm your password</label>
        <input type="password" name="confirm_password" id="confirm_password">
    </div>
    <div class="">
        <input type="submit" value="Register" name="register">
    </div>
</form>
@endsection

@section('get-errors')
    <ul>
    </ul>
@endsection