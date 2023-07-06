<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Group;
use App\Models\GroupMembership;
use App\Models\GroupMessage;
use App\Models\User;


class GroupMembershipController extends Controller
{
    
    /* Membership management
    * store a new member on a group_membership
    * an member can be add only if it has already been registered on this plateforme an 
    */
    public function add_by_link($link){
        $groups = Group::all();
        

        foreach($groups as $group){
            if(
                hash('md2', $group['id']. $group['id_owner']) == $link
            ){
                $is_alreay_member = GroupMembership::where('id_group', $group['id'])->where('id_user', session('user_session_data.id'))->get();

                echo $is_alreay_member;
                if( empty($is_alreay_member[0])){ // if this user is not already a member, we create add him
                    GroupMembership::create([
                        'id_user' => session('user_session_data.id'),
                        'id_group' => $group['id']
                    ]);
                }else{ // else if it is already a member, we don't need to add him again
                }
            }
        }
    }
    // add a member by an link or his email
    public function add_member(Request $request, $id){
        $data = $request->input();
        $group = Group::find($id);
        
        if( isset($data['link']) ){ // join a group by his link: specialy there, $id=0
            GroupMembershipController::add_by_link($data['link']);
            $is_created = true;
            return redirect()->back()->with('statut', $is_created);
        }

        $user = User::where('email', $data['email'])->get();

        $is_created = false;

        if(!empty($user[0]) && session('user_session_data.id') == $group->id_owner ){ // if the email exists in the DB an is not on the Membership table
            $member = GroupMembership::where('id_group', $id)
            ->where('id_user', $user[0]['id'])
            ->get();
            if(empty($member[0])){
                GroupMembership::create([
                    'id_user' => $user[0]['id'],
                    'id_group' => $id
                ]);

                $is_created = true;
            }
        }

        return redirect()->back()->with('statut', $is_created);
    }


    //remove a member
    public function remove_member(Request $request, $id){
        $data = $request->input();

        GroupMembership::where('id_group', $id)->where('id_user', $data['id_member'])->delete();
        GroupMessage::where('id_group', $id)->where('id_owner', $data['id_member'])->delete();

        return redirect()->back();
    }
}