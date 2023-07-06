@extends('group.layout')

@section('title')
<small>Show all the users groups</small>
@endsection

@section('content')
<div>
    <!-- this form is not working for the moment: this will add the user to an group by an group link; the route is also invalid for the moment -->
    <!-- after, the user will be redirected ar this group messages view -->
    <form action="{{ url('/group/0/edit') }}" method="post">
        @csrf
        <input type="text" name="link" id="link" placeholder="paste an valid group link to join it" required>
        <input type="submit" value="Join">
    </form><br>

    <!-- rechercher un group group  -->
    <div>
        <input type="text" name="group_name" id="group_name" placeholder="search an public group here">
        <button>search</button>
    </div>
    <h2>My groups</h2>

    <table>
        <thead>
            <tr>
                <td>#</td>
                <td>title</td>
                <td>description</td>
                <td>statut</td>
                <td>action</td>
            </tr>
        </thead>
        <tbody>
            @forelse($groups as $group)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td> {{ $group->title }} </td>
                <td> {{ $group->description }} </td>
                <td> {{ $group->is_private }} </td>
                <td>
                    <a href="{{ url('/group/'. $group->id) }}"><button>view</button></a>
                    <a href="{{ url('group/' .$group->id .'/edit') }}"><button>edit</button></a>
                    <form action="{{ url('/group/'. $group->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="submit" value="delete">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</div>


@endsection