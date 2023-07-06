@extends('dashboard.layout')

@section('title')
<h1>dashboard: Affihcage d'un post et de ses commentaires</h1>
@endsection

@section('content')
<div>
    <ul>
        <li>post id:  {{ $post->id }} </li>
        <li>owner:  {{ $owner->username }}, email: {{ $owner->email }} </li>
        <li>post content: {{ $post->content }} </li>
    </ul>
</div>
<div>
    <!-- comments space -->
    <h3>Comments</h3>
    <ul>
        @forelse($comments as $comment)
            <li>
                {{ $comment }}<br>
                <button class="like-btn" value="{{ $comment->id  }}" >like</button><br>
                <a href="{{ url('/dashboard/post/comment/' . $comment->id . '/') }}"><button>reply</button></a>
            </li>
            @if($comment->id_owner == session('user_session_data.id'))
                <form action="{{ url('/dashboard/post/comment') }}" method="post">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="id_comment" value="{{ $comment->id }}">
                    <input type="hidden" name="id_post" value="{{ $comment->id_post }}">
                    <input type="submit" value="delete" name="delete_comment">
                </form>
            @endif
        @endforeach
    </ul>
</div>
<div>
    <!-- comment form -->
    <form action="{{ url('/dashboard/post/comment') }}" method="post">
        @csrf
        <input type="hidden" name="id_post" value="{{ $post->id }}">
        <textarea name="content" id="content" cols="50" rows="4" placeholder="What do you thing about this post ?"></textarea>
        <input type="submit" value="Send" name="new_comment">
    </form>
</div>

<script src="{{ asset('/js/ajax/likeComment.js') }}"></script>
@endsection