<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <h1>@yield('title')</h1>
    <a href="{{ url('/dashboard') }}">dashboard</a>
    <br>
    <div>
        <div class="">
            <ul>
                @forelse($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach

                @isset($other_error)
                    @foreach($other_error as $err)
                    <li>{{ $err }}</li>
                    @endforeach
                @endisset

                @if( !empty(session('other_error') ) )
                    <li>{{ session('other_error') }}</li>
                @endif

            </ul>
        </div>
        @yield("content")
    </div>
    
<?php
    var_dump(session('user_session_data'));
    echo "<br>";
?>
</body>
</html>