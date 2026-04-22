<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\BillModel;
use App\Models\UserModel;

class Home extends BaseController
{
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth/login');
        }

        $userRole = session()->get('user_role');
        $clientModel = new ClientModel();
        $billModel = new BillModel();
        $userModel = new UserModel();
        
        $data = [];
        
        if ($userRole === 'admin') {
            $allBills = $billModel
                ->select('bills.*, clients.name as client_name, users.name as user_name')
                ->join('clients', 'clients.id = bills.client_id', 'left')
                ->join('users', 'users.id = bills.user_id', 'left')
                ->orderBy('bills.billing_month', 'DESC')
                ->findAll();

            $data['totalClients'] = count($clientModel->findAll());
            $data['totalBills'] = count($allBills);
            $data['totalUsers'] = count($userModel->findAll());
            $data['totalRevenue'] = array_reduce($allBills, static function ($carry, $bill) {
                return $carry + (float) ($bill['total_amount'] ?? 0);
            }, 0.0);
            $data['recentBills'] = array_slice($allBills, 0, 5);
            $data['monthlyRevenueSeries'] = $this->buildMonthlySeries($allBills);
            $data['topClient'] = $this->getTopClient($allBills);
            $data['activeUserCount'] = count(array_unique(array_filter(array_column($allBills, 'user_id'))));
            $data['usageRate'] = $data['totalUsers'] > 0
                ? (int) round(($data['activeUserCount'] / $data['totalUsers']) * 100)
                : 0;
            $data['isAdmin'] = true;
        } else {
            $bills = $billModel->getBillsByUserWithDetails(session()->get('user_id'));
            $data['totalBillsComputed'] = count($bills);
            $data['totalEarnings'] = array_reduce($bills, static function ($carry, $bill) {
                return $carry + (float) ($bill['total_amount'] ?? 0);
            }, 0.0);
            $data['recentBills'] = array_slice($bills, 0, 5);
            $data['monthlyRevenueSeries'] = $this->buildMonthlySeries($bills);
            $data['connectedClients'] = count(array_unique(array_filter(array_column($bills, 'client_id'))));
            $data['averageBillAmount'] = $data['totalBillsComputed'] > 0
                ? $data['totalEarnings'] / $data['totalBillsComputed']
                : 0;
            $data['usageRate'] = $data['totalBillsComputed'] > 0
                ? min(100, (int) round(($data['connectedClients'] / max(1, $data['totalBillsComputed'])) * 100))
                : 0;
            $data['isAdmin'] = false;
        }
        
        return view('dashboard', $data);
    }

    private function buildMonthlySeries(array $bills, int $months = 6): array
    {
        $series = [];

        for ($offset = $months - 1; $offset >= 0; $offset--) {
            $monthKey = date('Y-m', strtotime('-' . $offset . ' months'));
            $series[$monthKey] = [
                'label' => date('M', strtotime($monthKey . '-01')),
                'count' => 0,
            ];
        }

        foreach ($bills as $bill) {
            if (empty($bill['billing_month'])) {
                continue;
            }

            $monthKey = date('Y-m', strtotime($bill['billing_month']));
            if (isset($series[$monthKey])) {
                $series[$monthKey]['count']++;
            }
        }

        $maxCount = 0;
        foreach ($series as $item) {
            if ($item['count'] > $maxCount) {
                $maxCount = $item['count'];
            }
        }

        foreach ($series as &$item) {
            $item['height'] = $maxCount > 0 ? max(18, (int) round(($item['count'] / $maxCount) * 100)) : 18;
        }
        unset($item);

        return array_values($series);
    }

    private function getTopClient(array $bills): ?array
    {
        $totals = [];

        foreach ($bills as $bill) {
            $clientName = $bill['client_name'] ?? 'Unknown Client';
            if (! isset($totals[$clientName])) {
                $totals[$clientName] = 0.0;
            }

            $totals[$clientName] += (float) ($bill['total_amount'] ?? 0);
        }

        if ($totals === []) {
            return null;
        }

        arsort($totals);
        $clientName = array_key_first($totals);

        return [
            'name' => $clientName,
            'amount' => $totals[$clientName],
        ];
    }

    public function testdb()
    {
        try {
            $db = \Config\Database::connect();
            
            // Test basic connection
            if ($db->connect()) {
                echo "<h2 style='color: green;'>✓ Database Connected Successfully!</h2>";
                echo "<p><strong>Host:</strong> " . $db->hostname . "</p>";
                echo "<p><strong>Database:</strong> " . $db->database . "</p>";
                echo "<p><strong>Driver:</strong> " . $db->DBDriver . "</p>";
                
                // Run a simple test query
                $query = $db->query("SELECT 1 as connection_test");
                if ($query) {
                    echo "<p style='color: green;'><strong>✓ Query Test Passed</strong></p>";
                }
            }
        } catch (\Exception $e) {
            echo "<h2 style='color: red;'>✗ Database Connection Failed!</h2>";
            echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
        }
    }
}
