<?php

namespace App\Policies\Company;

use App\Models\User;
use App\Models\Company\CompanyEmployee;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyEmployeePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_company::company::employee');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CompanyEmployee $companyEmployee): bool
    {
        return $user->can('view_company::company::employee');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_company::company::employee');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CompanyEmployee $companyEmployee): bool
    {
        return $user->can('update_company::company::employee');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CompanyEmployee $companyEmployee): bool
    {
        return $user->can('delete_company::company::employee');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_company::company::employee');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, CompanyEmployee $companyEmployee): bool
    {
        return $user->can('force_delete_company::company::employee');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_company::company::employee');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, CompanyEmployee $companyEmployee): bool
    {
        return $user->can('restore_company::company::employee');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_company::company::employee');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, CompanyEmployee $companyEmployee): bool
    {
        return $user->can('replicate_company::company::employee');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_company::company::employee');
    }
}
