<?php

namespace App\Models;

use CodeIgniter\Model;

class InstallMaterialsModel extends Model
{
    protected $table            = 'install_materials_reports';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = ''; // Not using updated_at

    protected $allowedFields    = [
        'install_id',
        'serial_number',
        'modem_qty',
        'foc_qty',
        'fic_qty',
        'materials_others',
        'remarks',
        'power_nap',
        'nap_picture',
        'gui_pon',
        'speedtest',
        'power_ground',
        'with_subscriber',
        'picture_of_id',
        'picture_of_page',
        'house_picture'
    ];
}
