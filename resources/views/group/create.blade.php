@extends('group.layout')

@section('title')
<small>Create group form</small>
@endsection

@section('content')
<div>
    <a href="{{ url('/group') }}">groups</a><br>
    <form action="{{ url('/group') }}" method="post">
        @csrf
        <div>
            <input type="text" name="title" id="title" placeholder="Enter the group title">
        </div>
        <div>
            <textarea name="description" id="description" cols="40" rows="4" placeholder="What about this group ?"></textarea>
        </div>
        <div>
            <label for="is_private">Type of group</label>
            <select name="is_private" id="is_private">
                <option value="1">private group</option>
                <option value="0">public group</option>
            </select>
        </div>
        <div>
            <input type="submit" value="Create">
        </div>
    </form>
</div>
@endsection