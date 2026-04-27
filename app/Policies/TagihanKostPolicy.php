<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\TagihanKost;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagihanKostPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TagihanKost');
    }

    public function view(AuthUser $authUser, TagihanKost $tagihanKost): bool
    {
        return $authUser->can('View:TagihanKost');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TagihanKost');
    }

    public function update(AuthUser $authUser, TagihanKost $tagihanKost): bool
    {
        return $authUser->can('Update:TagihanKost');
    }

    public function delete(AuthUser $authUser, TagihanKost $tagihanKost): bool
    {
        return $authUser->can('Delete:TagihanKost');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:TagihanKost');
    }

    public function restore(AuthUser $authUser, TagihanKost $tagihanKost): bool
    {
        return $authUser->can('Restore:TagihanKost');
    }

    public function forceDelete(AuthUser $authUser, TagihanKost $tagihanKost): bool
    {
        return $authUser->can('ForceDelete:TagihanKost');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TagihanKost');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TagihanKost');
    }

    public function replicate(AuthUser $authUser, TagihanKost $tagihanKost): bool
    {
        return $authUser->can('Replicate:TagihanKost');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TagihanKost');
    }

}