<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run()
    {
        // Sample install ticket
        $dataInstall = [
            'application_id' => 1, // ID from your application table
            'schedule_date' => '2025-04-10',
            'status' => 'Open',
            'technician_id' => 1, // Technician ID
            'ticket_type' => 'Install', // Type of ticket
        ];

        // Sample repair ticket
        $dataRepair = [
            'application_id' => 2, // ID from your application table
            'schedule_date' => '2025-04-12',
            'status' => 'Open',
            'technician_id' => 1, // Technician ID
            'ticket_type' => 'Repair', // Type of ticket
        ];

        // Insert tickets into the tickets table
        $this->db->table('tickets')->insert($dataInstall);
        $this->db->table('tickets')->insert($dataRepair);

        echo "Sample Install and Repair Tickets added.\n";
    }
}
