<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PembayaranKost;
use Illuminate\Auth\Access\HandlesAuthorization;

class PembayaranKostPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PembayaranKost');
    }

    public function view(AuthUser $authUser, PembayaranKost $pembayaranKost): bool
    {
        return $authUser->can('View:PembayaranKost');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PembayaranKost');
    }

    public function update(AuthUser $authUser, PembayaranKost $pembayaranKost): bool
    {
        return $authUser->can('Update:PembayaranKost');
    }

    public function delete(AuthUser $authUser, PembayaranKost $pembayaranKost): bool
    {
        return $authUser->can('Delete:PembayaranKost');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:PembayaranKost');
    }

    public function restore(AuthUser $authUser, PembayaranKost $pembayaranKost): bool
    {
        return $authUser->can('Restore:PembayaranKost');
    }

    public function forceDelete(AuthUser $authUser, PembayaranKost $pembayaranKost): bool
    {
        return $authUser->can('ForceDelete:PembayaranKost');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PembayaranKost');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PembayaranKost');
    }

    public function replicate(AuthUser $authUser, PembayaranKost $pembayaranKost): bool
    {
        return $authUser->can('Replicate:PembayaranKost');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PembayaranKost');
    }

}