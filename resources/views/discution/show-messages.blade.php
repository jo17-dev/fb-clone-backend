@extends('discution.layout')

@section('title')
    Affichage d'une discution.
@endsection

@section('content')

<!-- new message form -->

<form action="" method="post">
    @csrf
    <textarea name="content" cols="40" rows="4" placeholder="Write a message"></textarea>
    <input type="submit" value="Send" name="new_message">
</form>

<!-- dislplay eventually errors -->
@if( !empty( $errors->any() ) )
    <ul>
        @foreach($errors->all() as $error)
        <li> {{ $error }} </li>
        @endforeach
    </ul>
@endif

<!-- display all the messages -->
<table>
    <thead>
        <tr>
            <td>#</td>
            <td>username</td>
            <td>content</td>
            <td>created at</td>
            <td>statut</td>
            <td>Actions</td>
        </tr>
    </thead>
    <tbody>
    @forelse($messages as $message)
        <tr>
            <td> {{ $loop->iteration }} </td>
            <td>
                @if( $message->id_owner == session('user_session_data.id') )
                    Vous
                @else
                    {{ $message->username }}
                @endif
            </td>
            <td> {{ $message->content }} </td>
            <td> {{ $message->created_at }} </td>
            <td>
                @if( $message->id_owner == session('user_session_data.id') )

                    @if($message->is_read == false)
                        <strong>non lue</strong>
                    @else
                        lue
                    @endif
                @endif
            </td>
            <td>
                @if($message->id_owner == session('user_session_data.id'))
                    <form action="{{ url('/discution/'. $message->id . '/delete') }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="submit" value="Delete" name="delete_message">
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection