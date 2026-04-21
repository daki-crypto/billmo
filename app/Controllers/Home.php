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
            // Admin dashboard
            $data['totalClients'] = count($clientModel->findAll());
            $allBills = $billModel->findAll();
            $data['totalBills'] = count($allBills);
            $data['totalUsers'] = count($userModel->findAll());
            $data['totalRevenue'] = 0;
            foreach ($allBills as $bill) {
                $data['totalRevenue'] += $bill['total_amount'];
            }
            $data['isAdmin'] = true;
        } else {
            // Normal user dashboard
            $bills = $billModel->where('user_id', session()->get('user_id'))->findAll();
            $data['totalBillsComputed'] = count($bills);
            $data['totalEarnings'] = 0;
            foreach ($bills as $bill) {
                $data['totalEarnings'] += $bill['total_amount'];
            }
            $data['isAdmin'] = false;
        }
        
        return view('dashboard', $data);
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
