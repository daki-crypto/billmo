<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'address', 'meter_number'];
    protected $useTimestamps = false;

    // Validation
    protected $validationRules = [
        'id'            => 'permit_empty|is_natural_no_zero',
        'name'          => 'required|string|max_length[100]',
        'address'       => 'required|string',
        'meter_number'  => 'required|is_unique[clients.meter_number,id,{id}]',
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;

    /**
     * Get client by ID
     */
    public function getClientById($id)
    {
        return $this->find($id);
    }

    /**
     * Get client by meter number
     */
    public function getClientByMeter($meterNumber)
    {
        return $this->where('meter_number', $meterNumber)->first();
    }

    /**
     * Get all clients
     */
    public function getAllClients()
    {
        return $this->findAll();
    }

    /**
     * Get client with bills
     */
    public function getClientWithBills($clientId)
    {
        $client = $this->find($clientId);
        if ($client) {
            $billModel = new BillModel();
            $client['bills'] = $billModel->where('client_id', $clientId)->findAll();
        }
        return $client;
    }
}
