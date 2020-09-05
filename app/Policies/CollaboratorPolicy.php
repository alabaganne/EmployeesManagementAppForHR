<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CollaboratorPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(User $user) {
        return $user->hasPermissionTo('view collaborators');
    }

    public function store(User $user) {
        return $user->hasPermissionTo('add collaborators');
    }

    public function update(User $user) {
        return $user->hasPermissionTo('edit collaborators');
    }

    public function destroy(User $user) {
        return $user->hasPermissionTo('delete collaborators');
    }
}
