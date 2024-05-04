<?php

namespace App\Policies\providers;

use App\carepays_providers\provider;
use Illuminate\Auth\Access\HandlesAuthorization;

class providerPolicy
{
    use HandlesAuthorization;

    public function viewAll(provider $provider)
    {
        return $provider->hasPermission('view-all-members');
    }

    /**
     * Determine whether the provider can view the provider.
     *
     * @param  \App\provider  $provider
     * @param  \App\App\carepays_providers\provider  $member
     * @return mixed
     */
    public function view(provider $provider, provider $member)
    {
        $memberRole = $member->roles->first()->name;
        return $provider->hasPermission('view-'.$memberRole);
    }

    /**
     * Determine whether the user can create providers.
     *
     * @param  \App\provider  $user
     * @return mixed
     */
    public function create(provider $provider, $role)
    {
        $permission = 'add-'.strtolower($role);
        return $provider->hasPermission($permission);
    }

    /**
     * Determine whether the user can update the provider.
     *
     * @param  \App\provider  $user
     * @param  \App\App\carepays_providers\provider  $provider
     * @return mixed
     */
    public function update(provider $provider, provider $member)
    {
        $memberRole = $member->roles->first()->name;
        $permission = 'edit-'.$memberRole;
        return $provider->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete the provider.
     *
     * @param  \App\provider  $provider
     * @param  \App\App\carepays_providers\provider  $provider
     * @return mixed
     */
    public function delete(provider $provider, provider $member)
    {
        $memberRole = $member->roles->first()->name;
        $permission = 'delete-'.$memberRole;
        return $provider->hasPermission($permission);
    }

    /**
     * Determine whether the user can restore the provider.
     *
     * @param  \App\provider  $user
     * @param  \App\App\carepays_providers\provider  $provider
     * @return mixed
     */
    public function restore(User $user, provider $provider)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the provider.
     *
     * @param  \App\User  $user
     * @param  \App\App\carepays_providers\provider  $provider
     * @return mixed
     */
    public function forceDelete(User $user, provider $provider)
    {
        //
    }
}
