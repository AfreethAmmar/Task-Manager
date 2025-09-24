<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Any authenticated user can list their own tasks.
     * (Controller should already scope index by auth()->id()).
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Only the owner can view a specific task.
     */
    public function view(User $user, Task $task): bool
    {
        return $task->user_id === $user->id;
    }

    /**
     * Any authenticated user can create a task for themself.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Only the owner can update the task.
     */
    public function update(User $user, Task $task): bool
    {
        return $task->user_id === $user->id;
    }

    /**
     * Only the owner can delete the task.
     */
    public function delete(User $user, Task $task): bool
    {
        return $task->user_id === $user->id;
    }

    /**
     * Only the owner can restore the task.
     */
    public function restore(User $user, Task $task): bool
    {
        return $task->user_id === $user->id;
    }

    /**
     * Only the owner can force delete the task.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return $task->user_id === $user->id;
    }
}
