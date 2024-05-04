<?php

namespace App\Policies\providers;

use App\User;
use App\carepays_providers\practise;
use App\carepays_providers\provider;
use Illuminate\Auth\Access\HandlesAuthorization;

class practisePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the provider can view the practise.
     *
     * @param  \App\carepays_providers/provider  $provider
     * @return mixed
     */
    public function view(provider $provider)
    {
        return $provider->hasPermission('view-company');
    }

    /**
     * Determine whether the user can create practises.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the provider can update the practise.
     *
     * @param  \App\carepays_providers\provider  $provider
     * @return mixed
     */
    public function update(provider $provider)
    {
        return $this->hasPermission('edit-company');
    }

    /**
     * Determine whether the user can delete the practise.
     *
     * @param  \App\User  $user
     * @param  \App\App\Model\practise  $practise
     * @return mixed
     */
    public function delete(User $user, practise $practise)
    {
        //
    }

    /**
     * Determine whether the user can restore the practise.
     *
     * @param  \App\User  $user
     * @param  \App\App\Model\practise  $practise
     * @return mixed
     */
    public function restore(User $user, practise $practise)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the practise.
     *
     * @param  \App\User  $user
     * @param  \App\App\Model\practise  $practise
     * @return mixed
     */
    public function forceDelete(User $user, practise $practise)
    {
        //
    }
}
