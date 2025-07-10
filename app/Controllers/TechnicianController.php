<?php

namespace App\Controllers;

use App\Models\TicketModel;
use App\Models\TechnicianModel;
use CodeIgniter\Controller;
use App\Models\SubscroberModel;
use App\Models\ApplicationModel;
use App\Models\RepairMaterialsModel;

class TechnicianController extends Controller
{
    
    
    public function login()
    {
        return view('technician/login'); // Show login form
    }

    public function authenticate()
    {
        $name = $this->request->getPost('name');
        $password = $this->request->getPost('password');
        
        $technicianModel = new TechnicianModel();

        // Validate technician credentials
        $technician = $technicianModel->validateLogin($name, $password);

        if ($technician) {
            session()->set('technician', [
                'id' => $technician['id'],
                'name' => $technician['name'],
                'area' => $technician['area'],
                'isLoggedIn' => true
            ]);
            return redirect()->to('/technician/dashboard');
        } else {
            return redirect()->back()->with('error', 'Invalid login credentials');
        }
    }
    public function logout()
    {
        session()->remove('technician');
        return redirect()->to('technician/login');
    }
    
    public function dashboard()
    {
        if (!session()->has('technician')) {
            return redirect()->to('/technician/login');
        }
    
        $technician = session()->get('technician');
        $area = $technician['area'];
        $technicianId = $technician['id'];
    
        $installModel = new \App\Models\InstallRequestModel();
        $ticketModel = new \App\Models\RepairTicketModel();
    
        // Check for ongoing install requests assigned to this technician in their area
        $ongoingInstall = $installModel
            ->select('install_requests.*, applications.first_name as app_first_name, applications.last_name as app_last_name, applications.contact_number1, applications.email')
            ->join('applications', 'applications.id = install_requests.application_id')
            ->where('install_requests.status', 'On-going')
            ->where('applications.city', $area)
            ->orderBy('install_requests.schedule_date', 'ASC')
            ->first();
    
        // Check for ongoing repair tickets assigned to this technician in their area
        $ongoingRepair = $ticketModel
            ->select('repair_tickets.*, subscribers.first_name as sub_first_name, subscribers.last_name as sub_last_name, subscribers.account_number')
            ->join('subscribers', 'subscribers.id = repair_tickets.subscriber_id')
            ->where('repair_tickets.status', 'On-going')
            ->where('subscribers.city', $area)
            ->orderBy('repair_tickets.scheduled_date', 'ASC')
            ->first();
    
        $ongoingTicketData = null;
        $ongoingTicketType = null; // "install" or "repair"
    
        // Decide which ongoing ticket takes priority
        if ($ongoingInstall) {
            $ongoingTicketData = $ongoingInstall;
            $ongoingTicketType = 'install';
        } elseif ($ongoingRepair) {
            $ongoingTicketData = $ongoingRepair;
            $ongoingTicketType = 'repair';
        }
    
        // Fetch all PENDING install requests
        $pendingInstalls = $installModel
            ->select('install_requests.*, applications.first_name as app_first_name, applications.last_name as app_last_name, applications.contact_number1, applications.email, applications.landmark, applications.house_number, applications.apartment, applications.barangay, applications.city, applications.plan')
            ->join('applications', 'applications.id = install_requests.application_id')
            ->whereIn('install_requests.status', ['Pending', 'On-going'])
            ->where('applications.city', $area)
            ->orderBy('install_requests.schedule_date', 'ASC')
            ->findAll();
    
        // Fetch all OPEN or ON-GOING repair tickets
        $repairTickets = $ticketModel
            ->select('repair_tickets.*, subscribers.first_name as sub_first_name, subscribers.last_name as sub_last_name, subscribers.account_number, subscribers.address, subscribers.city')
            ->join('subscribers', 'subscribers.id = repair_tickets.subscriber_id')
            ->whereIn('repair_tickets.status', ['Open', 'On-going'])
            ->where('subscribers.city', $area)
            ->orderBy('repair_tickets.scheduled_date', 'ASC')
            ->findAll();
    
        return view('technician/dashboard', [
            'technician' => $technician,
            'pendingInstalls' => $pendingInstalls,
            'repairTickets' => $repairTickets,
            'ongoingTicketData' => $ongoingTicketData,
            'ongoingTicketType' => $ongoingTicketType,
        ]);
    }
    


public function installRequests()
{
    // Check if technician is logged in
    if (!session()->has('technician')) {
        return redirect()->to('/technician/login');
    }

    $technician = session()->get('technician');
    $area = $technician['area']; // Technician's area

    $installModel = new \App\Models\InstallRequestModel();

    // Fetch the install requests for the technician's area and statuses
    $requests = $installModel
        ->select('install_requests.*, applications.first_name, applications.middle_name, applications.last_name, applications.suffix, applications.contact_number1, applications.email, applications.city, applications.barangay, applications.house_number, applications.landmark, applications.app_status')
        ->join('applications', 'applications.id = install_requests.application_id')
        ->where('applications.city', $area)
        ->whereIn('applications.app_status', ['Assigned', 'On-going'])
        ->findAll();

    // Find the first "On-going" install request (if any)
    $ongoingRequest = null;
    foreach ($requests as $req) {
        if ($req['status'] === 'On-going') {
            $ongoingRequest = $req;
            break;
        }
    }

    // Pass both requests and ongoingRequest to the view
    return view('technician/install_requests', [
        'requests' => $requests,
        'ongoingRequest' => $ongoingRequest
    ]);
}


public function updateInstallStatus()
{
    $applicationId = $this->request->getPost('application_id');
    $status = $this->request->getPost('app_status');
    $reason = $this->request->getPost('app_reason');

    if (!$applicationId || !$status) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Missing application ID or status.'
        ]);
    }

    $db = \Config\Database::connect();
    $db->transStart();

    $applicationModel = new \App\Models\ApplicationModel();
    $installRequestModel = new \App\Models\InstallRequestModel();

    $appData = ['app_status' => $status];

    if ($status === 'Cancelled' || $status === 'Re-schedule') {
        $appData['app_reason'] = $reason;
    } else {
        $appData['app_reason'] = null; // reset if not relevant
    }

    $appUpdated = $applicationModel->update($applicationId, $appData);
    if ($appUpdated === false) {
        error_log('Failed to update applications table for id ' . $applicationId);
    }

    $installUpdated = $installRequestModel->where('application_id', $applicationId)
                                         ->set(['status' => $status])
                                         ->update();
    if ($installUpdated === false) {
        error_log('Failed to update install_requests for application_id ' . $applicationId);
    }

    $db->transComplete();

    if ($db->transStatus() === false || !$appUpdated || !$installUpdated) {
        $lastError = $db->error();
        error_log('DB Transaction failed: ' . json_encode($lastError));

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update status: ' . $lastError['message']
        ]);
    }

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Status updated successfully.'
    ]);
}


public function submitInstallMaterials()
{
    helper(['form']);

    if ($this->request->getMethod() !== 'POST') {
        return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
    }

    $installId = $this->request->getPost('install_id');
    if (!$installId) {
        return $this->response->setJSON(['success' => false, 'message' => 'Missing Install ID']);
    }

    $installMaterialsModel = new \App\Models\InstallMaterialsModel();
    $installRequestsModel  = new \App\Models\InstallTicketModel();
    $applicationModel      = new \App\Models\ApplicationModel();
    $subscriberModel       = new \App\Models\SubscriberModel(); // make sure you have this model

    // Text fields
    $data = [
        'install_id'        => $installId,
        'serial_number'     => $this->request->getPost('serial_number'),
        'modem_qty'         => $this->request->getPost('modem_qty'),
        'foc_qty'           => $this->request->getPost('foc_qty'),
        'fic_qty'           => $this->request->getPost('fic_qty'),
        'materials_others'  => $this->request->getPost('materials_others'),
        'remarks'           => $this->request->getPost('remarks'),
        'with_subscriber'   => $this->request->getPost('with_subscriber'),
    ];

    // File inputs
    $fileInputs = [
        'power_nap', 'nap_picture', 'gui_pon', 'speedtest',
        'power_ground', 'picture_of_id', 'picture_of_page', 'house_picture',
    ];
    $uploadDir = 'uploads/install_images/';

    foreach ($fileInputs as $inputName) {
        $file = $this->request->getFile($inputName);
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move($uploadDir, $newName);
            $data[$inputName] = $uploadDir . $newName;
        }
    }

    // Save the materials report
    if (! $installMaterialsModel->insert($data)) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to save installation materials report.',
            'errors'  => $installMaterialsModel->errors(),
        ]);
    }

    // Update install_requests status
    if (! $installRequestsModel->update($installId, [
        'status' => 'Installed',
        'app_reason' => null,
    ])) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Report saved, but failed to update install request status.',
            'errors'  => $installRequestsModel->errors(),
        ]);
    }

    // Fetch application_id and update application + create subscriber
    $installRecord = $installRequestsModel->find($installId);
    if ($installRecord && isset($installRecord['application_id'])) {
        $applicationId = $installRecord['application_id'];

        // Update application status
        if (! $applicationModel->update($applicationId, ['app_status' => 'Installed'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Install request updated, but failed to update application status.',
                'errors'  => $applicationModel->errors(),
            ]);
        }

        // Get application details
        $application = $applicationModel->find($applicationId);
        if ($application) {
            // Build subscriber data
            $subscriberData = [
                'application_id'  => $applicationId,
                'first_name'      => $application['first_name'],
                'middle_name'     => $application['middle_name'],
                'last_name'       => $application['last_name'],
                'email'           => $application['email'],
                'address'         => $application['house_number'] . ' '. $application['apartment'] .', '. $application['barangay'],
                'city'            => $application['city'],
                'contact_number1' => $application['contact_number1'],
                'contact_number2' => $application['contact_number2'],
                'plan'            => $application['plan'],
                'billing_day'     => null,
                'price_to_pay'    => null,
                'account_number'  => null,
                'status'          => 'Disconnected',
            ];

            // Insert into subscribers table
            if (! $subscriberModel->insert($subscriberData)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Application updated, but failed to insert into subscribers table.',
                    'errors'  => $subscriberModel->errors(),
                ]);
            }
            $mailer = new \App\Libraries\MailSender();

            $subscriberEmail = $application['email'];
            $subscriberName  = $application['first_name'] . ' ' . $application['last_name'];
            $subject         = 'Installation Completed - Your Internet is Ready!';
            $body            = "
                Hello {$subscriberName}!,<br><br>
                Your internet installation has been successfully completed.<br>
                You may now enjoy your subscribed plan.<br><br>
                Thank you for choosing Allstar Tech Wireless Hotspot and Internet Services!<br><br>
                — Allstar Tech Team
            ";

            // Send the email using your MailSender library
            if (! $mailer->send($subscriberEmail, $subscriberName, $subject, $body)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Subscriber added, but email sending failed.',
                ]);
            }
        }
    }

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Installation materials saved, request/application updated, subscriber created.',
    ]);
}



public function setStatusOpen()
{
    $installId = $this->request->getPost('install_id');

    if (!$installId) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Install request ID is missing.'
        ]);
    }

    $installRequestModel = new \App\Models\InstallRequestModel();
    $applicationModel = new \App\Models\ApplicationModel();

    $installRequest = $installRequestModel->find($installId);

    if (!$installRequest) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Install request not found.'
        ]);
    }

    $applicationId = $installRequest['application_id'];

    // Update install_requests.status to 'Pending'
    $updatedInstall = $installRequestModel->update($installId, ['status' => 'Pending']);

    // Update applications.app_status to 'Assigned'
    $updatedApplication = $applicationModel->update($applicationId, ['app_status' => 'Assigned']);

    if ($updatedInstall && $updatedApplication) {
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Status changed to OPEN successfully.'
        ]);
    } else {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update status on one or more tables.'
        ]);
    }
}

public function repairRequests()
{
    if (!session()->has('technician')) {
        return redirect()->to('/technician/login');
    }

    $technician = session()->get('technician');
    $area = $technician['area'];

    $repairModel = new \App\Models\RepairTicketModel();

    $repairs = $repairModel
        ->select('repair_tickets.*, subscribers.first_name, subscribers.last_name, subscribers.account_number, subscribers.address, subscribers.contact_number1, subscribers.contact_number2, subscribers.city')
        ->join('subscribers', 'subscribers.id = repair_tickets.subscriber_id')
        ->where('subscribers.city', $area)
        ->whereIn('repair_tickets.status', ['Open', 'On-going'])
        ->orderBy('repair_tickets.scheduled_date', 'ASC')
        ->findAll();

    // Add full name for display
    foreach ($repairs as &$r) {
        $r['subscriber_name'] = $r['first_name'] . ' ' . $r['last_name'];
    }

    // Find all On-going tickets for the modal
    $ongoingTickets = array_filter($repairs, fn($r) => $r['status'] === 'On-going');

    return view('technician/repair_requests', [
        'repairs' => $repairs,
        'ongoingTickets' => $ongoingTickets,
    ]);
}

    public function updateRepairStatus()
    {
        $repairId = $this->request->getPost('repair_id');
        $status = $this->request->getPost('status');
        $reason = $this->request->getPost('reason');

        // Validate input
        if (!$repairId || !$status) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Missing repair ID or status.'
            ]);
        }

        $repairTicketModel = new \App\Models\RepairTicketModel();

        $data = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($status === 'Cancelled' || $status === 'Re-schedule') {
            $data['reason'] = $reason;
        }

        $updated = $repairTicketModel->update($repairId, $data);

        if ($updated) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status updated successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update status. Please try again.'
            ]);
        }
    
    }

 public function submitMaterialsReport()
{
    helper(['form']);

    if ($this->request->getMethod() !== 'POST') {
        return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
    }

    $repairId = $this->request->getPost('repair_id');
    if (!$repairId) {
        return $this->response->setJSON(['success' => false, 'message' => 'Missing Repair ID']);
    }

    $repairMaterialsModel = new \App\Models\RepairMaterialsModel();
    $repairRequestsModel  = new \App\Models\RepairTicketModel();

    // Text fields
    $data = [
        'repair_id'        => $repairId,
        'modem_qty'        => $this->request->getPost('modem_qty'),
        'foc_qty'          => $this->request->getPost('foc_qty'),
        'fic_qty'          => $this->request->getPost('fic_qty'),
        'materials_others' => $this->request->getPost('materials_others'),
        'trouble'          => $this->request->getPost('trouble'),
        'action_taken'     => $this->request->getPost('action_taken'),
        'tagging'          => $this->request->getPost('tagging'),
        'serial_number'    => $this->request->getPost('serial_number'),
    ];

    // File inputs
    $fileInputs = [
        'power_nap',
        'nap_picture',
        'gui_pon',
        'speedtest',
        'power_ground',
        'with_subscriber',
        'house_picture',
    ];
    $uploadDir = 'uploads/repair_images/';

    foreach ($fileInputs as $inputName) {
        $file = $this->request->getFile($inputName);
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move($uploadDir, $newName);
            $data[$inputName] = $uploadDir . $newName;
        }
    }

    // Insert report
    if (! $repairMaterialsModel->insert($data)) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to save materials report',
            'errors'  => $repairMaterialsModel->errors(),
        ]);
    }

    // Update status
    if (! $repairRequestsModel->update($repairId, [
        'status' => 'Resolved',
        'reason' => null,
    ])) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update ticket status',
            'errors'  => $repairRequestsModel->errors(),
        ]);
    }

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Materials report saved and ticket marked as Resolved.',
    ]);
}

}
