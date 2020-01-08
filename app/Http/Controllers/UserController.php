<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    /**
     * Paginate the authenticated user's tasks.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // paginate the authorized user's tasks with 5 per page
        $users = User::all();

        // return task index view with paginated tasks
        return view('users', [
            'users' => $users
        ]);
    }


}
