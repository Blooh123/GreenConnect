<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CarbonFootprint;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarbonFootprintPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, CarbonFootprint $carbonFootprint)
    {
        return $user->id === $carbonFootprint->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, CarbonFootprint $carbonFootprint)
    {
        return $user->id === $carbonFootprint->user_id;
    }

    public function delete(User $user, CarbonFootprint $carbonFootprint)
    {
        return $user->id === $carbonFootprint->user_id;
    }
} 