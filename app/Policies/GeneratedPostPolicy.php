<?php

namespace App\Policies;

use App\Models\GeneratedPost;
use App\Models\User;

class GeneratedPostPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, GeneratedPost $GeneratedPost): bool
    {
        //return $user->id === $GeneratedPost->user_id;
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, GeneratedPost $GeneratedPost): bool
    {
        return $user->id === $GeneratedPost->user_id;
    }

    public function delete(User $user, GeneratedPost $GeneratedPost): bool
    {
        return $user->id === $GeneratedPost->user_id;
    }
}
