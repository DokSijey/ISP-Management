<?php

namespace App\Models;

use CodeIgniter\Model;

class InstallTicketModel extends Model
{
    protected $table = 'install_requests';
    protected $primaryKey = 'id';
    protected $allowedFields = ['application_id', 'schedule_date', 'status', 'created_at'];

    // Method to update app_status, app_reason, and install_requests status
    public function updateInstallRequest($applicationId, $scheduleDate)
    {
        // Start a transaction to ensure both tables are updated atomically
        $db = \Config\Database::connect();
        $db->transStart();

        // Update the applications table (app_status and app_reason)
        $applicationModel = new \App\Models\ApplicationModel(); // Assuming ApplicationModel is for the applications table
        $applicationModel->set([
            'app_status' => 'Assigned', // New status for the application
            'app_reason' => NULL, // Reset the app_reason
        ])
        ->where('id', $applicationId)
        ->update();

        // Update the install_requests table status to Pending
        $this->set('status', 'Pending')
            ->where('application_id', $applicationId)
            ->update();

        // Commit the transaction
        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            // Rollback if anything failed
            return false;
        }
        return true;
    }

public function getInstallTicketsWithDetails($adminArea, $date)
{
    return $this->select('install_requests.*, applications.first_name, applications.last_name, applications.contact_number1, applications.house_number, applications.barangay, applications.city, applications.plan, applications.app_status')
        ->join('applications', 'applications.id = install_requests.application_id')
        ->where('applications.city', $adminArea)
        ->where('install_requests.schedule_date', $date)
        ->findAll();
}

}
?>
