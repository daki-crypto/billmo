<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Show login page
     */
    public function login()
    {
        if (session()->has('user_id')) {

        }
        
        return view('auth/login');
    }

    /**
     * Process login
     */
    public function processLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[8]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('auth/login')->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = $this->userModel->getUserByEmail($email);

        if (!$user) {
            return redirect()->to('auth/login')->withInput()->with('error', 'Email or password is incorrect');
        }

        $passwordMatches = password_verify($password, $user['password']);

        if (! $passwordMatches && $password === $user['password']) {
            $passwordMatches = true;
            $this->userModel->update($user['id'], [
                'password' => $password,
            ]);
            $user = $this->userModel->find($user['id']);
        }

        if (! $passwordMatches) {
            return redirect()->to('auth/login')->withInput()->with('error', 'Email or password is incorrect');
        }

        session()->regenerate();

        // Set session
        session()->set([
            'user_id'   => $user['id'],
            'user_name' => $user['name'],
            'user_email' => $user['email'],
            'user_role' => $user['role'],
        ]);

        return redirect()->to('/');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login')->with('success', 'Logged out successfully');
    }
}
