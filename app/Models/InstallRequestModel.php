<?php
namespace App\Models;

use CodeIgniter\Model;

class InstallRequestModel extends Model
{
    protected $table = 'install_requests';
    protected $primaryKey = 'id';
    protected $allowedFields = ['status', 'application_id', 'schedule_date', 'created_at'];

    public function updateStatusByApplicationId($applicationId, $status)
    {
        return $this->set('status', $status)
                    ->where('application_id', $applicationId)
                    ->update();
    }
}
