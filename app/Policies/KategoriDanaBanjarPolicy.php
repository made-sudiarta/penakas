<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\KategoriDanaBanjar;
use Illuminate\Auth\Access\HandlesAuthorization;

class KategoriDanaBanjarPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:KategoriDanaBanjar');
    }

    public function view(AuthUser $authUser, KategoriDanaBanjar $kategoriDanaBanjar): bool
    {
        return $authUser->can('View:KategoriDanaBanjar');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:KategoriDanaBanjar');
    }

    public function update(AuthUser $authUser, KategoriDanaBanjar $kategoriDanaBanjar): bool
    {
        return $authUser->can('Update:KategoriDanaBanjar');
    }

    public function delete(AuthUser $authUser, KategoriDanaBanjar $kategoriDanaBanjar): bool
    {
        return $authUser->can('Delete:KategoriDanaBanjar');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:KategoriDanaBanjar');
    }

    public function restore(AuthUser $authUser, KategoriDanaBanjar $kategoriDanaBanjar): bool
    {
        return $authUser->can('Restore:KategoriDanaBanjar');
    }

    public function forceDelete(AuthUser $authUser, KategoriDanaBanjar $kategoriDanaBanjar): bool
    {
        return $authUser->can('ForceDelete:KategoriDanaBanjar');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:KategoriDanaBanjar');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:KategoriDanaBanjar');
    }

    public function replicate(AuthUser $authUser, KategoriDanaBanjar $kategoriDanaBanjar): bool
    {
        return $authUser->can('Replicate:KategoriDanaBanjar');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:KategoriDanaBanjar');
    }

}