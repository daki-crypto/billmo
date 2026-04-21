<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AuditLogModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $auditLogModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->auditLogModel = new AuditLogModel();
    }

    /**
     * Admin: List all users
     */
    public function index()
    {
        // Check if user is admin
        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Unauthorized access');
        }

        $users = $this->userModel->findAll();
        return view('users/index', ['users' => $users]);
    }

    /**
     * Admin: Create user form
     */
    public function create()
    {
        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Unauthorized access');
        }

        return view('users/create');
    }

    /**
     * Admin: Store new user
     */
    public function store()
    {
        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Unauthorized access');
        }

        $rules = [
            'name'     => 'required|string|max_length[100]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|strongPassword',
            'role'     => 'required|in_list[admin,normal]',
        ];

        $messages = [
            'password' => [
                'strongPassword' => 'Password must be at least 8 characters and include uppercase, lowercase, number, and special character.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->insert([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'role'     => $this->request->getPost('role'),
        ]);

        // Log audit
        $this->auditLogModel->logAction(
            session()->get('user_id'),
            'USER_CREATED',
            'Created user: ' . $this->request->getPost('name')
        );

        return redirect()->to('/users')->with('success', 'User created successfully');
    }

    /**
     * Admin: Show user
     */
    public function show($id = null)
    {
        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Unauthorized access');
        }

        if (!$id) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('users/show', ['user' => $user]);
    }

    /**
     * Admin: Edit user form
     */
    public function edit($id = null)
    {
        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Unauthorized access');
        }

        if (!$id) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('users/edit', ['user' => $user]);
    }

    /**
     * Admin: Update user
     */
    public function update($id = null)
    {
        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Unauthorized access');
        }

    if (!$id) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $user = $this->userModel->find($id);
    if (!$user) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $rules = [
        'name'  => 'required|string|max_length[100]',
        'email' => 'required|valid_email|is_unique[users.email,id,' . $id . ']',
        'role'  => 'required|in_list[admin,normal]',
    ];

    $password = $this->request->getPost('password');

    if ($password !== null && $password !== '') {
        $rules['password'] = 'permit_empty|strongPassword';
    }

    $messages = [
        'password' => [
            'strongPassword' => 'Password must be at least 8 characters and include uppercase, lowercase, number, and special character.',
        ],
    ];

    if (!$this->validate($rules, $messages)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $updateData = [
        'id'    => $id,
        'name'  => $this->request->getPost('name'),
        'email' => $this->request->getPost('email'),
        'role'  => $this->request->getPost('role'),
    ];

    if ($password !== null && $password !== '') {
        $updateData['password'] = $password;
    }

    $updated = $this->userModel->update($id, $updateData);

    if (! $updated) {
        return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
    }

    $this->auditLogModel->logAction(
        session()->get('user_id'),
        'USER_UPDATED',
        'Updated user: ' . $this->request->getPost('name')
    );

    return redirect()->to('/users')->with('success', 'User updated successfully');
}

    /**
     * Admin: Delete user
     */
    public function delete($id = null)
    {
        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Unauthorized access');
        }

        if (!$id) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Don't allow deleting self
        if ($id == session()->get('user_id')) {
            return redirect()->back()->with('error', 'Cannot delete your own account');
        }

        $this->userModel->delete($id);

        // Log audit
        $this->auditLogModel->logAction(
            session()->get('user_id'),
            'USER_DELETED',
            'Deleted user: ' . $user['name']
        );

        return redirect()->to('/users')->with('success', 'User deleted successfully');
    }
}
