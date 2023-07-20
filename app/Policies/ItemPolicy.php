<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ItemPolicy
{

    public function viewAny(User $user): bool
    {
        return $user->can('view_item');
    }



    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('add_item');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Item $item): bool
    {
        return $user->can('update_item');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Item $item): bool
    {
        return $user->can('delete_item');
    }

}
