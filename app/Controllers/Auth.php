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
            return $this->response->setJSON(['success' => false, 'message' => 'Validation failed', 'errors' => $this->validator->getErrors()]);
        }

        $user = $this->userModel->getUserByEmail($email);

        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'Email or password is incorrect']);
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
            return $this->response->setJSON(['success' => false, 'message' => 'Email or password is incorrect']);
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

    /**
     * Show signup/registration page
     */
    public function signup()
    {
        if (session()->has('user_id')) {
            return redirect()->to('/');
        }
        
        return view('auth/signup');
    }

    /**
     * Process user registration
     */
    public function processSignup()
    {
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        $rules = [
            'name'              => 'required|min_length[3]|max_length[100]',
            'email'             => 'required|valid_email|is_unique[users.email]',
            'password'          => 'required|strongPassword',
            'confirm_password'  => 'required|matches[password]',
        ];

        $messages = [
            'password' => [
                'strongPassword' => 'Password must be at least 8 characters and include uppercase, lowercase, number, and special character.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Validation failed', 'errors' => $this->validator->getErrors()]);
        }

        // Check if email already exists
        $existingUser = $this->userModel->getUserByEmail($email);
        if ($existingUser) {
            return $this->response->setJSON(['success' => false, 'message' => 'Email already registered']);
        }

        // Create new user with 'normal' role
        $this->userModel->insert([
            'name'      => $name,
            'email'     => $email,
            'password'  => $password,
            'role'      => 'normal',
        ]);

        return $this->response->setJSON(['success' => true, 'message' => 'Account created successfully! Please login with your credentials.', 'redirect' => '/auth/login']);
    }

    /**
     * Logout
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login')->with('success', 'Logged out successfully');
    }
}
