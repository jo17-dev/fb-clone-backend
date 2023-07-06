<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" >
    <meta name="session" content="{{ session('user_session_data.id') }}">
    <title>Document</title>
</head>
<body>
    <h1>Discution: @yield('title') </h1>
    <a href="{{ url('/dashboard') }}">dashboard</a>
    <br>
    <a href="{{ url('/home') }}">Home</a>
    <br>
    <div>
        @yield('content')
    </div>
    <script src="{{ asset('/js/ajax/blockOrUnblockUser.js') }}"></script>
</body>
</html>