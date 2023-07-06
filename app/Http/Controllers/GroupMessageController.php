<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupMessage;

session_start();
class GroupMessageController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'content' => 'required|max:255'
        ]);

        $data = $request->input();

        GroupMessage::create([
            'id_group' => $data['id_group'],
            'id_owner' => session('user_session_data.id'),
            'content' => $data['content']
        ]);

        return redirect()->back();
    }

    public function destroy($id_message){
        GroupMessage::find($id_message)->delete();
        return redirect()->back();
    }
}   