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
use Illuminate\Routing\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function() {

    Route::resource('tasks', 'TaskController', [
        'only' => [
            'index', 'store', 'update'
        ]
    ]);

    Route::resource('projects', 'ProjectController',[
        'only' => [
            'index', 'store'
        ]
    ]);
    Route::get('project/{project}/members', 'ProjectController@show');
    Route::patch('project/{project}/add/{user}', 'ProjectController@addMember');
    Route::patch('project/{project}/remove/{user}', 'ProjectController@removeMember');
});
