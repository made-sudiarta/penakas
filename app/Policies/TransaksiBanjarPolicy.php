<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\TransaksiBanjar;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransaksiBanjarPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TransaksiBanjar');
    }

    public function view(AuthUser $authUser, TransaksiBanjar $transaksiBanjar): bool
    {
        return $authUser->can('View:TransaksiBanjar');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TransaksiBanjar');
    }

    public function update(AuthUser $authUser, TransaksiBanjar $transaksiBanjar): bool
    {
        return $authUser->can('Update:TransaksiBanjar');
    }

    public function delete(AuthUser $authUser, TransaksiBanjar $transaksiBanjar): bool
    {
        return $authUser->can('Delete:TransaksiBanjar');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:TransaksiBanjar');
    }

    public function restore(AuthUser $authUser, TransaksiBanjar $transaksiBanjar): bool
    {
        return $authUser->can('Restore:TransaksiBanjar');
    }

    public function forceDelete(AuthUser $authUser, TransaksiBanjar $transaksiBanjar): bool
    {
        return $authUser->can('ForceDelete:TransaksiBanjar');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TransaksiBanjar');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TransaksiBanjar');
    }

    public function replicate(AuthUser $authUser, TransaksiBanjar $transaksiBanjar): bool
    {
        return $authUser->can('Replicate:TransaksiBanjar');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TransaksiBanjar');
    }

}