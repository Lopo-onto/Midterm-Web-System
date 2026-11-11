<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function attemptlogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new UsersModel();

        $user = $userModel
            ->where('username', $username)
            ->first();

        if (!$user || !password_verify((string) $password, $user['password'] ?? '')) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid username or password.');
        }

        session()->regenerate(true);

        session()->set([
            'user_id' => $user['id'],
            'username' => $user['username'],
            'full_name' => $user['full_name'],
            'logged_in' => true
        ]);

        return redirect()->to('/');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login');
    }
}