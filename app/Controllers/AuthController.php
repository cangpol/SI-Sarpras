<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function authenticate()
    {
        $session = session();
        $model = new UserModel();
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        $user = $model->getUserWithRole($email);
        
        if ($user) {
            if (password_verify($password, $user['password_hash'])) {
                if ($user['status'] !== 'active') {
                    $session->setFlashdata('error', 'Account is inactive.');
                    return redirect()->to('/login');
                }
                
                $ses_data = [
                    'user_id'   => $user['id'],
                    'name'      => $user['name'],
                    'email'     => $user['email'],
                    'role_id'   => $user['role_id'],
                    'role_name' => $user['role_name'],
                    'logged_in' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('error', 'Wrong Password');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'Email not Found');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}

