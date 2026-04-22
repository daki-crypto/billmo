<?php

namespace App\Controllers;

use App\Models\ClientModel;

class ClientController extends BaseController
{
    protected $clientModel;

    public function __construct()
    {
        $this->clientModel = new ClientModel();
    }

    /**
     * Display all clients
     */
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth/login');
        }

        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Only admins can manage clients.');
        }

        $clients = $this->clientModel->getAllClients();
        return view('clients/index', ['clients' => $clients]);
    }

    /**
     * Show single client with bills
     */
    public function show($id = null)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth/login');
        }

        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Only admins can manage clients.');
        }

        if (!$id) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $client = $this->clientModel->getClientWithBills($id);
        if (!$client) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('clients/show', ['client' => $client]);
    }

    /**
     * Create new client form
     */
    public function create()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth/login');
        }

        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Unauthorized access');
        }

        return view('clients/create');
    }

    /**
     * Store new client
     */
    public function store()
    {
        if (!session()->has('user_id')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        if (session()->get('user_role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Only admins can manage clients.'])->setStatusCode(403);
        }

        $rules = [
            'name'          => 'required|string|max_length[100]',
            'address'       => 'required|string',
            'meter_number'  => 'required|is_unique[clients.meter_number]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Validation failed', 'errors' => $this->validator->getErrors()]);
        }

        $this->clientModel->insert([
            'name'          => $this->request->getPost('name'),
            'address'       => $this->request->getPost('address'),
            'meter_number'  => $this->request->getPost('meter_number'),
        ]);

        if ($this->clientModel->errors() !== []) {
            return $this->response->setJSON(['success' => false, 'message' => 'Database error', 'errors' => $this->clientModel->errors()]);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Client created successfully!', 'redirect' => base_url('clients')]);
    }

    /**
     * Edit client form
     */
    public function edit($id = null)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth/login');
        }

        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Only admins can manage clients.');
        }

        if (!$id) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $client = $this->clientModel->getClientById($id);
        if (!$client) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('clients/edit', ['client' => $client]);
    }

    /**
     * Update client
     */
    public function update($id = null)
    {
        if (!session()->has('user_id')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        if (session()->get('user_role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Only admins can manage clients.'])->setStatusCode(403);
        }

        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'Client not found'])->setStatusCode(404);
        }

        $client = $this->clientModel->getClientById($id);
        if (!$client) {
            return $this->response->setJSON(['success' => false, 'message' => 'Client not found'])->setStatusCode(404);
        }

        $rules = [
            'name'          => 'required|string|max_length[100]',
            'address'       => 'required|string',
            'meter_number'  => 'required|is_unique[clients.meter_number,id,' . $id . ']',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Validation failed', 'errors' => $this->validator->getErrors()]);
        }

        $updated = $this->clientModel->update($id, [
            'id'            => $id,
            'name'          => $this->request->getPost('name'),
            'address'       => $this->request->getPost('address'),
            'meter_number'  => $this->request->getPost('meter_number'),
        ]);

        if (! $updated) {
            return $this->response->setJSON(['success' => false, 'message' => 'Database error', 'errors' => $this->clientModel->errors()]);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Client updated successfully!', 'redirect' => base_url('clients')]);
    }

    /**
     * Delete client
     */
    public function delete($id = null)
    {
        if (!session()->has('user_id')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        if (session()->get('user_role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Only admins can manage clients.'])->setStatusCode(403);
        }

        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'Client not found'])->setStatusCode(404);
        }

        $client = $this->clientModel->getClientById($id);
        if (!$client) {
            return $this->response->setJSON(['success' => false, 'message' => 'Client not found'])->setStatusCode(404);
        }

        $this->clientModel->delete($id);
        return $this->response->setJSON(['success' => true, 'message' => 'Client deleted successfully!', 'redirect' => base_url('clients')]);
    }
}
