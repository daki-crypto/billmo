<?php

namespace App\Controllers;

use App\Models\BillModel;
use App\Models\ClientModel;
use App\Models\AuditLogModel;

class ComputeBillController extends BaseController
{
    protected $billModel;
    protected $clientModel;
    protected $auditLogModel;

    public function __construct()
    {
        $this->billModel = new BillModel();
        $this->clientModel = new ClientModel();
        $this->auditLogModel = new AuditLogModel();
    }

    /**
     * Resolve the flat tier rate from consumed units.
     */
    private function resolveTierRate(float $units): float
    {
        if ($units <= 200) {
            return 10.00;
        }

        if ($units <= 500) {
            return 13.00;
        }

        return 15.00;
    }

    /**
     * Normal user: Compute bill form
     */
    public function compute()
    {
        // Check if user is normal user
        if (session()->get('user_role') !== 'normal') {
            return redirect()->to('/')->with('error', 'Only normal users can compute bills');
        }

        return view('bills/compute');
    }

    /**
     * Normal user: Store computed bill
     */
    public function store()
    {
        if (session()->get('user_role') !== 'normal') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access'])->setStatusCode(403);
        }

        $userId = session()->get('user_id');

        $rules = [
            'client_name'    => 'required|max_length[100]',
            'meter_number'   => 'required|max_length[100]',
            'client_address' => 'required',
            'billing_month'  => 'required|valid_date',
            'units_consumed' => 'required|decimal',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Validation failed', 'errors' => $this->validator->getErrors()]);
        }

        $clientName   = trim((string) $this->request->getPost('client_name'));
        $meterNumber  = trim((string) $this->request->getPost('meter_number'));
        $clientAddress = trim((string) $this->request->getPost('client_address'));

        // Look up client by meter number first
        $client = $this->clientModel->where('meter_number', $meterNumber)->first();

        if (! $client) {
            // Auto-create the client if meter number is new
            $clientId = $this->clientModel->insert([
                'name'         => $clientName,
                'meter_number' => $meterNumber,
                'address'      => $clientAddress,
            ]);

            if (! $clientId) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to register the client. Please try again.',
                ]);
            }

            $client = $this->clientModel->find($clientId);

            $this->auditLogModel->logAction(
                $userId,
                'CLIENT_CREATED',
                'Auto-registered client: ' . $clientName . ' (Meter: ' . $meterNumber . ')'
            );
        }

        $units = (float) $this->request->getPost('units_consumed');
        $rate = $this->resolveTierRate($units);
        $total = $units * $rate;

        $this->billModel->insert([
            'name'           => $clientName,
            'user_id'        => $userId,
            'billing_month'  => $this->request->getPost('billing_month'),
            'units_consumed' => $units,
            'rate_per_unit'  => $rate,
            'total_amount'   => $total,
        ]);

        // Log audit
        $this->auditLogModel->logAction(
            $userId,
            'BILL_COMPUTED',
            'Computed bill for client: ' . $clientName
        );

        return $this->response->setJSON(['success' => true, 'message' => 'Bill computed successfully!', 'redirect' => base_url('billing/history')]);
    }

    /**
     * Normal user: View their billing history
     */
    public function history()
    {
        if (session()->get('user_role') !== 'normal') {
            return redirect()->to('/')->with('error', 'Unauthorized access');
        }

        $bills = $this->billModel->getBillsByUserWithDetails(session()->get('user_id'));

        $totalAmount = 0;
        foreach ($bills as $bill) {
            $totalAmount += (float) $bill['total_amount'];
        }

        $summary = [
            'totalBills' => count($bills),
            'totalAmount' => $totalAmount,
            'latestBillMonth' => ! empty($bills) ? $bills[0]['billing_month'] : null,
        ];

        return view('bills/history', [
            'bills' => $bills,
            'summary' => $summary,
        ]);
    }

    /**
     * Normal user: View a single bill summary.
     */
    public function summary($id = null)
    {
        if (session()->get('user_role') !== 'normal') {
            return redirect()->to('/')->with('error', 'Unauthorized access');
        }

        if (! $id) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $bill = $this->billModel->getBillSummaryForUser($id, session()->get('user_id'));

        if (! $bill) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('bills/summary', ['bill' => $bill]);
    }
}
