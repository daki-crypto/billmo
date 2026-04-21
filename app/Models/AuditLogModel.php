<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditLogModel extends Model
{
    protected $table = 'audit_logs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['user_id', 'action', 'description'];
    protected $useTimestamps = false;

    // Validation
    protected $validationRules = [
        'user_id'     => 'required|integer',
        'action'      => 'required|string|max_length[255]',
        'description' => 'required|string',
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;

    /**
     * Get audit log by ID
     */
    public function getLogById($id)
    {
        return $this->find($id);
    }

    /**
     * Get logs by user ID
     */
    public function getLogsByUser($userId)
    {
        return $this->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll();
    }

    /**
     * Get all audit logs
     */
    public function getAllLogs()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    /**
     * Log an action
     */
    public function logAction($userId, $action, $description)
    {
        return $this->insert([
            'user_id'     => $userId,
            'action'      => $action,
            'description' => $description,
        ]);
    }

    /**
     * Get logs for a date range
     */
    public function getLogsByDateRange($startDate, $endDate)
    {
        return $this->where('created_at >=', $startDate)
                    ->where('created_at <=', $endDate)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
