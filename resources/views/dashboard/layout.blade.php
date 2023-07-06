<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" >
    <meta name="session" content="{{ session('user_session_data.id') }}" >
    <title>facebook-clone</title>
</head>
<body>
    @yield('title') <br>
    
    <a href="{{ url('/notification') }}">notifications</a> <br>

    @yield('content')


</body>
</html>