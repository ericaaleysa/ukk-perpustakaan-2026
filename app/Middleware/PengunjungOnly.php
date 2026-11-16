<?php

namespace App\Middleware;

/** Dibuat otomatis oleh RoleController -- hanya role "pengunjung" yang boleh lewat. */
class PengunjungOnly extends EnsureRole
{
    protected function roles(): array
    {
        return ['pengunjung'];
    }
}
