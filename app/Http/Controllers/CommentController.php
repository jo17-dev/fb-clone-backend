<?php
// NB: This controller create an delete the comments an the replies on this app
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use App\Models\Reply;

session_start();

class CommentController extends Controller
{

    // show the form for create a reply & other replies for this comment
    public function reply_form($id_comment){
        $comment = Comment::find($id_comment); // the principal comment
        $owner_infos = User::find($comment['id_owner']);

    // here we take the replies associated with his user's informations
        $replies = Reply::join('users',
            'users.id', '=', 'replies.id_owner'
        )->where('id_comment', $id_comment)->get(['users.email', 'replies.*']);

        return view('dashboard.reply-comment', [
            'comment' => $comment,
            'owner' => $owner_infos,
            'replies' => $replies
        ]);
    }

    // add a new comment on a post
    public function store(Request $request){
        $data = $request->all();
        $id_owner = session('user_session_data.id');
        $id_post = $data['id_post'];
        $content = htmlspecialchars($data['content']);



        if( isset($data['reply']) ){

            Reply::create([
                "id_comment" => $data['id_comment'],
                "id_owner" => $id_owner,
                "content" => $content
            ]);
        }else{
            Comment::create([
                "id_owner" => $id_owner,
                "id_post" => $id_post,
                "content" => $content,
                'is_reply' => false
            ]);
        }

        return redirect()->back();
    }

    // delete one of our commments. an comment is deleted with his replies. an reply is deleted alone
    public function destroy(Request $request){
        $data = $request->all();
        
        if( isset($data["reply"]) ){
            Reply::find($data['id_reply'])->delete(); // delete the specified comment
        }else{
            Comment::find($data['id_comment'])->delete(); // delete the specified comment
    
            Reply::where('id_comment', $data['id_comment'])->delete(); // delete his replies
        }

        
        return redirect()->back();
    }
}