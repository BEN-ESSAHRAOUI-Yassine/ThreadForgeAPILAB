<?php

namespace App\Policies;

use App\Models\Blueprint;
use App\Models\User;

class BlueprintPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Blueprint $Blueprint): bool
    {
        return $user->id === $Blueprint->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Blueprint $Blueprint): bool
    {
        return $user->id === $Blueprint->user_id;
    }

    public function delete(User $user, Blueprint $Blueprint): bool
    {
        return $user->id === $Blueprint->user_id;
    }
}
