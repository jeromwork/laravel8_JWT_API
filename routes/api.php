<?php

use App\Http\Controllers\UserController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });




Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', [ 'as' => 'login', 'uses' => 'AuthController@login']);
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('user/{id}', 'UserController@getUser');
    Route::get('/user', [UserController::class, 'getUsers']);
//    Route::get('user/{id}', [UserController::class, 'getUser']);
});

Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::get('user-profile', 'AuthController@userProfile');
    Route::post('get-access-rules', function(){
       return [
           'mainMenuItems' => [ 'main' => 1, 'DoctorSettings' => 1, 'HealthSettings' => 1 ],
           'ETable_specials' => [ 'id' => 'id', 'name' => 'name', 'iid' => 'iid', 'off' => 'off', 'services' => 'services' ],
           'healthSpecialsSettings' => [ 'id' => 'id', 'name' => 'name', 'iid' => 'iid', 'off' => 'off', 'services' => 'services' ],
           'healthSpecialsEditFields' => [ 'id' => 'id', 'name' => 'name', 'iid' => 'iid', 'off' => 'off', 'services' => 'services' ],

       ];
    });


    Route::post('articles', 'ArticleController@index');
    Route::get('articles/{article}', 'ArticleController@show');
    Route::post('articles', 'ArticleController@store');
    Route::put('articles/{article}', 'ArticleController@update');
    Route::delete('articles/{article}', 'ArticleController@delete');

    Route::get('search/health', 'SearchHealthController@search');

});





