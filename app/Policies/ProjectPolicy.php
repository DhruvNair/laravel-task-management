<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

class ProjectPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    // ProjectPolicy
    public function update(User $user, Project $project) {
        return $user->id === $project->user_id;
    }

}
