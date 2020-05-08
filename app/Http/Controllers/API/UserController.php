<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorCommentsResource;
use App\Http\Resources\AuthorPostsResource;
use App\Http\Resources\TokenResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=User::paginate(env('AUTHORS_PER_PAGE'));
        return new UsersResource($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required'
        ]);

            $user=new User();
            $user->name=$request->get('name');
            $user->email=$request->get('email');
            $user->password=Hash::make($request->get('password'));

            $user->save();
            return new UserResource($user);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // $user=User::find($id);
        // return $user->api_token;
        return new UserResource(User::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user=User::find($id);

        if($request->has('name')){
            $user->name=$request->get('name');
        }

        if($request->has('avatar')){
            $user->avatar=$request->get('avatar');

        }


        //خطأ
        if($request->hasFile('avatar')){

            $avatar=$request->file('avatar');
            $fileName=time().$avatar->getClientOriginalName();

            $path=base_path().'/public/images'.$fileName;
            Storage::disk('images')->putFileAs(
                $fileName,
                $avatar,
                $fileName
            );

            $user->avatar=url('/').'/images/'.$fileName;

        }



        $user->save();
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $id
     * @param AuthorPostsResource
     */

    public function posts($id){

        $user=User::find($id);
        $posts=$user->posts()->paginate(env('POST_PER_PAGE'));
        return new AuthorPostsResource($posts);



    }

    /**
     * @param $id
     * @param AuthorCommentsResource
     */

    public function comments($id){

        $user=User::find($id);
        $comment=$user->comments()->paginate(env('COMMENT_PER_PAGE'));
        return new AuthorCommentsResource($comment);

    }

    public function getToken(Request $request)
    {
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        $credentials=$request->only('email','password');

        if(Auth::attempt($credentials)){
            $user=User::where('email', $request->get('email'))->first();
            return new TokenResource(['token'=>$user->api_token]);
        }

        return 'not found';
    }
}




