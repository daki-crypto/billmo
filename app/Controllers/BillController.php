<?php

namespace App\Controllers;

use App\Models\BillModel;
use App\Models\ClientModel;
use App\Models\UserModel;

class BillController extends BaseController
{
    protected $billModel;
    protected $clientModel;
    protected $userModel;

    public function __construct()
    {
        $this->billModel = new BillModel();
        $this->clientModel = new ClientModel();
        $this->userModel = new UserModel();
    }

    /**
     * Display all bills
     */
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth/login');
        }

        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/billing/history');
        }

        $bills = $this->billModel->getBillsCreatedByNormalUsers();
        return view('bills/index', ['bills' => $bills]);
    }

    /**
     * Show single bill
     */
    public function show($id = null)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth/login');
        }

        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/billing/history');
        }

        if (!$id) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $bill = $this->billModel->getNormalUserBillById($id);
        if (!$bill) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('bills/show', ['bill' => $bill]);
    }

    /**
     * Create new bill form
     */
    public function create()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth/login');
        }

        return redirect()->to('/bills')->with('error', 'Admins can only view bills created by normal users.');
    }

    /**
     * Store new bill
     */
    public function store()
    {
        return $this->response->setJSON(['success' => false, 'message' => 'Admins can only view bills created by normal users.'])->setStatusCode(403);
    }

    /**
     * Edit bill form
     */
    public function edit($id = null)
    {
        return $this->response->setJSON(['success' => false, 'message' => 'Admins can only view bills created by normal users.'])->setStatusCode(403);
    }

    /**
     * Update bill
     */
    public function update($id = null)
    {
        return $this->response->setJSON(['success' => false, 'message' => 'Admins can only view bills created by normal users.'])->setStatusCode(403);
    }

    /**
     * Delete bill
     */
    public function delete($id = null)
    {
        return $this->response->setJSON(['success' => false, 'message' => 'Admins can only view bills created by normal users.'])->setStatusCode(403);
    }

    /**
     * Get bills by client
     */
    public function clientBills($clientId = null)
    {
        if (!$clientId) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $client = $this->clientModel->getClientById($clientId);
        if (!$client) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (!session()->has('user_id')) {
            return redirect()->to('/auth/login');
        }

        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/billing/history');
        }

        $bills = $this->billModel->getBillsByClientFromNormalUsers($clientId);
        return view('bills/client_bills', [
            'client' => $client,
            'bills'  => $bills,
        ]);
    }
}
