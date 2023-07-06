<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Groups:  @yield('title') </h1>
    <a href="/">Home</a><br>
    <a href="/dashboard">dashboard</a><br>
    <a href="{{ url('/group/create') }}"><button>New group</button></a><br>
    <br>

    @yield('content')

</body>
</html>