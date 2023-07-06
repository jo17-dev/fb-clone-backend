<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\models\Comment;
use App\models\LikePost;
use App\models\LikeComment;
use App\models\Friend;
session_start();
// This is the principal controller
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = post::all()->sortByDesc('created_at');
        $posts = Post::join('users',
            'posts.id_owner', '=', 'users.id'
        )
        ->get(['posts.*', 'users.username'])
        ->sortByDesc('created_at');

        // Le nbre de likes seras affiché et modifié en AJAX

        return view('dashboard.dashboard', [
            'posts' => $posts
        ]);
    }
    /**
     * Store a new post
     */
    public function store(Request $request)
    {
        $post = $request->all();
        $content = htmlspecialchars($post['content']);

        $id_owner = session('user_session_data.id');
        if( strlen($content) >255 ){
            return redirect('/dashboard')->with("error", "Unsuccessfull The comment was too long: the max is 255 caracters");
        }
        echo session('user_session_data.id');
        echo session('user_session_data.username');
        Post::create([
            'id_owner' => $id_owner,
            'content' => $content
        ]);

        return redirect('/dashboard');
    }

    /**
     * Display the specified post or the user account
     */
    public function show($id)
    {   
        $post = Post::find($id);
        if( Post::find($id) ){ // here is used when we want to diplay an particular post an his comments

            $comments = Comment::join('users', 
                'users.id', '=', 'comments.id_owner'
            )
            ->where('id_post', $id)->get(['users.email', 'comments.*']);

            // foreach($comments as $comment){
                // $like = count(LikeComment::where('id_comment', $comment['id'])->get());

                // $comment.push('likes_number' , $like );

                // array_push($comment, "likes_number => $like ");
            // }

            return view('dashboard.show-post', [
                'post' => $post,
                'owner' => User::find($post['id_owner']),
                'comments' => $comments
            ]);
        }else{ // else if the parameter is 'myaccount', we return all this users posts and his informations
            $friends = [];

            $post = Post::where(
                'id_owner', session('user_session_data.id')
                )->get();

            $first_friend = Friend::join('users',
                'friendships.first', '=', 'users.id'
                )->where('second', session('user_session_data.id'))
                ->get(['friendships.id', 'users.username', 'users.email']);
            
            $second_friend = Friend::join('users',
                'friendships.second', '=', 'users.id'
                )->where('friendships.first', session('user_session_data.id'))
                ->get(['friendships.id', 'users.username', 'users.email']);

            foreach($first_friend as $item){
                array_push($friends,  $item);
            }

            foreach($second_friend as $item){
                array_push($friends, $item);
            }

            $friends_number = count($first_friend) + count($second_friend);
            return view('dashboard.myaccount', [
            'my_post' => $post,
            'friends_number' => $friends_number,
            'friends' => $friends
            ]);
        }
    }

    /**
     * Delete an post from his owner
     * Here we just delete de correspondant post and redirect the user to the previous page
     * we will delete the post, the comments, and the likes
     */
    public function destroy($id)
    {
        try{
            Post::find($id)->delete();
            $post = Post::where(
                'id_owner', session('user_session_data.id')
                )->get();

            Comment::where('id_post', $id)->delete();
        }catch(Exception $e){
            return redirect()->back();
        }
        return redirect()->back()->with('my_post', $post);
    }
}