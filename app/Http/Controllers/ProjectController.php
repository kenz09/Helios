<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Paginate the authenticated user's tasks.
     *
     * @param \App\Project $project
     * @return \Illuminate\View\View
     */
    public function show(Project $project){
        return view('projectMembers',[
            'members' => $this->getMembers($project),
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


    /**
     * adds a member to project
     *
     * @param \App\Project $project
     * @param \App\User $user
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function addMember(Project $project,User $user){
        $project->users()->attach($user);

        return redirect('/projects');
    }

    /**
     * remove a member from project
     *
     * @param \App\Project $project
     * @param \App\User $user
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function removeMember(Project $project, User $user){
        $project->users()->detach($user);

        return redirect('/projects');
    }

    /**
     * gets all project member
     *
     * @param \App\Project $project
     * @return \Illuminate\Database\Eloquent
     */
    public function getMembers(Project $project){
        return $project->users()->get();
    }
}
