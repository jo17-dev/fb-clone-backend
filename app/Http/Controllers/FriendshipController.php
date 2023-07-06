<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Friend;
use App\Models\Notification;
use App\Models\Discution;


session_start();


class FriendshipController extends Controller
{
// this controller is called by an api route (with Ajax)

    public function search_users(Request $request){
// here will be developed the "search engine" by the eloquent regexp for the moment
// This thign will be updated at the future times
        $users = User::get(['id', 'username', 'email']);
        $data = $request->input();
        $result = [];

        $senderId = $data['senderId'];
        foreach($users as $user){
            // if the curent user is matching the input, we add it to the final respone
            if( FriendshipController::search_engine($user['username'], $data['username'])){

                // the current users are already infriendhip or not, we indicate it on the result as "is_friend"
                if(
                    count(Friend::where('first', $senderId)->where('second', $user['id'])->get())
                    + 
                    count(Friend::where('second', $senderId)->where('first', $user['id'])->get()) == 0
                ){
                    array_push($result, [
                        'id' => $user['id'],
                        "username" => $user['username'],
                        'email' => $user['email'],
                        'is_friend' => false
                    ]);
                }else{
                    array_push($result, [
                        'id' => $user['id'],
                        "username" => $user['username'],
                        'email' => $user['email'],
                        'is_friend' => true
                    ]);
                }

            }
        }
        return response()->json([
            'users' => $result
        ]);
    }

    // this function return true the current data match with the input
    public function search_engine($db_data, $input_data){

        $db_data = strtolower($db_data);
        $input_data = strtolower($input_data);

        return $db_data == $input_data;
    }

    // friendsihip invitation management

    public function invite_user($receiverId, $senderId){
        Notification::create([
            'id_sender' => $senderId,
            'id_receiver' => $receiverId ,
            'type' => 'friendship'
        ]);

        return response()->json([
            'notification_sended' => true
        ]);
    }

    // this function is done accept or not an friendship invitation
    public function accept_or_reject_friendship_invitation(Request $request){
        $data = $request->input();

        $notification = Notification::find($data['id_notification']);
        $id_current_user = $notification['id_receiver']; // only person who "use" this method is a receiver of this notification
        $id_target_user = $notification['id_sender'];

        $are_already_friends = count(Friend::where('first', $id_target_user)->where('second', $id_current_user)->get())
                                + count(Friend::where('second', $id_target_user)->where('first', $id_current_user)->get());

    // if the user has click on the accept btn and is not already a friend
        if($data['decision'] == "accept" && $are_already_friends == 0 ){ 
        // we create the friendships, notify the user who request this friendships and create a "discution"
            Friend::create([
                'first' => $id_target_user,
                'second' => $id_current_user
            ]);

            Discution::create([
                'first_user' => $id_target_user,
                'second_user' => $id_current_user
            ]);

            Notification::create([
                'id_sender' => $id_current_user,
                'id_receiver' => $id_target_user,
                'type' => 'friendship_accepted'
            ]);
        }else if($data['decision'] == "reject") {
            Notification::create([
                'id_sender' => $id_current_user,
                'id_receiver' => $id_target_user,
                'type' => 'friendship_rejected'
            ]);
        }
        // at the end, we delete a notification
        Notification::find($data['id_notification'])->delete();

        return response()->json([
            'done' => true
        ]);
    }

    /** Destroy an frienship (By clicking on remove button) ; here, we'll
     * remove this friendship entry
     * create a notification for the target user
     */
    public function destroy($id, $target){ // target means the id of the current user
        $friend = Friend::find($id);

        $id_current_user = $target;
        $id_friendship = $id;

        if($friend['first'] == $id_current_user){
            $id_target_user = $friend['second'];
        }else if($friend['second'] == $id_current_user){
            $id_target_user = $friend['first'];
        }else{
            return redirect()->back()->with('flash_message', 'an error occured');
        }

        Notification::create([
            'id_sender' => $id_current_user,
            'id_receiver' => $id_target_user,
            'type' => 'friendship_removed'
        ]);

        Friend::find($id)->delete();
        
        return redirect()->back()->with('flash_message', 'done sucessfully');
    }

}