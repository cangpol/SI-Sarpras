<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $roleName = session()->get('role_name');
        
        if ($arguments && !in_array($roleName, $arguments)) {
            // Jika role user tidak ada di array arguments yang diizinkan
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to access this page.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}

