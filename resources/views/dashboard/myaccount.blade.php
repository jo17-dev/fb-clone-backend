<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>my account</title>
</head>
<body>
    <h1>My account</h1>
    <a href="{{ url('/dashboard') }}">dashboard</a><br>
    <a href="{{ url('/dashboard/myaccount/edit') }}">edit profil</a><br><br>
    <a href="{{ url('/disconnect') }}">Disconnect</a><br><br>

    <form action="{{ url('/home/user') }}" method="post">
        @method('delete')
        @csrf
        <input type="submit" value="delete my account" name="delete">
    </form>
    <table>
        <thead>
            <tr>
                <td>#</td>
                <td>owner</td>
                <td>content</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            @foreach($my_post as $post)
            <tr>
                <td> {{ $loop->iteration }} </td>
                <td> {{ $post->id_owner }} </td>
                <td> {{ $post->content }}</td>
                <td>
                    <a href="#"><button>like</button></a>
                    <a href="{{ url('/dashboard/'. $post->id) }}"><button>Comment</button></a>
                    <form action="{{ url('/dashboard/'. $post->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="delete">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p> 
        <?php 
        echo "<pre>";
            var_dump(session('user_session_data'));
        echo "</pre><br><br>";
        ?>
    </p>
    <h2>parties des amis:</h2>
    <ul>
        <li>nombres d'amis: <strong>{{ $friends_number }}</strong> </li>
        @isset($flash_message)
            <li> <strong>{{ $flash_message }}</strong> </li>
        @endif
    </ul>
    <table>
        <thead>
            <tr>
                <td>#</td>
                <td>username</td>
                <td>email</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            @forelse($friends as $friend)
            <tr>
                <td>{{ $friend['username'] }}</td>
                <td>{{ $friend['email'] }}</td>
                <td>
                    <form action="{{ url('/api/friendship/'. $friend->id .'/'. session('user_session_data.id')) }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="submit" value="Remove">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>