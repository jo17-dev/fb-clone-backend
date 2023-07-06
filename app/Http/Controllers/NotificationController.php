<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index(){

        $notifications= Notification::where('notifications.id_receiver', session('user_session_data.id'))
                        ->join('users',
                            'notifications.id_sender', '=', 'users.id'
                        )->get(['notifications.id', 'users.username', 'users.email' , 'notifications.type']);

        return view('notification.notification-center', [
            'notifications' => $notifications
        ]);
    }   

    public function destroy(Request $request){
        $data = $request->all();
        $id = $data['id'];
        Notification::find($id)->delete();
        return redirect()->back();
    }
}
