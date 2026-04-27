<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\KamarKost;
use Illuminate\Auth\Access\HandlesAuthorization;

class KamarKostPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:KamarKost');
    }

    public function view(AuthUser $authUser, KamarKost $kamarKost): bool
    {
        return $authUser->can('View:KamarKost');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:KamarKost');
    }

    public function update(AuthUser $authUser, KamarKost $kamarKost): bool
    {
        return $authUser->can('Update:KamarKost');
    }

    public function delete(AuthUser $authUser, KamarKost $kamarKost): bool
    {
        return $authUser->can('Delete:KamarKost');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:KamarKost');
    }

    public function restore(AuthUser $authUser, KamarKost $kamarKost): bool
    {
        return $authUser->can('Restore:KamarKost');
    }

    public function forceDelete(AuthUser $authUser, KamarKost $kamarKost): bool
    {
        return $authUser->can('ForceDelete:KamarKost');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:KamarKost');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:KamarKost');
    }

    public function replicate(AuthUser $authUser, KamarKost $kamarKost): bool
    {
        return $authUser->can('Replicate:KamarKost');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:KamarKost');
    }

}