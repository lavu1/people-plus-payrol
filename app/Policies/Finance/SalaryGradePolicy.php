<?php

namespace App\Policies\Finance;

use App\Models\User;
use App\Models\Finance\SalaryGrade;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalaryGradePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_finance::salary::grade');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SalaryGrade $salaryGrade): bool
    {
        return $user->can('view_finance::salary::grade');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_finance::salary::grade');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SalaryGrade $salaryGrade): bool
    {
        return $user->can('update_finance::salary::grade');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SalaryGrade $salaryGrade): bool
    {
        return $user->can('delete_finance::salary::grade');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_finance::salary::grade');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, SalaryGrade $salaryGrade): bool
    {
        return $user->can('force_delete_finance::salary::grade');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_finance::salary::grade');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, SalaryGrade $salaryGrade): bool
    {
        return $user->can('restore_finance::salary::grade');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_finance::salary::grade');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, SalaryGrade $salaryGrade): bool
    {
        return $user->can('replicate_finance::salary::grade');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_finance::salary::grade');
    }
}
