<?php

use App\Http\Controllers\Api\CategoriesController;
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


// All Routes / Api here must be api authenticated

Route::group(['middleware' => ['api' , 'checkPassword' , 'ChangeLanguage'] , 'namespace'=> 'Api'], function (){

    Route::post('get-main-categories' , 'CategoriesController@index');
    Route::post('get-category-byId' , 'CategoriesController@getCategoryById');
    Route::post('change-category-status' , 'CategoriesController@changeStatus');


    Route::group(['prefix'=>'admin' , 'namespace'=> 'Admin'],function (){

        Route::post('login' , 'AuthController@login');
        Route::post('logout' , 'AuthController@logout')->middleware(['assignGuard:admin-api']); // #13

    });

    Route::group(['prefix'=>'user' ,  'middleware'=>'assignGuard:user-api'],function (){

        Route::post('profile' , function (){
            return 'Only authenticated user can reach me';
        });
    });
});



Route::group(['middleware' => ['api' , 'checkPassword' , 'ChangeLanguage' , 'checkAdminToken:admin-api'] , 'namespace'=> 'Api'], function (){

    Route::get('offers' , 'CategoriesController@index');

});
