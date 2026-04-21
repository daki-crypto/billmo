<?php

namespace App\Controllers;

use App\Models\AuditLogModel;

class AuditController extends BaseController
{
    protected $auditLogModel;

    public function __construct()
    {
        $this->auditLogModel = new AuditLogModel();
    }

    /**
     * View audit logs
     */
    public function index()
    {
        $userRole = session()->get('user_role');

        if ($userRole === 'admin') {
            // Admin can see all logs
            $logs = $this->auditLogModel->orderBy('created_at', 'DESC')->findAll();
        } elseif ($userRole === 'normal') {
            // Normal user can only see their own logs
            $logs = $this->auditLogModel->where('user_id', session()->get('user_id'))
                                       ->orderBy('created_at', 'DESC')
                                       ->findAll();
        } else {
            return redirect()->to('/auth/login');
        }

        return view('audit/index', ['logs' => $logs, 'userRole' => $userRole]);
    }
}
