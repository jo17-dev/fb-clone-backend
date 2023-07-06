<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Discution;
use App\Models\Notification;

use App\Http\Requests\MessageRequest;
session_start();

class MessageController extends Controller
{
    // store a new message on a database
    /**
     * first we search the receiver id
     * we retreive the form data and store the message
     * we create his notification
     */
    public function store(MessageRequest $request, $id_discution){
        $data = $request->all();

        $id_notification_receiver = Discution::find($id_discution);
        if($id_notification_receiver['second_user'] == session('user_session_data.id') ){
            $id_receiver = $id_notification_receiver['first_user'];
        }else{
            $id_receiver = $id_notification_receiver['second_user'];
        }


        Message::create([
            'id_owner' => session('user_session_data.id') ,
            'id_discution' => $id_discution ,
            'content' => $data['content']
        ]);

        Notification::create([
            'id_sender' => session('user_session_data.id'),
            'id_receiver' => $id_receiver,
            'type' => 'inbox_message'
        ]);

        return redirect()->back();
    }

    // delete a message form the database

    public function destroy($id_message){
        Message::find($id_message)->delete();
        // Notification::where('id_sender', session('user_session_data.id'))
        //             ->where('type', 'inbox_message'),
        //             ->where()

        return redirect()->back();
    }
}
