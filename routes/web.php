<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\ProjectController;
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function() {

    Route::resource('projects', 'ProjectController',[
        'only' => [
            'index', 'store'
        ]
    ]);

    Route::get('project/{project}','ProjectController@show');

    Route::get('project/{project}/tasks', 'TaskController@create');
    Route::post('project/{project}/tasks/store', 'TaskController@store');
    Route::patch('project/{project}/tasks/update/{task}', 'TaskController@update');
    Route::patch('project/{project}/tasks/approve/{task}', 'TaskController@approve');
    Route::patch('project/{project}/tasks/cancel/{task}', 'TaskController@cancel');

    Route::get('project/{project}/members', 'ProjectController@showMembers');
    Route::patch('project/{project}/add/{user}', 'ProjectController@addMember');
    Route::patch('project/{project}/remove/{user}', 'ProjectController@removeMember');


});

Route::get('messages', 'ChatController@fetchMessages');
Route::post('messages', 'ChatController@sendMessage');
