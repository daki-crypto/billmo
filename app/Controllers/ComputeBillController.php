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

        $clients = $this->clientModel->findAll();
        return view('bills/compute', ['clients' => $clients]);
    }

    /**
     * Normal user: Store computed bill
     */
    public function store()
    {
        if (session()->get('user_role') !== 'normal') {
            return redirect()->to('/')->with('error', 'Unauthorized access');
        }

        $rules = [
            'client_id'      => 'required|integer',
            'billing_month'  => 'required|valid_date',
            'units_consumed' => 'required|decimal',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $units = (float) $this->request->getPost('units_consumed');
        $rate = $this->resolveTierRate($units);
        $total = $units * $rate;

        $this->billModel->insert([
            'client_id'      => $this->request->getPost('client_id'),
            'user_id'        => session()->get('user_id'),
            'billing_month'  => $this->request->getPost('billing_month'),
            'units_consumed' => $units,
            'rate_per_unit'  => $rate,
            'total_amount'   => $total,
        ]);

        // Log audit
        $this->auditLogModel->logAction(
            session()->get('user_id'),
            'BILL_COMPUTED',
            'Computed bill for client ID: ' . $this->request->getPost('client_id')
        );

        return redirect()->to('/billing/history')->with('success', 'Bill computed successfully!');
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

        $summary = [
            'totalBills' => count($bills),
            'totalAmount' => array_sum(array_column($bills, 'total_amount')),
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
