<?php

namespace App\Policies;

use App\Models\RawContent;
use App\Models\User;

class RawContentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, RawContent $RawContent): bool
    {
        return $user->id === $RawContent->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, RawContent $RawContent): bool
    {
        return $user->id === $RawContent->user_id;
    }

    public function delete(User $user, RawContent $RawContent): bool
    {
        return $user->id === $RawContent->user_id;
    }
}
