@extends('group.layout')

@section('title')
<small>Edit group form</small>
@endsection

@section('content')
<div>
    <a href="{{ url('/group') }}">groups</a><br>
    <form action="{{ url('/group/'. $group->id) }}" method="post">
        @method('patch')
        @csrf
        <div>
            <input type="text" name="title" id="title" value="{{ $group->title }}">
        </div>
        <div>
            <textarea name="description" id="description" cols="40" rows="4" value="{{ $group->description }}"></textarea>
        </div>
        <div>
            <label for="is_private">Type of group</label>
            <!-- here we try to display the "privacy" group as default -->
            <select name="is_private" id="is_private">
                @if($group->is_private == 0)
                    <option value="0">public group</option>
                    <option value="1">private group</option>
                @else
                    <option value="1">private group</option>
                    <option value="0">public group</option>
                @endif
            </select>
        </div>
        <div>
            <input type="submit" value="Update">
        </div>
    </form>
</div>
@endsection