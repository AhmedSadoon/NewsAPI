<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorCommentsResource;
use App\Http\Resources\AuthorPostsResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;
use App\User;
use Illuminate\Http\Request;

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
        //
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
        //
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
}
