<?php

namespace App\Policies;

use App\Project;
use App\User;
use App\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function complete(User $user, Task $task)
    {
        return $user->is($task->user);
    }

    public function approve(User $user, Task $task){
        $project = Project::findOrFail($task->project_id);
        $project->admins()->get();

        return $user->is($project->owner)||$project->admins->contains($user);
    }

    public function cancel(User $user, Task $task){
        $project = Project::findOrFail($task->project_id);
        $project->admins()->get();
        return ($user->is($project->owner)||$project->admins->contains($user->id)||$user->is($task->user));
    }
}
