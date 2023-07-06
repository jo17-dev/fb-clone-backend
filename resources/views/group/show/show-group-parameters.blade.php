@extends('group.layout')

@section('title')
<small>Show the group parameters</small>
@endsection

@section('content')

{{ $group }} <br>

<!-- buttons for edit a group or add somme one (One by One for the moment) -->
@if($group->id_owner == session('user_session_data.id'))
    <a href="{{ url('group/' .$group->id .'/edit') }}"><button>Edit the group parameters</button></a><br>
    <button>Add some One</button>
    <form action="{{ url('group/' .$group->id .'/edit') }}" method="post">
        @csrf
        <input type="email" name="email" id="email" placeholder="Write an email to add his owner">
        <input type="submit" value="Add">
    </form><br>

    <!-- generated thr group link by hash by md2 algo the concatenation of id an id_owner for this group -->
    <h3><small>Goup link:</small> {{ hash('md2', $group['id']. $group['id_owner'] ) }} </h3>
@endif

<h3>Members: {{ count($members) }} </h3>
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
        @forelse($members as $member)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td> {{ $member->username }} </td>
            <td>{{ $member->email }}</td>
            <td>
                @if($member->id == $group->id_owner )
                    <strong>Admin</strong>
                @elseif($group->id_owner == session('user_session_data.id') )
                    <form action="{{ url('/group/' . $group->id . '/removeMember') }}" method="post">
                        @csrf
                        <input type="hidden" name="id_member" value="{{ $member->id }}">
                        <input type="submit" value="remove">
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection