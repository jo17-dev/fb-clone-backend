<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Discution;
use App\Models\Message;
use App\Models\Notification;
session_start();

class DiscutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * as i can't take all the discussion data at the same request, i've done like that:
         * To take all the discutsion involved by one users:
         * We begin to retrieve all the users an the discuss id where this user is considerated as a second member,
         * We do the same where the user is considerated as a first memnber.
         * We joinr all the two result
         * 
         */
        $first_part = Discution::join('users',
            'discutions.first_user', '=', 'users.id'
            )->where('discutions.second_user', session('user_session_data.id'))
            ->get(['users.username', 'users.email', 'discutions.id', 'discutions.is_locked']);

        $second_part = Discution::join('users',
        'discutions.second_user', '=', 'users.id'
        )->where('discutions.first_user', session('user_session_data.id'))
        ->get(['users.username', 'users.email', 'discutions.id', 'discutions.is_locked']);

        //  A la place de ces deux requettes on vas use une jointure qui utilise deux criteres differents

        $discutions = array();

        foreach($first_part as $first){
            array_push($discutions, $first);
        }
        foreach($second_part as $second){
            array_push($discutions, $second);
        }

        return view('discution.index', [
            'discutions' => $discutions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * update all the unreads messages
     * Display the specified discution's messages
     *
     * at the last, we delete all the notifications linked with this discution
     */
    public function show($id)
    {   
        // Firstly, if the dicution is locked, we just return back
        $is_locked = Discution::find($id);
        if( $is_locked['is_locked'] != 0 ){ 
            return redirect()->back();
        }

        Message::where('id_discution', $id)
            ->where('id_owner', '!=' ,session('user_session_data.id'))
            ->update([
                'is_read' => true
            ]);

        $messages = Message::join('users',
            'users.id', '=', 'messages.id_owner')
        ->where('id_discution', $id)->get(['users.username', 'messages.*']);


    /* Here whe try to retreive the other user_id form the discutions table and
    * use it to delete some notifications
    *  if on the discution table, the first user is me, the other will be the second, inversely
    */
        $id_sender = Discution::where('id', $id)->get();

        if( $id_sender[0]['first_user'] == session('user_session_data.id') ){
            $id_sender = $id_sender[0]['second_user'];
        }else{
            $id_sender = $id_sender[0]['first_user'];
        }

        Notification::where('id_receiver', session('user_session_data.id'))
        ->where('type', 'inbox_message')
        ->where('id_sender', $id_sender)->delete();

        return view('discution.show-messages', [
            'messages' => $messages
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage 
     *
     */
    public function update(Request $request, $id)
    {
        $data = $request->input();

        $discution = Discution::find($id);


        if($discution['is_locked'] == 0){ // if the discution is not already blocked, we block it
            if($discution['first_user'] == session('user_session_data.id') || $discution['second_user'] == session('user_session_data.id') ){
                Discution::where('id', $id)->update([
                    'is_locked' => session('user_session_data.id')
                ]);
            }
        
    //  else if the discution is already locked, we unlock it only if it is the cureent user who have locked it ("is_locked" value os equal to the current user id)
        }else if($discution['is_locked'] == session('user_session_data.id')){
            Discution::where('id', $id)->update([
                'is_locked' => 0
            ]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Discution::find($id)->delete();
    }

    public function toggleBlock(Request $request){
        return response::json([
            'is_blocked' => "success"
        ]);
    }
}
