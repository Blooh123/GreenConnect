<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FoodListing;
use Illuminate\Auth\Access\HandlesAuthorization;

class FoodListingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, FoodListing $foodListing)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, FoodListing $foodListing)
    {
        return $user->id === $foodListing->user_id;
    }

    public function delete(User $user, FoodListing $foodListing)
    {
        return $user->id === $foodListing->user_id;
    }
} 