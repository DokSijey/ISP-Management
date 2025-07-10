<?php

namespace App\Models;

use CodeIgniter\Model;

class ApplicationModel extends Model
{
    protected $table = 'applications';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'first_name', 'middle_name', 'last_name', 'suffix', 'province', 'city', 'barangay',
        'house_number', 'apartment', 'landmark', 'contact_number1', 'contact_number2',
        'email', 'plan', 'application_date', 'status', 'decline_reason', 'schedule_date',
        'app_status', 'app_reason'
    ];


     // ✅ Admit Application
     public function admitApplication($id)
     {
         return $this->update($id, ['status' => 'Admitted']);
     }
 
     // ✅ Decline Application
     public function declineApplication($id, $reason)
     {
         return $this->update($id, [
             'status' => 'Declined',
             'decline_reason' => $reason
         ]);
     }

     // Get the count of pending applications
    public function getPendingApplicationsCount()
    {
        return $this->where('status', 'pending')->countAllResults();
    }

    // Get the count of approved applications
    public function getApprovedApplicationsCount()
    {
        return $this->where('status', 'approved')->countAllResults();
    }

    // Get the count of declined applications
    public function getDeclinedApplicationsCount()
    {
        return $this->where('status', 'declined')->countAllResults();
    }
}

?>
