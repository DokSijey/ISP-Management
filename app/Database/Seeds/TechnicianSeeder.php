<?php

// app/Database/Seeds/TechnicianSeeder.php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TechnicianSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Asiong',
                'email' => 'Asiong@gmail.com',
                'phone' => '09123456789', // Add a phone number
                'password' => password_hash('Asiong@Allstar123', PASSWORD_DEFAULT),
                'area' => 'Paombong', // Example area, change as necessary
                'created_at' => date('Y-m-d H:i:s')
            ]
            
        ];

        // Insert the data into the technicians table
        $this->db->table('technicians')->insertBatch($data);
    }
}
