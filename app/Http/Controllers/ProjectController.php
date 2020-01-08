<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
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
        $projects = Auth::user()
            ->projects()
            ->orderByDesc('created_at')
            ->paginate(5);

        // return task index view with paginated tasks
        return view('projects', [
            'projects' => $projects
        ]);
    }

    /**
     * Store a new incomplete task for the authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // validate the given request
        $data = $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        // create a new project with the given title
        $project = Auth::user()->projects()->create([
            'title' => $data['title'],
            'description' => $data['description'],
        ]);

        $project->users()->attach(Auth::id());

        // flash a success message to the session
        session()->flash('status', 'Project Created!');

        // redirect to projects index
        return redirect('/projects');
    }
}
