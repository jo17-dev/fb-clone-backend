@extends('dashboard.layout')

@section('title')
<h1>dashboard: Affichage des posts</h1>
@endsection

@section('content')
<a href="{{ url('/home') }}">Home</a>
<br>
<a href="{{ url('/home/user') }}">my account</a>
<br>
<a href="{{ url('/discution') }}">messages</a>
<br>
<a href="{{ url('/group') }}"><button>groups</button></a><br>

<!-- search some users to make a friendship -->
<div id="friendship-form">
    <input type="text" name="userSearch" id="userSearch" placeholder="Type an name There">
    <button id="search-btn">Search</button>
    <!-- here is displayed the list of the result of the searched users -->
    <ul id="result">
    </ul>
</div>

<h2>Affichage des posts</h2><br>
    @if( isset($error) )
    <p> {{ $error }} </p>
    @endif
    <form action="{{ url('/dashboard/') }}" method="post">
        @csrf
        <textarea name="content" id="content" cols="50" rows="5" placeholder="How do you feel now ?"></textarea>
        <input type="submit" value="Post">
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
            @foreach($posts as $post)
            <tr>
                <td> {{ $loop->iteration }} </td>
                <td> {{ $post->username }} </td>
                <td> {{ $post->content }}</td>
                <td>
                    <button class="like-btn" value="{{ $post->id }}" >like</button>
                    <a href="{{ url('/dashboard/'. $post->id) }}"><button>Comment</button></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <br>
<script src="{{ asset('/js/ajax/like.js') }}"></script>
<script src="{{ asset('/js/ajax/friendships/friendship.js') }}"></script>
@endsection