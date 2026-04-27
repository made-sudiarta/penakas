<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Penghuni;
use Illuminate\Auth\Access\HandlesAuthorization;

class PenghuniPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Penghuni');
    }

    public function view(AuthUser $authUser, Penghuni $penghuni): bool
    {
        return $authUser->can('View:Penghuni');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Penghuni');
    }

    public function update(AuthUser $authUser, Penghuni $penghuni): bool
    {
        return $authUser->can('Update:Penghuni');
    }

    public function delete(AuthUser $authUser, Penghuni $penghuni): bool
    {
        return $authUser->can('Delete:Penghuni');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Penghuni');
    }

    public function restore(AuthUser $authUser, Penghuni $penghuni): bool
    {
        return $authUser->can('Restore:Penghuni');
    }

    public function forceDelete(AuthUser $authUser, Penghuni $penghuni): bool
    {
        return $authUser->can('ForceDelete:Penghuni');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Penghuni');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Penghuni');
    }

    public function replicate(AuthUser $authUser, Penghuni $penghuni): bool
    {
        return $authUser->can('Replicate:Penghuni');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Penghuni');
    }

}