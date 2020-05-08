<?php

use App\Http\Resources\UsersResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * @User Related
 */

Route::get('authors', 'API\UserController@index');
Route::get('author/{id}','API\UserController@show');
Route::get('posts/author/{id}','API\UserController@posts' );
Route::get('comments/author/{id}','API\UserController@comments' );

//end User Related

/**
 * @Post Related
 */

Route::get('categories','API\CategoryController@index');
Route::get('posts/categories/{id}','API\CategoryController@posts');
Route::get('posts','API\PostController@index');
Route::get('posts/{id}','API\PostController@show');
Route::get('comments/posts/{id}','API\PostController@comments');

 //end post related


 Route::post('register', 'API\UserController@store');
 Route::post('token', 'API\UserController@getToken');

 Route::middleware('auth:api')->group(
     function(){
         Route::post('update-user/{id}', 'API\UserController@update');
         Route::post('posts', 'API\PostController@store');

     }
 );


