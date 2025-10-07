<?php

namespace App\Policies\Company;

use App\Models\User;
use App\Models\Company\CompanyBranch;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyBranchPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_company::company::branch');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CompanyBranch $companyBranch): bool
    {
        return $user->can('view_company::company::branch');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_company::company::branch');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CompanyBranch $companyBranch): bool
    {
        return $user->can('update_company::company::branch');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CompanyBranch $companyBranch): bool
    {
        return $user->can('delete_company::company::branch');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_company::company::branch');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, CompanyBranch $companyBranch): bool
    {
        return $user->can('force_delete_company::company::branch');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_company::company::branch');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, CompanyBranch $companyBranch): bool
    {
        return $user->can('restore_company::company::branch');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_company::company::branch');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, CompanyBranch $companyBranch): bool
    {
        return $user->can('replicate_company::company::branch');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_company::company::branch');
    }
}
