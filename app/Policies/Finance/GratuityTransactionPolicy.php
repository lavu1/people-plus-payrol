<?php

namespace App\Policies\Finance;

use App\Models\Finance\GratuityTransactions;
use App\Models\User;

class GratuityTransactionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_payroll::gratuity');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, GratuityTransactions $gratuityTransactions): bool
    {
        return $user->can('view_payroll::gratuity');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_payroll::gratuity');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GratuityTransactions $gratuityTransactions): bool
    {
        return $user->can('update_payroll::gratuity');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GratuityTransactions $gratuityTransactions): bool
    {
        return $user->can('delete_payroll::gratuity');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, GratuityTransactions $gratuityTransactions): bool
    {
        return $user->can('delete_any_payroll::gratuity');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, GratuityTransactions $gratuityTransactions): bool
    {
        return $user->can('force_delete_payroll::gratuity');
    }
}
