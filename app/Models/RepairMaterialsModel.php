<?php

namespace App\Models;

use CodeIgniter\Model;

class RepairMaterialsModel extends Model
{
    protected $table      = 'repair_materials_reports';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'repair_id', 'modem_qty', 'foc_qty', 'fic_qty',
        'materials_others', 'trouble', 'action_taken',
        'power_nap', 'nap_picture', 'gui_pon', 'speedtest',
        'power_ground', 'with_subscriber', 'house_picture',
        'tagging', 'serial_number'
    ];

    protected $useTimestamps = true; // handles created_at and updated_at
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
