<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
session_start();
class UserController extends Controller
{
    //  form for "log-in" an user
    public function index(){
        return view('acceuil.login');
    }

    /**
     * Show the form for add a new user
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('acceuil.register');
    }

    /**
     * create or "login" an user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserLoginRequest $request)
    {
        $data = $request->all();
        // case of the regitering
        if( isset($data["register"]) ){
            $all_is_correct = false;
            $other_error = array();
            // here we do the complementary validation for registering
            if(
                ($data["password"] == $data["confirm_password"])
                 && strlen($data["password"]) >=4
                 && !filter_var($data["username"], FILTER_VALIDATE_REGEXP, ["options"=> ["regexp"=> "/[a-z]*[0-9]*/i"]]) === false
            ){
                $all_is_correct = true;
            }else{
                if(strlen($data["password"]) < 4){
                    array_push($other_error, "The lenght oh the password must be at least 4 characters");
                }
                if($data["password"] != $data["confirm_password"]){
                    array_push($other_error, "The password confirmation does not match");
                }
                if(filter_var($data["username"], FILTER_VALIDATE_REGEXP, ["options"=> ["regexp"=> "/[a-z][0-9]/i"]])){
                    array_push($other_error, "The isn't filled corectly");
                }
                return view('acceuil.register', ['other_error' => $other_error]);
            }

            // here we complete the operation complete
            if( $all_is_correct == true ){
                $username = htmlspecialchars($data["username"]);
                $born_day = htmlspecialchars($data["born_day"]);
                $email = htmlspecialchars($data["email"]);
                $password = hash("md2", $data["password"] );

                // the email must be unique for each account
                $db_user = User::where('email' , $email)->get();
                if( !empty($db_user[0]) ){
                    return redirect()->back()->with('other_error', "You can\'t use the same email to have two account. check login page");
                }

                // Additionnal verifications
                if(!empty($_SESSION['user_session_data'] ) ){
                    return redirect()->back()->with('other_error', "You are already connected. check dashboard page");
                }

                $new_user = User::create([
                    'username' => $username, 
                        'email' =>$email,
                        'born_day' =>$born_day, 
                        'password' =>$password
                    ]);

                $new_user->save();
                $db_user = User::where('email' , $email)->get();
                    
                session([
                    'user_session_data' => [
                        'id' => $db_user[0]['id'],
                        'email' => $email,
                        'born_day' =>$born_day, 
                        'password' =>$password
                    ]
                ]);
                return redirect('/dashboard', 302);
            }
        }

        // case of the LOGIN
        // on there, all the fields will be verified on the UserLoginRequest

        if( isset($data["login"])  ){
            // the user is already connected...
            if( !empty( session('user_session_data') ) ){
                return redirect('/dashboard', 302);
            }

            $email = htmlspecialchars($data["email"]);
            $password = hash("md2", $data["password"] );
        // Here we do the login operation properly
            $user = User::where('email', $email)->get();

            if( isset( $user[0]['id'] ) ){
                if($user[0]['password'] == $password ){
                    Session([
                        'user_session_data'=>               [
                            'id' => $user[0]['id'],
                            'username' => $user[0]['username'],
                            'email' => $user[0]['email'],
                            'born_day' => $user[0]['born_day']
                        ]
                    ]);
                    return redirect('/dashboard', 301);
                }
            }else{
                return redirect()->back()->with('other_error', "You  probably not have an account. check the register page");
            }

            
        }

        return redirect()->back()->with('other_error', "An error occured");
    }

    /**
     * My profil option show
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect ('/dashboard/myaccount', 302);
        // cf: postController::show
    }

    /**
     * Edit my profil form
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect('/dashboard/myaccount/edit', 302);
    }

    /**
     * Update something on myprofil
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request_data = $request->all();
        // these are the form data
        $username = htmlspecialchars($request_data['username']);
        $email = htmlspecialchars($request_data['email']);
        $born_day = htmlspecialchars($request_data['born_day']);
        $password = hash('md2', $request_data['password']);

        // this is the user Db user's infos
        $user_id = session('user_session_data.id');
        $db_user = User::find($user_id);
        $user_id = session('user_session_data.id');

        if($request_data['password'] == $request_data['confirm_password'] && $password != $db_user['password'] && !empty($request_data['password'])){
            User::find($user_id)->update([
                'username' => $username,
                'email' => $email,
                'born_day' => $born_day,
                'password' => $password
            ]);
        }else if(empty($request_data['password'])){
            User::find($user_id)->update([
                'username' => $username,
                'email' => $email,
                'born_day' => $born_day
            ]);
        }else{
            return redirect('/dashboard/myaccount')->with('other_error', "An error occured");
        }

        session([
            'user_session_data' =>[
                'username' =>$username,
                'email' => $email,
                'born_day' => $born_day
            ]
        ]);

        return redirect('/dashboard/myaccount', 302);
    }

    /**
     * Delete an account
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // an account is deleted with his posts, comments, replies, user replies.
        $user = User::find(session('user_session_data.id'));
        \App\Models\Post::where('id_owner', session('user_session_data.id'))->delete();
        // we 'll also delete the comments of this user's post
        \App\Models\Comment::where('id_owner', session('user_session_data.id'))->delete();
        \App\Models\Discution::where('first_user', session('user_session_data.id'))->delete();
        \App\Models\Discution::where('second_user', session('user_session_data.id'))->delete();
        \App\Models\Group::where('id_owner', session('user_session_data.id'))->delete();

        $user->delete();

        return redirect('/disconnect');
    }
}
