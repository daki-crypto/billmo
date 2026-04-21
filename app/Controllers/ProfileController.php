<?php

namespace App\Controllers;

use App\Models\AuditLogModel;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $userModel;
    protected $auditLogModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->auditLogModel = new AuditLogModel();
    }

    public function index()
    {
        $user = $this->userModel->find(session()->get('user_id'));

        if (! $user) {
            session()->destroy();

            return redirect()->to('/auth/login')->with('error', 'Your session is no longer valid. Please log in again.');
        }

        return view('profile/index', ['user' => $user]);
    }

    public function update()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (! $user) {
            session()->destroy();

            return redirect()->to('/auth/login')->with('error', 'Your session is no longer valid. Please log in again.');
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email,id,' . $userId . ']',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('profile_errors', $this->validator->getErrors());
        }

        $updateData = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];

        $this->userModel->update($userId, $updateData);

        session()->set([
            'user_name' => $updateData['name'],
            'user_email' => $updateData['email'],
        ]);

        $this->auditLogModel->logAction($userId, 'PROFILE_UPDATED', 'Updated profile information');

        return redirect()->to('/profile')->with('success', 'Profile updated successfully.');
    }

    public function changePassword()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (! $user) {
            session()->destroy();

            return redirect()->to('/auth/login')->with('error', 'Your session is no longer valid. Please log in again.');
        }

        $rules = [
            'current_password' => 'required|min_length[6]',
            'new_password' => 'required|strongPassword',
            'confirm_password' => 'required|matches[new_password]',
        ];

        $messages = [
            'new_password' => [
                'strongPassword' => 'New password must be at least 8 characters and include uppercase, lowercase, number, and special character.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->with('password_errors', $this->validator->getErrors());
        }

        $currentPassword = (string) $this->request->getPost('current_password');
        $storedPassword = (string) $user['password'];
        $passwordMatches = password_verify($currentPassword, $storedPassword);

        if (! $passwordMatches && $currentPassword === $storedPassword) {
            $passwordMatches = true;
        }

        if (! $passwordMatches) {
            return redirect()->back()->with('password_errors', ['current_password' => 'Current password is incorrect.']);
        }

        $newPassword = (string) $this->request->getPost('new_password');

        if ($currentPassword === $newPassword) {
            return redirect()->back()->with('password_errors', ['new_password' => 'New password must be different from your current password.']);
        }

        $this->userModel->update($userId, ['password' => $newPassword]);
        $this->auditLogModel->logAction($userId, 'PASSWORD_CHANGED', 'Changed account password');

        return redirect()->to('/profile')->with('success', 'Password changed successfully.');
    }

    public function resetPassword()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (! $user) {
            session()->destroy();

            return redirect()->to('/auth/login')->with('error', 'Your session is no longer valid. Please log in again.');
        }

        $temporaryPassword = $this->generateTemporaryPassword();

        $this->userModel->update($userId, ['password' => $temporaryPassword]);
        $this->auditLogModel->logAction($userId, 'PASSWORD_RESET', 'Reset account password from profile');

        return redirect()->to('/profile')
            ->with('success', 'Password reset successfully. Save your temporary password now.')
            ->with('temporary_password', $temporaryPassword);
    }

    private function generateTemporaryPassword(int $length = 12): string
    {
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $specials = '!@#$%^&*()-_=+[]{}';
        $allCharacters = $lowercase . $uppercase . $numbers . $specials;

        $passwordCharacters = [
            $lowercase[random_int(0, strlen($lowercase) - 1)],
            $uppercase[random_int(0, strlen($uppercase) - 1)],
            $numbers[random_int(0, strlen($numbers) - 1)],
            $specials[random_int(0, strlen($specials) - 1)],
        ];

        for ($index = count($passwordCharacters); $index < $length; $index++) {
            $passwordCharacters[] = $allCharacters[random_int(0, strlen($allCharacters) - 1)];
        }

        shuffle($passwordCharacters);

        return implode('', $passwordCharacters);
    }
}