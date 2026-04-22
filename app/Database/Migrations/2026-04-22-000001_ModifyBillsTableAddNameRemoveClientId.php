<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyBillsTableAddNameRemoveClientId extends Migration
{
    public function up()
    {
        // Drop the foreign key constraint first
        $this->forge->dropForeignKey('bills', 'bills_client_id_foreign');
        
        // Drop the client_id column
        $this->forge->dropColumn('bills', 'client_id');
        
        // Add the name column (client name)
        $this->forge->addColumn('bills', [
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
                'after' => 'id',
            ],
        ]);
    }

    public function down()
    {
        // Remove the name column
        $this->forge->dropColumn('bills', 'name');
        
        // Re-add the client_id column
        $this->forge->addColumn('bills', [
            'client_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'after' => 'id',
            ],
        ]);
        
        // Re-add the foreign key
        $this->forge->addForeignKey('client_id', 'clients', 'id', 'CASCADE', 'CASCADE');
    }
}
