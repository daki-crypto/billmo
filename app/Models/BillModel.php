<?php

namespace App\Models;

use CodeIgniter\Model;

class BillModel extends Model
{
    protected $table = 'bills';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'user_id', 'billing_month', 'units_consumed', 'rate_per_unit', 'total_amount'];
    protected $useTimestamps = false;

    // Validation
    protected $validationRules = [
        'name'           => 'required|max_length[100]',
        'user_id'        => 'required|integer',
        'billing_month'  => 'required|valid_date',
        'units_consumed' => 'required|decimal',
        'rate_per_unit'  => 'required|decimal',
        'total_amount'   => 'required|decimal',
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;

    /**
     * Base query for bills with client and user details.
     */
    private function buildDetailedBillsQuery()
    {
        return $this->select('bills.*, bills.name as client_name, clients.meter_number, users.name as user_name, users.role as user_role')
                    ->join('clients', 'clients.name = bills.name', 'left')
                    ->join('users', 'users.id = bills.user_id', 'left');
    }

    /**
     * Get bill by ID
     */
    public function getBillById($id)
    {
        return $this->find($id);
    }

    /**
     * Get bills by client name
     */
    public function getBillsByClient($clientName)
    {
        return $this->where('name', $clientName)->orderBy('billing_month', 'DESC')->findAll();
    }

    /**
     * Get bills by user ID
     */
    public function getBillsByUser($userId)
    {
        return $this->where('user_id', $userId)->orderBy('billing_month', 'DESC')->findAll();
    }

    /**
     * Get bills by user with client details for history and summary views.
     */
    public function getBillsByUserWithDetails($userId)
    {
        return $this->select('bills.*, bills.name as client_name, clients.meter_number')
                    ->join('clients', 'clients.name = bills.name', 'left')
                    ->where('bills.user_id', $userId)
                    ->orderBy('bills.billing_month', 'DESC')
                    ->findAll();
    }

    /**
     * Get a specific bill owned by a given user with client details.
     */
    public function getBillSummaryForUser($billId, $userId)
    {
        return $this->select('bills.*, bills.name as client_name, clients.meter_number, clients.address as client_address')
                    ->join('clients', 'clients.name = bills.name', 'left')
                    ->where('bills.id', $billId)
                    ->where('bills.user_id', $userId)
                    ->first();
    }

    /**
     * Get all bills with client and user info
     */
    public function getAllBillsWithDetails()
    {
        return $this->select('bills.*, bills.name as client_name, clients.meter_number, users.name as user_name')
                    ->join('clients', 'clients.name = bills.name', 'left')
                    ->join('users', 'users.id = bills.user_id', 'left')
                    ->orderBy('bills.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get any bill by ID with client and user details.
     */
    public function getBillWithDetailsById($id)
    {
        return $this->buildDetailedBillsQuery()
                    ->where('bills.id', $id)
                    ->first();
    }

    /**
     * Get bills created by normal users with client and user info.
     */
    public function getBillsCreatedByNormalUsers()
    {
        return $this->buildDetailedBillsQuery()
                    ->where('users.role', 'normal')
                    ->orderBy('bills.billing_month', 'DESC')
                    ->findAll();
    }

    /**
     * Get a bill by ID only if it was created by a normal user.
     */
    public function getNormalUserBillById($id)
    {
        return $this->buildDetailedBillsQuery()
                    ->where('bills.id', $id)
                    ->where('users.role', 'normal')
                    ->first();
    }

    /**
     * Get bills by client ID created by normal users.
     */
    public function getBillsByClientFromNormalUsers($clientName)
    {
        return $this->buildDetailedBillsQuery()
                    ->where('bills.name', $clientName)
                    ->where('users.role', 'normal')
                    ->orderBy('bills.billing_month', 'DESC')
                    ->findAll();
    }

    /**
     * Get bills for a specific month
     */
    public function getBillsByMonth($month)
    {
        $monthStart = date('Y-m-01', strtotime($month));
        $monthEnd = date('Y-m-01', strtotime($monthStart . ' +1 month'));

        return $this->where('billing_month >=', $monthStart)
                    ->where('billing_month <', $monthEnd)
                    ->findAll();
    }
}
