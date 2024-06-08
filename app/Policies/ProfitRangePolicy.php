<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProfitRange;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfitRangePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_profit::range');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProfitRange $profitRange): bool
    {
        return $user->can('view_profit::range');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_profit::range');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProfitRange $profitRange): bool
    {
        return $user->can('update_profit::range');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProfitRange $profitRange): bool
    {
        return $user->can('delete_profit::range');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_profit::range');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, ProfitRange $profitRange): bool
    {
        return $user->can('force_delete_profit::range');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_profit::range');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, ProfitRange $profitRange): bool
    {
        return $user->can('restore_profit::range');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_profit::range');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, ProfitRange $profitRange): bool
    {
        return $user->can('replicate_profit::range');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_profit::range');
    }
}
