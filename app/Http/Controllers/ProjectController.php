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
        $projectsRaw = Auth::user()
            ->projects()
            ->orderByDesc('created_at')
            ->get();
        $projects = collect();
        foreach($projectsRaw as $project){
            $tasksCount = $project->tasks()->count();
            if($tasksCount==0) $tasksCount = 1;
            $project['progress'] = (($project->tasks()->where('is_complete',1)->count()/$tasksCount)*100);
            $projects->push($project);
        }

        // return task index view with paginated tasks
        return view('projects', [
            'projects' => $projects
        ]);
    }

    /**
     * show the project
     *
     * @param int $projectId
     * @return \Illuminate\View\View
     */
    public function show($projectId){
        $project = Project::findOrFail($projectId);

        $project->tasks()->get();
        return view('project',[
            'project'=>$project,
            'messages'=>$project->messages()->get()
        ]);
    }

    /**
     * Paginate the project members.
     *
     * @param \App\Project $project
     * @return \Illuminate\View\View
     */
    public function showById(Project $project){
        $members = $project->users()->paginate(10);
        return view('projectMembers',[
            'members' => $members,
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
            'owner_id' => Auth::id(),
        ]);

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
}
