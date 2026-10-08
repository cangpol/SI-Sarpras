<?php

namespace App\Traits;

trait RoleScopeTrait
{
    /**
     * Apply role-based scoping to a model.
     * Admin roles get full access. Users (Dosen/Mahasiswa) are restricted to their own data.
     */
    protected function applyScope($model)
    {
        $roleName = session()->get('role_name');
        
        // Asumsi Super Admin dan Admin Sarpras memiliki akses penuh
        $adminRoles = ['Super Admin', 'Admin Sarpras'];
        
        if (!in_array($roleName, $adminRoles)) {
            $model->where('user_id', session()->get('user_id'));
        }
        
        return $model;
    }

    /**
     * Check if current user is an Admin
     */
    protected function isAdmin()
    {
        $roleName = session()->get('role_name');
        $adminRoles = ['Super Admin', 'Admin Sarpras'];
        return in_array($roleName, $adminRoles);
    }
}

