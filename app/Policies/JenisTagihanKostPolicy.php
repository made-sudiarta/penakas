<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\JenisTagihanKost;
use Illuminate\Auth\Access\HandlesAuthorization;

class JenisTagihanKostPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:JenisTagihanKost');
    }

    public function view(AuthUser $authUser, JenisTagihanKost $jenisTagihanKost): bool
    {
        return $authUser->can('View:JenisTagihanKost');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:JenisTagihanKost');
    }

    public function update(AuthUser $authUser, JenisTagihanKost $jenisTagihanKost): bool
    {
        return $authUser->can('Update:JenisTagihanKost');
    }

    public function delete(AuthUser $authUser, JenisTagihanKost $jenisTagihanKost): bool
    {
        return $authUser->can('Delete:JenisTagihanKost');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:JenisTagihanKost');
    }

    public function restore(AuthUser $authUser, JenisTagihanKost $jenisTagihanKost): bool
    {
        return $authUser->can('Restore:JenisTagihanKost');
    }

    public function forceDelete(AuthUser $authUser, JenisTagihanKost $jenisTagihanKost): bool
    {
        return $authUser->can('ForceDelete:JenisTagihanKost');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:JenisTagihanKost');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:JenisTagihanKost');
    }

    public function replicate(AuthUser $authUser, JenisTagihanKost $jenisTagihanKost): bool
    {
        return $authUser->can('Replicate:JenisTagihanKost');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:JenisTagihanKost');
    }

}