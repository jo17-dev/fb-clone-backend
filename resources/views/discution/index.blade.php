@extends('discution.layout')

@section('title')
    Affichage la liste de toutes les discutions
@endsection

@section('content')
    <table>
        <thead>
            <tr>
                <td>#</td>
                <td>username</td>
                <td>email</td>
                <td>Actions</td>
                <td>Statut</td>
            </tr>
        </thead>
        <tbody>
        @forelse($discutions as $discution)
            <tr>
                <td> {{ $loop->iteration }} </td>
                <td> {{ $discution->username }} </td>
                <td> {{ $discution->email }} </td>
                <td>
                    <a href="{{ url('/discution/'. $discution->id) }}"><button>discus</button></a>
                    <!-- <button onclick="toogleBlock({{ $discution->id }})" >block/unblock</button> -->
                    <form action="{{ url('/discution/'. $discution->id) }}" method="post">
                        @csrf
                        @method('put')
                        <input type="submit" value="block/unblock">
                    </form>
                </td>
                <td>
                    @if($discution->is_locked == 0 )
                        unlocked
                    @else
                        <strong>locked</strong>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection