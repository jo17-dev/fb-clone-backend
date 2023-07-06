@extends('group.layout')

@section('title')
<small>Show the group messages</small>
@endsection

@section('content')

<h3>Group name: {{ $group->title }}</h3>
<p> group name:<strong> {{ $group->title }} </strong> </p>
<h4>members: {{ $members }} </h4>
<a href="{{ url('/group/'. $group->id . '/parameters') }}"><button>show the group parameters</button></a><br>

<!-- display all the messages -->
<table>
    <thead>
        <tr>
            <td>#</td>
            <td>id_owner</td>
            <td>content</td>
            <td>created at</td>
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
                    ~{{ $message->username }}
                @endif
            </td>
            <td> {{ $message->content }} </td>
            <td> {{ $message->created_at }} </td>
            <td>
                @if($message->id_owner == session('user_session_data.id'))
                    <form action="{{ url('/group/'. $message->id . '/delete') }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="submit" value="Delete" name="delete_group_message">
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<br>
<!-- new message form -->

<form action="" method="post">
    @csrf
    <input type="hidden" name="id_group" value="{{ $id_group }}">
    <textarea name="content" cols="40" rows="4" placeholder="Write a message" value="{{ old('content') }}"></textarea>
    <input type="submit" value="Send" name="new_group_message">
</form>
<br>
<!-- dislplay eventually errors -->
@if( !empty( $errors->any() ) )
    <ul>
        @foreach($errors->all() as $error)
        <li> {{ $error }} </li>
        @endforeach
    </ul>
@endif

@endsection