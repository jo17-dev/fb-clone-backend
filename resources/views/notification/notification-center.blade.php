<!-- This view is use to see all the user's notifications an manage it (mark as seen, delete) -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" >
    <meta name="session" content="{{ session('user_session_data.id') }}" >
    <title>Document</title>
</head>
<body>
    <h1>notifications center: <small>display the list of all the notifications</small></h1>

    <ul>
        @foreach($notifications as $notif)
        <li>
            {{ $notif }} <br>

            @if($notif->type == "friendship")
                <strong>You have a friend request from: {{ $notif->username }}, {{ $notif->email }}, </strong> <br>
                <button value="{{ $notif->id }}" onclick="friendshipDecision('accept', this.value, this)" >Accept</button>
                <button value="{{ $notif->id }}" onclick="friendshipDecision('reject', this.value, this)">Reject</button>
                <br>
            @elseif($notif->type == "inbox_message")
                <strong>You have a new message from: {{ $notif->username }}</strong> <br>
            @elseif($notif->type == "friendship_accepted")
                <strong>{{ $notif->username }} accepted the your invitation. they are now a friends ! </strong> <br>
            @elseif($notif->type == "friendship_rejected")
                <strong>{{ $notif->username }} rejected your invitation </strong> <br>
            @elseif($notif->type == "friendship_removed")
                <strong>{{ $notif->username }} has removed you from his friend list !</strong> <br>
            @else
                <strong>New notification: {{ $notif->type }}</strong> <br>
            @endif
            <form action="{{ url('/notification') }}" method="post">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" value="{{ $notif->id }}">
                <input type="submit" value="delete notifications">
            </form>
        </li>
        @endforeach
    </ul>

    <script src="{{ asset('/js/ajax/friendships/acceptFriendship.js') }}"></script>
</body>
</html>