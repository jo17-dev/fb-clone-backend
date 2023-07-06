<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LikePost;
use App\Models\LikeComment;

// session_start();

class LikeController extends Controller
{
    // this method retreive the like number of one post from the db vai ajax
    public function likes_number(Request $request){
        $data = $request->input();

        $id_user = $data['id_user'];

        $id_post = $data['id_post'];

        $like = likePost::where('id_post', $id_post)->get();

        return response()->json([
            'likes_number' => count($like)
        ]);
    }

    public function like_post(Request $request){
        $data = $request->input();

        $id_user = $data['id_user'];

        $id_post = $data['id_post'];

        $like = likePost::where('id_owner', $id_user)->where('id_post', $id_post)->get();
        if( count($like) == 0 ){
            LikePost::create([
                'id_owner' => $id_user,
                'id_post' => $id_post
            ]);
            $liked = true;
        }else{
            // if the user has already liked, we just dislike it
            likePost::where('id_owner', $id_user)->where('id_post', $id_post)->delete();
            $liked = false;
        }

        return response()->json([
            'likes_number' => count(likePost::where('id_post', $id_post)->get()),
            'liked' => $liked
        ]);
    }

    /**
     * This function is done as part to retreive a likes nmuber for each comment and
     * Do the like/dislike process
     */
    public function like_comment(Request $request){
        $data = $request->input();

        $id_user = $data['id_user'];

        $id_comment = $data['id_comment'];

        // If we just want to retreive the likes numbers (at the start), we do this:
        if( isset($data['retreive_likes']) ){

            $like = LikeComment::where('id_owner', $id_user)->where('id_comment', $id_comment)->get();

            return response()->json([
                'likes_number' => count($like)
            ]);
        }
    // Else, we test if we should like or dislike the current comment
        
        $like = LikeComment::where('id_owner', $id_user)->where('id_comment', $id_comment)->get();
        $like_number = 0; // there is a variable who will content the final like number

        if( count($like) == 0 ){
            LikeComment::create([
                'id_owner' => $id_user,
                'id_comment' => $id_comment
            ]);
            $liked = true;

            $like_number = count($like) + 1;
        }else{
            // if the user had already liked, we just dislike it
            LikeComment::where('id_owner', $id_user)->where('id_comment', $id_comment)->delete();
            $liked = false;
            $like_number = count($like) - 1;
        }

        return response()->json([
            'likes_number' => $like_number,
            'liked' => $request->input()
        ]);
    }
}
