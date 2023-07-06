@extends('dashboard.layout')

@section('title')
<h1>dashboard: Affihcage des "replies" d'un commentaire</h1>
@endsection


@section('content')
<ul>Comment for: {{ $owner->email }}, {{ $owner->username }} 
    <li> {{ $comment->content }} </li>
</ul>
<!-- form for new reply-message -->
<div>
    <form action="{{ url('/dashboard/post/comment/' . $comment->id) }}" method="post">
        @csrf
        <input type="hidden" name="id_post" value="{{ $comment->id_post }}">
        <input type="hidden" name="id_comment" value="{{ $comment->id }}">
        <textarea name="content" cols="30" rows="4" placeholder="Reply there"></textarea>
        <input type="submit" value="Send" name="reply">
    </form>
</div>
<!-- list of all the replies of this comment -->
<ul>
    @forelse($replies as $reply)
    <li>
        {{ $reply }} 
        <button>like</button><br>
        @if($reply->id_owner == session('user_session_data.id'))
            <form action="{{ url('/dashboard/post/comment') }}" method="post">
                @csrf
                @method('delete')
                <input type="hidden" name="id_reply" value="{{ $reply->id }}">
                <input type="submit" value="delete" name="reply">
            </form>
        @endif
    </li>
    @endforeach
</ul>
@endsection