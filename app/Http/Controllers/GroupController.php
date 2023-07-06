<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\GroupMessage;
use App\Models\GroupMembership;
use App\Models\User;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = GroupMembership::join('groups',
            'group_memberships.id_group', '=', 'groups.id'
        )->where('group_memberships.id_user', session('user_session_data.id'))
        ->get(['groups.*']);

        $all_groups = Group::all(); // this will be use if the user search an public group

        return view('group.index',[
            'groups' => $groups
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('group.create');
    }

    /**
     * Store a newly created resource in storage.
     *Here we create a group an fill the "participant" table by the group owner
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:4|max:80',
            'description' => 'max:250'
        ]);

        $data = $request->input();

        $group = Group::create([
            'id_owner' => session('user_session_data.id'),
            'title' => $data['title'],
            'description' => $data['description'],
            'is_private' => $data['is_private']
        ]);

        GroupMembership::create([
            'id_user' => session('user_session_data.id'),
            'id_group' => $group->id
        ]);

        return redirect()->route('group.index')->with('groups', Group::all());

    }

    /**
     * Display the specified group.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $messages = GroupMessage::join('users',
        'users.id', '=', 'group_messages.id_owner'
        )->where('id_group', $id)
         ->get(['users.username', 'group_messages.*']);

        $members = GroupMembership::where('id_group', $id)->count();

        return view('group.show.show-group-messages',[
            'group' => Group::find($id),
            'messages' => $messages,
            'id_group' => $id,
            'members' => $members
        ]);
    }

    /**
     * Show the form for editing an group.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('group.edit', [
            'group' => Group::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:4|max:80',
            'description' => 'max:250'
        ]);

        $data = $request->input();

        Group::find($id)->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'is_private' => $data['is_private']
        ]);

        return redirect()->route('group.index')->with('groups', Group::all());
    }

    /**
     * Remove the specified resource from storage.
     *we also remove the messages and the members
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::find($id);

        $is_done = false;

        if($group['id_owner'] == session('user_session_data.id')){
            GroupMessage::where('id_group', $id)->delete();
            GroupMembership::where('id_group', $id)->delete();
    
            Group::find($id)->delete();

            $is_done =true;
        }else{
            GroupMembership::where('id_group', $id)->where('id_user', session('user_session_data.id'))->delete();
        }

        return redirect()->back()->with('statut', $is_done);
    }

    //  show thr group parameters
    public function show_group_info($id){

        $members = GroupMembership::join('users',
            'users.id', '=', 'group_memberships.id_user'
        )->where('id_group', $id)->get(['users.id', 'users.username', 'users.email']);

        return view('group.show.show-group-parameters', [
            'members' => $members,
            'group' => Group::find($id)
        ]);
    }


}