<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WasteReport;
use Illuminate\Auth\Access\HandlesAuthorization;

class WasteReportPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, WasteReport $wasteReport)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, WasteReport $wasteReport)
    {
        return $user->id === $wasteReport->user_id;
    }

    public function delete(User $user, WasteReport $wasteReport)
    {
        return $user->id === $wasteReport->user_id;
    }
} 