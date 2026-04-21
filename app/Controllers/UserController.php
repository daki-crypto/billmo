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
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access'])->setStatusCode(403);
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
            return $this->response->setJSON(['success' => false, 'message' => 'Validation failed', 'errors' => $this->validator->getErrors()]);
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

        return $this->response->setJSON(['success' => true, 'message' => 'User created successfully', 'redirect' => '/users']);
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
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access'])->setStatusCode(403);
        }

        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'User not found'])->setStatusCode(404);
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'User not found'])->setStatusCode(404);
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
            return $this->response->setJSON(['success' => false, 'message' => 'Validation failed', 'errors' => $this->validator->getErrors()]);
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
            return $this->response->setJSON(['success' => false, 'message' => 'Database error', 'errors' => $this->userModel->errors()]);
        }

        $this->auditLogModel->logAction(
            session()->get('user_id'),
            'USER_UPDATED',
            'Updated user: ' . $this->request->getPost('name')
        );

        return $this->response->setJSON(['success' => true, 'message' => 'User updated successfully', 'redirect' => '/users']);
    }

    /**
     * Admin: Delete user
     */
    public function delete($id = null)
    {
        if (session()->get('user_role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access'])->setStatusCode(403);
        }

        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'User not found'])->setStatusCode(404);
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'User not found'])->setStatusCode(404);
        }

        // Don't allow deleting self
        if ($id == session()->get('user_id')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Cannot delete your own account'])->setStatusCode(400);
        }

        $this->userModel->delete($id);

        // Log audit
        $this->auditLogModel->logAction(
            session()->get('user_id'),
            'USER_DELETED',
            'Deleted user: ' . $user['name']
        );

        return $this->response->setJSON(['success' => true, 'message' => 'User deleted successfully', 'redirect' => '/users']);
    }
}
