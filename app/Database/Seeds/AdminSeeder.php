<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['area' => 'Hagonoy',   'password' => password_hash('Hagonoy@Allstar123', PASSWORD_DEFAULT)],
            ['area' => 'Malolos',   'password' => password_hash('Malolos@Allstar123', PASSWORD_DEFAULT)],
            ['area' => 'Paombong',  'password' => password_hash('Paombong@Allstar123', PASSWORD_DEFAULT)],
            ['area' => 'Bataan',    'password' => password_hash('Bataan@Allstar123', PASSWORD_DEFAULT)],
            ['area' => 'Pampanga',  'password' => password_hash('Pampanga@Allstar123', PASSWORD_DEFAULT)]
        ];

        // Insert into 'admins' table
        $this->db->table('admins')->insertBatch($data);
        
        echo "Admins added successfully!\n";
    }
}
