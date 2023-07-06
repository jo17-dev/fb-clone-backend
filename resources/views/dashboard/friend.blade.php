<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Trouver quelqu'un</h1>
    <ul>
        @forelse($friends as $friend)
        <li>
            {{ $friend->email }}
            <br>
            <form action="{{ url('/dashboard/friends }}" method="post">
                @csrf
                <input type="hidden" name="second" value="{{ $friend->id }}">
                <input type="submit" value>
            </form>
        </li>
        @endforeach
    </ul>
</body>
</html>