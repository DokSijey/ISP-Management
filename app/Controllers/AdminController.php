<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AdminModel;
use App\Models\ApplicationModel;
use App\Models\SubscriberModel;  // Add this line at the top
use App\Models\TicketModel;
use App\Models\InstallRequestsModel; // Add this at the top if not yet added
use App\Models\RepairTicketModel;
use App\Models\BillingModel;
use App\Models\InstallTicketModel;
use App\Models\BillsModel;
use App\Models\FinanceModel;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Libraries\InvoiceGenerator;
use App\Libraries\MailSender;


class AdminController extends Controller
{
    
    public function login()
{
    return view('admin/login'); // Load the login form
}

    public function authenticate()
{
    $session = session();
    $model = new AdminModel();
    
    $area = $this->request->getPost('area'); // Selected area
    $password = $this->request->getPost('password');

    $admin = $model->where('area', $area)->first();

    if (!$admin) {
        // Log failed login attempt (no area found)
        log_action(0, 'Failed Login Attempt', 'No admin found for area: ' . $area);

        return redirect()->to('admin/login')->with('error', 'Area not found');
    }

    if ($admin && password_verify($password, $admin['password'])) {
        // Store session data
        $session->set([
            'admin_id' => $admin['id'],
            'area' => $admin['area'],
            'isLoggedIn' => true
        ]);

        // Log the successful login with the specific area
        log_action($admin['id'], 'Logged In', 'Admin logged in successfully from area: ' . $admin['area']);

        return redirect()->to(base_url('admin/dashboard')); // Ensure correct URL
    } else {
        // Log failed login attempt (invalid password)
        log_action(0, 'Failed Login Attempt', 'Invalid password for admin in area: ' . $area);

        return redirect()->to(base_url('admin/login'))->with('error', 'Invalid credentials');
    }
}

public function dashboard()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('admin/login');
    }

    $db = \Config\Database::connect();
    $adminArea = session()->get('area');

    if (!$adminArea) {
        echo "Admin area not found in session";
        return;
    }

    try {
        date_default_timezone_set('Asia/Manila');
        $today = date('Y-m-d');
        // --- Application and Subscriber Counts ---
        $pendingApplicationsCount = $db->table('applications')
            ->where('city', $adminArea)
            ->where('status', 'Pending')
            ->countAllResults();

        $approvedApplicationsCount = $db->table('applications')
            ->where('city', $adminArea)
            ->where('status', 'Approved')
            ->where('app_status', 'Pending')
            ->countAllResults();

        $declinedApplicationsCount = $db->table('applications')
            ->where('city', $adminArea)
            ->where('status', 'Declined')
            ->countAllResults();

        $totalSubscribersCount = $db->table('subscribers')
            ->where('city', $adminArea)
            ->countAllResults();
        $date = date('Y-m-d');
        $installRequestCount = $db->table('applications')
            ->join('install_requests', 'install_requests.application_id = applications.id')
            ->where('city', $adminArea)
            ->where('install_requests.status', 'Pending',)
            ->where('app_status', 'Assigned')
            ->where('install_requests.schedule_date', $date)
            ->countAllResults();

        $pendinginstallRequestCount = $db->table('applications')
            ->join('install_requests', 'install_requests.application_id = applications.id')
            ->where('city', $adminArea)
            ->where('install_requests.status', 'Pending',)
            ->where('app_status', 'Assigned')
            ->countAllResults();

        $ongoingRequestCount = $db->table('applications')
            ->where('city', $adminArea)
            ->where('app_status', 'On-going')
            ->countAllResults();

        $rescheduledRequestCount = $db->table('applications')
            ->where('city', $adminArea)
            ->where('app_status', 'Re-schedule')
            ->countAllResults();

        $cancelledRequestCount = $db->table('applications')
            ->where('city', $adminArea)
            ->where('app_status', 'Cancelled')
            ->countAllResults();

        $installedCount = $db->table('applications')
            ->where('city', $adminArea)
            ->where('app_status', 'Installed')
            ->countAllResults();

        $latestTickets = $db->table('repair_tickets')
            ->join('subscribers', 'repair_tickets.subscriber_id = subscribers.id')
            ->where('subscribers.city', $adminArea)
            ->where('repair_tickets.status', 'Open')
            ->orderBy('repair_tickets.created_at', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();
        // --- Repair Tickets ---
        $assignedRepairTicketCount = $db->table('repair_tickets')
            ->join('subscribers', 'repair_tickets.subscriber_id = subscribers.id')
            ->where('repair_tickets.status', 'Open')
            ->where('repair_tickets.updated_at >=', $date . ' 00:00:00')
            ->where('repair_tickets.updated_at <=', $date . ' 23:59:59')
            ->where('subscribers.city', $adminArea)
            ->countAllResults();
        
        $pendingRepairTicketCount = $db->table('repair_tickets')
            ->join('subscribers', 'repair_tickets.subscriber_id = subscribers.id')
            ->where('repair_tickets.status', 'Open')
            ->where('repair_tickets.updated_at <', $date)
            ->where('subscribers.city', $adminArea)
            ->countAllResults();

        $ongoingRepairTicketCount = $db->table('repair_tickets')
            ->join('subscribers', 'repair_tickets.subscriber_id = subscribers.id')
            ->where('subscribers.city', $adminArea)
            ->where('repair_tickets.status', 'On-going')
            ->countAllResults();

        $rescheduledRepairTicketCount = $db->table('repair_tickets')
            ->join('subscribers', 'repair_tickets.subscriber_id = subscribers.id')
            ->where('subscribers.city', $adminArea)
            ->where('repair_tickets.status', 'Re-schedule')
            ->countAllResults();

        $cancelledRepairTicketCount = $db->table('repair_tickets')
            ->join('subscribers', 'repair_tickets.subscriber_id = subscribers.id')
            ->where('subscribers.city', $adminArea)
            ->where('repair_tickets.status', 'Cancelled')
            ->countAllResults();

        $resolvedRepairTicketCount = $db->table('repair_tickets')
            ->join('subscribers', 'repair_tickets.subscriber_id = subscribers.id')
            ->where('subscribers.city', $adminArea)
            ->where('repair_tickets.status', 'Resolved')
            ->countAllResults();

        $currentMonth = date('F');
        // --- Revenue & Expenses ---
        $revenuesQuery = $db->table('finance_records')
            ->select("
                CASE
                    WHEN category LIKE '%Monthly%' THEN 'MONTHLY'
                    WHEN category LIKE '%Installation%' THEN 'INSTALLATION FEES'
                    ELSE 'OTHERS / MATERIALS SOLD'
                END AS category_tag,
                SUM(amount) AS total_amount
            ")
            ->where('type', 'revenue')
            ->where('month_tag', $currentMonth)
            ->where('created_by', $adminArea)
            ->groupBy('category_tag')
            ->get()
            ->getResultArray();

        $revenues = [
            'MONTHLY' => 0,
            'INSTALLATION FEES' => 0,
            'OTHERS / MATERIALS SOLD' => 0,
        ];

        foreach ($revenuesQuery as $row) {
            $revenues[$row['category_tag']] = (float)$row['total_amount'];
        }


        $expensesSum = $db->table('finance_records')
        ->select("
                CASE
                    WHEN category LIKE '%Modem%' THEN 'BOUGHT MODEM'
                    WHEN category LIKE '%FOC%' THEN 'BOUGHT FIBER OPTIC CABLE (FOC)'
                    WHEN category LIKE '%FIC%' THEN 'BOUGHT FIELD INSTALLABLE CONNECTOR (FIC)'
                    ELSE 'OTHERS / MATERIALS BOUGHT'
                END AS category_tag,
                SUM(amount) AS total_amount
            ")
            ->where('type', 'expenses')
            ->where('month_tag', $currentMonth)
            ->where('created_by', $adminArea)
            ->groupBy('category_tag')
            ->get()
            ->getResultArray();

        $expenses = [
            'BOUGHT MODEM' => 0,
            'BOTH FIBER OPTIC CABLE (FOC)' => 0,
            'BOUGHT FIELD INSTALLABLE CONNECTOR (FIC)' => 0,
            'OTHERS / MATERIALS BOUGHT' => 0,
        ];
        foreach ($expensesSum as $row) {
            $expenses[$row['category_tag']] = (float)$row['total_amount'];
        }

        // --- Monthly Subscriber Count ---
        $results = $db->table('subscribers')
            ->select('MONTH(subscribers.created_at) AS month, COUNT(*) AS count')
            ->join('admins', 'subscribers.city = admins.area')
            ->where('admins.area', $adminArea)
            ->where('YEAR(subscribers.created_at)', date('Y'))
            ->groupBy('MONTH(subscribers.created_at)')
            ->orderBy('MONTH(subscribers.created_at)', 'ASC')
            ->get()
            ->getResultArray();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $counts = array_fill(0, 12, 0);

        foreach ($results as $row) {
            $index = $row['month'] - 1;
            $counts[$index] = (int)$row['count'];
        }

        $monthsJson = json_encode($months);
        $countsJson = json_encode($counts);

        $totalUnpaidAmount = $db->table('bills')
            ->selectSum('bills.price_to_pay')
            ->join('subscribers', 'bills.subscriber_id = subscribers.id')
            ->where('bills.status', 'unpaid')
            ->where('subscribers.city', $adminArea)
            ->get()
            ->getRow()
            ->price_to_pay;

        $installModel = new \App\Models\InstallTicketModel();
        $installTickets = $installModel->getInstallTicketsWithDetails($adminArea, $today);

        $repairModel = new \App\Models\RepairTicketModel();
        $repairTickets = $repairModel->getRepairRequestsWithDetails($adminArea, $today);
        return view('admin/dashboard', [
            'pendingApplicationsCount' => $pendingApplicationsCount,
            'approvedApplicationsCount' => $approvedApplicationsCount,
            'declinedApplicationsCount' => $declinedApplicationsCount,
            'totalSubscribersCount' => $totalSubscribersCount,
            'installRequestCount' => $installRequestCount,
            'ongoingRequestCount' => $ongoingRequestCount,
            'rescheduledRequestCount' => $rescheduledRequestCount,
            'cancelledRequestCount' => $cancelledRequestCount,
            'installedCount' => $installedCount,
            'assignedRepairTicketCount' => $assignedRepairTicketCount,
            'latestTickets' => $latestTickets,
            'ongoingRepairTicketCount' => $ongoingRepairTicketCount,
            'rescheduledRepairTicketCount' => $rescheduledRepairTicketCount,
            'cancelledRepairTicketCount' => $cancelledRepairTicketCount,
            'resolvedRepairTicketCount' => $resolvedRepairTicketCount,
            'revenues' => $revenues,
            'expenses' => $expenses,
            'monthsJson' => $monthsJson,
            'countsJson' => $countsJson,
            'totalUnpaidAmount' => $totalUnpaidAmount,
            'installTickets' => $installTickets,
            'repairTickets' => $repairTickets,
            'pendinginstallRequestCount' => $pendinginstallRequestCount,
            'pendingRepairTicketCount' => $pendingRepairTicketCount
        ]);
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

        

    public function logout()
{
    // Log the admin's logout action, including the area
    $admin_id = session()->get('admin_id');  // Get the admin's ID from the session
    $area = session()->get('area');  // Get the area from the session

    // Log the logout action
    log_action($admin_id, 'Logged Out', 'Admin logged out from area: ' . $area);

    // Destroy the session
    session()->destroy(); // Clear session

    // Redirect to the login page
    return redirect()->to('admin/login');
}



   public function pendingApplications()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/admin/login');
    }

    $adminArea = session()->get('area'); // Get the logged-in admin's area
    $applicationModel = new \App\Models\ApplicationModel();

    // Log the admin accessing the pending applications page
    $admin_id = session()->get('admin_id');  // Get the admin's ID from the session
    log_action($admin_id, 'Viewed Pending Applications', 'Admin viewed pending applications for area: ' . $adminArea);

    // Fetch applications where city matches the admin's area and status is 'Pending'
    $data1['applications'] = $applicationModel
        ->where('city', $adminArea)
        ->where('status', 'Pending')
        ->findAll();

    return view('admin/approved_applications', $data);
}


public function approvedApplications()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/admin/login');
    }

    $adminArea = session()->get('area'); // Get the logged-in admin's area
    $applicationModel = new \App\Models\ApplicationModel();

    // Log the admin accessing the approved applications page
    $admin_id = session()->get('admin_id');
    log_action($admin_id, 'Viewed Approved Applications', 'Admin viewed approved applications for area: ' . $adminArea);

    // Fetch applications where city matches the admin's area, status is 'Approved', and app_status is 'Pending'
    $approvedApplications = $applicationModel
        ->where('city', $adminArea)
        ->where('status', 'Approved')
        ->where('app_status', 'Pending')
        ->findAll();

    // Fetch applications where city matches the admin's area and status is 'Pending'
    $pendingApplications = $applicationModel
        ->where('city', $adminArea)
        ->where('status', 'Pending')
        ->findAll();

    // Fetch applications where city matches the admin's area and status is 'Declined'
    $declinedApplications = $applicationModel
        ->where('city', $adminArea)
        ->where('status', 'Declined')
        ->findAll();
    // Pass both datasets to the view
    return view('admin/applications', [
        'approvedApplications' => $approvedApplications,
        'pendingApplications' => $pendingApplications,
        'declinedApplications' => $declinedApplications
    ]);
}

public function declinedApplications()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/admin/login');
    }

    $adminArea = session()->get('area'); // Get the logged-in admin's area
    $applicationModel = new \App\Models\ApplicationModel();

    // Log the admin accessing the declined applications page
    $admin_id = session()->get('admin_id');  // Get the admin's ID from the session
    log_action($admin_id, 'Viewed Declined Applications', 'Admin viewed declined applications for area: ' . $adminArea);

    // Fetch applications where city matches the admin's area and status is 'Declined'
    $data['applications'] = $applicationModel
        ->where('city', $adminArea)
        ->where('status', 'Declined')
        ->findAll();

    return view('admin/declined_applications', $data);
}


public function admit()
{
    if (!$this->request->isAJAX()) {
        return $this->response->setStatusCode(403)->setJSON(['message' => 'Forbidden']);
    }

    $appId = $this->request->getPost('application_id');
    $model = new \App\Models\ApplicationModel();

    // Update status to 'Approved'
    $model->update($appId, ['status' => 'Approved']);

    // Log the action
    $admin_id = session()->get('admin_id');
    $admin_area = session()->get('area');
    log_action($admin_id, 'Approved Application', 'Approved application ID: ' . $appId, $admin_area);

    return $this->response->setJSON(['status' => 'success']);
}
public function decline()
{
    $applicationModel = new \App\Models\ApplicationModel();
    $request = $this->request;

    $appId = $request->getPost('application_id');
    $reason = $request->getPost('reason');

    if (!$appId || !$reason) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Missing required data.']);
    }

    // Update the application status to "Declined" and save the decline reason
    $updateData = [
        'status' => 'Declined',
        'decline_reason' => $reason
    ];

    $applicationModel->update($appId, $updateData);

    // Log the action
    $admin_id = session()->get('admin_id');
    $admin_area = session()->get('area');
    log_action($admin_id, 'Declined Application', 'Declined application ID: ' . $appId . ' | Reason: ' . $reason, $admin_area);

    return $this->response->setJSON(['status' => 'success', 'message' => 'Application declined.']);
}
public function reAdmitApplication()
{
    if ($this->request->isAJAX()) {
        $id = $this->request->getPost('id');

        $model = new \App\Models\ApplicationModel();
        $application = $model->find($id);

        if (!$application) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Application not found.'
            ]);
        }

        // Update status
        $model->update($id, ['status' => 'Pending']);

        // Log the action
        $admin_id = session()->get('admin_id');
        $admin_area = session()->get('area');
        log_action($admin_id, 'Re-admitted Application', 'Re-admitted application ID: ' . $id, $admin_area);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Application re-admitted.'
        ]);
    }

    return $this->response->setJSON([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
}


public function subscribersList()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('admin/login');
    }

    $adminArea = session()->get('area');
    $adminId = session()->get('admin_id');
    $model = new \App\Models\SubscriberModel();

    // Get subscribers that belong to the admin's area
    $subscribers = $model
    ->where('city', $adminArea)
    ->orderBy('account_number IS NULL DESC, created_at DESC', '', false)
    ->findAll();


    // Log the action
    log_action($adminId, 'Viewed Subscribers', 'Viewed subscriber list for area: ' . $adminArea, $adminArea);

    // Pass admin area to the view
    return view('admin/subscribers_list', [
        'subscribers' => $subscribers,
        'adminArea' => $adminArea,
    ]);
}

public function predictAccountNumber($city)
{
    $model = new \App\Models\SubscriberModel();

    // Get the highest account_number in the same city (assuming numeric)
    $subscriber = $model->select('account_number')
        ->where('city', urldecode($city))
        ->where('account_number IS NOT NULL', null, false)
        ->orderBy('CAST(account_number AS UNSIGNED)', 'DESC')
        ->first();

    $next = 1000; // Default starting number

    if ($subscriber && is_numeric($subscriber['account_number'])) {
        $next = str_pad(intval($subscriber['account_number']) + 1, 6, '0', STR_PAD_LEFT);
    }

    return $this->response->setJSON(['next_account_number' => (string)$next]);
}

public function addSubscriber()
{
    $subscriberModel = new SubscriberModel();

    $data = [
        'first_name'       => $this->request->getPost('first_name'),
        'middle_name'      => $this->request->getPost('middle_name'),
        'last_name'        => $this->request->getPost('last_name'),
        'contact_number1'  => $this->request->getPost('contact_number1'),
        'contact_number2'  => $this->request->getPost('contact_number2'),
        'email'            => $this->request->getPost('email'),
        'address'          => $this->request->getPost('address'),
        'city'             => session()->get('area'),
        'plan'             => $this->request->getPost('plan'),
        'account_number'   => $this->request->getPost('account_number'),
        'status'           => $this->request->getPost('status'),
    ];

    $subscriberModel->insert($data);

    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Subscriber added successfully.'
    ]);
}


public function updateSubscriberStatus()
{
    if ($this->request->getMethod() !== 'POST') {
        return $this->response->setStatusCode(405)->setBody('Invalid request method.');
    }

    $id = $this->request->getPost('id');
    $status = $this->request->getPost('status');
    $allowedStatuses = ['Active', 'Disconnected', 'For Pull Out', 'Pulled Out'];

    helper('log'); // optional helper for logging

    log_message('info', "Updating subscriber ID: $id to status: $status");

    if (!in_array($status, $allowedStatuses)) {
        log_message('error', "Invalid status attempted: $status");
        return $this->response->setStatusCode(400)->setBody('Invalid status.');
    }

    $model = new \App\Models\SubscriberModel();
    $subscriber = $model->find($id);

    if (!$subscriber) {
        log_message('error', "Subscriber not found with ID: $id");
        return $this->response->setStatusCode(404)->setBody('Subscriber not found.');
    }

    $updated = $model->update($id, ['status' => $status]);

    if (!$updated) {
        log_message('error', "Failed to update subscriber ID: $id");
        return $this->response->setStatusCode(500)->setBody('Failed to update status.');
    }

    log_message('info', "Subscriber ID: $id status updated successfully to $status.");

    return $this->response->setStatusCode(200)->setBody("Status updated to $status.");
}


// Update Subscriber Info
public function updateSubscriber()
{
    if ($this->request->isAJAX()) {
        $subscriberId = $this->request->getPost('subscriber_id');
        $firstName = $this->request->getPost('first_name');
        $lastName = $this->request->getPost('last_name');
        $contactNumber1 = $this->request->getPost('contact_number1');
        $plan = $this->request->getPost('plan');

        if (empty($firstName) || empty($lastName) || empty($contactNumber1) || empty($plan)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'All fields are required.'
            ]);
        }

        $subscriberModel = new \App\Models\SubscriberModel();
        $data = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'contact_number1' => $contactNumber1,
            'plan' => $plan
        ];

        $updateSuccess = $subscriberModel->update($subscriberId, $data);

        if ($updateSuccess) {
            log_action(session()->get('admin_id'), 'Updated Subscriber Info', 'Subscriber ID: ' . $subscriberId, session()->get('area'));
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Subscriber information updated successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to update subscriber information.'
            ]);
        }
    }

    return redirect()->back();
}
public function getSubscriber($id = null)
{
    if ($this->request->isAJAX()) {
        $subscriberModel = new \App\Models\SubscriberModel();
        $subscriber = $subscriberModel->find($id);

        if ($subscriber) {
            return $this->response->setJSON([
                'status' => 'success',
                'subscriber' => $subscriber
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Subscriber not found.'
            ]);
        }
    }

    return redirect()->back();
}

// Connect Subscriber
public function connectSubscriber()
{
    $subscriberId = $this->request->getPost('subscriber_id');
    if (!$subscriberId) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid subscriber ID.'
        ]);
    }

    $subscriberModel = new \App\Models\SubscriberModel();
    $subscriber = $subscriberModel->find($subscriberId);

    if (empty($subscriber['account_number'])) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Cannot connect. Subscriber has no account number.'
        ]);
    }

    $updated = $subscriberModel->update($subscriberId, ['status' => 'Active']);

    if ($updated) {
        log_action(session()->get('admin_id'), 'Connected Subscriber', 'Subscriber ID: ' . $subscriberId, session()->get('area'));
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Subscriber connected successfully.'
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to connect subscriber.'
        ]);
    }
}

// Disconnect Subscriber
public function disconnectSubscriber()
{
    $subscriberId = $this->request->getPost('subscriber_id');
    if (!$subscriberId) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid subscriber ID.'
        ]);
    }

    $subscriberModel = new \App\Models\SubscriberModel();
    $updated = $subscriberModel->update($subscriberId, ['status' => 'Disconnected']);

    if ($updated) {
        log_action(session()->get('admin_id'), 'Disconnected Subscriber', 'Subscriber ID: ' . $subscriberId, session()->get('area'));
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Subscriber disconnected successfully.'
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to disconnect subscriber.'
        ]);
    }
}

// Save/Update Account Number
public function saveAccountNumber()
{
    $id = $this->request->getPost('subscriber_id');
    $accountNumber = $this->request->getPost('account_number');

    $model = new \App\Models\SubscriberModel();

    if (!$id || !$accountNumber) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Missing subscriber ID or account number.'
        ]);
    }

    $existingSubscriber = $model->where('account_number', $accountNumber)->first();
    if ($existingSubscriber && $existingSubscriber['id'] != $id) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Account number is already in use by another subscriber.'
        ]);
    }

        $updated = $model->update($id, [
            'account_number' => $accountNumber,
            'status' => 'Active'
        ]);
    if ($updated) {
        log_action(session()->get('admin_id'), 'Saved Account Number', 'Subscriber ID: ' . $id . ', Account #: ' . $accountNumber, session()->get('area'));
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Account number updated successfully.'
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to update account number.'
        ]);
    }
}


    


public function sendToTechnician()
{
    if (!session()->get('isLoggedIn')) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Unauthorized access'
        ]);
    }

    $applicationId = $this->request->getPost('application_id');
    $scheduleDate = $this->request->getPost('schedule_date');

    // Validate input
    if (!$applicationId || !$scheduleDate) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Missing application ID or schedule date.'
        ]);
    }

    $applicationModel = new \App\Models\ApplicationModel();
    $installRequestModel = new \App\Models\InstallRequestModel();

    // Check if the application exists
    $application = $applicationModel->find($applicationId);
    if (!$application) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Application not found.'
        ]);
    }

    // Insert install request
    $data = [
        'application_id' => $applicationId,
        'schedule_date' => $scheduleDate,
        'status' => 'Pending'
    ];

    if (!$installRequestModel->insert($data)) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to send request to technician.'
        ]);
    }

    // Update application status
    $updateStatus = $applicationModel->update($applicationId, ['app_status' => 'Assigned']);
    if (!$updateStatus) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Install request added, but failed to update application status.'
        ]);
    }

    // ✅ Log the action
    log_action(session()->get('admin_id'), 'Sent Install Request', 'Application ID: ' . $applicationId, session()->get('area'));

    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Installation request successfully sent to technician.'
    ]);
}

public function installTickets()
{
    // Check if the admin is logged in
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/admin/login');
    }

    // Get the admin area from the session
    $adminArea = session()->get('area');
    
    // Initialize the database connection
    $db = \Config\Database::connect();

    // Build the query to get the install tickets
    $builder = $db->table('applications');
    $builder->select('applications.*, install_requests.schedule_date');
    $builder->orderBy('install_requests.schedule_date', 'DESC');
    $builder->join('install_requests', 'install_requests.application_id = applications.id', 'inner'); // Inner join to ensure only apps with install_requests
    $builder->where('applications.city', $adminArea);
    // $builder->whereIn('applications.app_status', ['Assigned', 'On-going']); // ✅ Only show Assigned

    $query = $builder->get();
    $data['applications'] = $query->getResultArray();

    // Log the admin action for viewing the install tickets
    log_action(session()->get('admin_id'), 'Viewed Install Tickets', 'Admin viewed install tickets for area: ' . $adminArea, session()->get('area'));

    // Return the view with the data
    return view('admin/install_tickets', $data);
}


public function showGenerateRepairForm()
{
    $adminArea = session()->get('area');
    $subscriberModel = new SubscriberModel();

    // Assuming 'location' is the subscriber's city
    $subscribers = $subscriberModel
                    ->where('city', $adminArea)
                    ->where('status', 'Active') // Optional: only connected users
                    ->findAll();

    // Log the admin's action for viewing the subscriber list
    log_action(session()->get('admin_id'), 'Viewed Subscriber List for Repair Tickets', 'Admin viewed the list of connected subscribers in area: ' . $adminArea, session()->get('area'));

    return view('admin/generate_repair_ticket', ['subscribers' => $subscribers]);
}


public function submitRepairTicket()
{
    $subscriberId = $this->request->getPost('subscriber_id');
    $issue = $this->request->getPost('issue');
    $description = $this->request->getPost('description');
    $scheduledDate = $this->request->getPost('scheduled_date');

    if (empty($subscriberId) || empty($issue) || empty($scheduledDate)) {
        return redirect()->back()->with('error', 'All fields are required.');
    }

    // Load SubscriberModel to fetch the account number
    $subscriberModel = new \App\Models\SubscriberModel();
    $subscriber = $subscriberModel->find($subscriberId);

    if (!$subscriber) {
        return redirect()->back()->with('error', 'Subscriber not found.');
    }

    $accountNumber = $subscriber['account_number'];

    $ticketModel = new \App\Models\TicketModel();

    $data = [
        'subscriber_id'   => $subscriberId,
        'account_number'  => $accountNumber,
        'issue'           => $issue,
        'description'     => $description,
        'scheduled_date'  => $scheduledDate,
        'status'          => 'Open',
        'created_at'      => date('Y-m-d H:i:s')
    ];

    if ($ticketModel->insert($data)) {
        // Log the creation of the repair ticket
        log_action(session()->get('admin_id'), 'Created Repair Ticket', 'Repair ticket created for Subscriber ID: ' . $subscriberId . ' with issue: ' . $issue, session()->get('area'));
        return redirect()->to('/admin/tickets')->with('success', 'Repair ticket created successfully.');
    } else {
        return redirect()->back()->with('error', 'Failed to create repair ticket.');
    }
}


public function rescheduledTickets()
{
    $id = $this->request->getPost('id'); // Application ID
    $newDate = $this->request->getPost('schedule_date');
    $reason = $this->request->getPost('app_reason');

    $applicationModel = new \App\Models\ApplicationModel();
    $installTicketModel = new \App\Models\InstallTicketModel();

    // Begin a database transaction
    $db = \Config\Database::connect();
    $db->transStart();

    // 1. Update applications table
    $applicationModel->update($id, [
        'schedule_date' => $newDate,
        'app_status' => 'Assigned',
        'app_reason' => $reason
    ]);

    // 2. Update install_requests table
    $installTicketModel
        ->set('schedule_date', $newDate)
        ->where('application_id', $id)
        ->update();

    // Complete the transaction
    $db->transComplete();

    if ($db->transStatus() === false) {
        return redirect()->back()->with('error', 'Failed to update installation schedule.');
    }

    // Log the action
    log_action(session()->get('admin_id'), 'Rescheduled Installation', 'Installation schedule updated for Ticket ID: ' . $id . ' to new date: ' . $newDate . ' with reason: ' . $reason, session()->get('area'));

    return redirect()->back()->with('success', 'Installation schedule updated successfully.');
}

public function generate_repair_ticket_form()
{
    $adminCity = session()->get('admin_location'); // Set this during login

    // Log the action of viewing the repair ticket generation form
    log_action(session()->get('admin_id'), 'Viewed Repair Ticket Generation Form', 'Admin viewed the repair ticket generation form for city: ' . $adminCity, session()->get('area'));

    $subscribers = $this->subscriberModel
        ->where('city', $adminCity)
        ->whereNotNull('account_number')
        ->where('status', 'Active')
        ->findAll();

    return view('admin/generate_repair_ticket', [
        'subscribers' => $subscribers
    ]);
}

public function save_schedule_ajax()
{
    if (!$this->request->isAJAX()) {
        return $this->response->setStatusCode(403, 'Forbidden');
    }

    $id = $this->request->getPost('ticket_id');
    $date = $this->request->getPost('schedule_date');

    if (!$id || !$date) {
        return $this->response->setStatusCode(400, 'Missing data');
    }

    $repairModel = new RepairTicketModel();
    $repairModel->update($id, [
        'schedule_date' => $date,
        'status' => 'On-going'
    ]);

    // Log the action of saving the schedule for the repair ticket
    log_action(session()->get('admin_id'), 'Scheduled Repair Ticket', 'Scheduled repair ticket ID: ' . $id . ' with date: ' . $date, session()->get('area'));

    return $this->response->setJSON(['status' => 'success']);
}

    
public function Tickets()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/admin/login');
    }

    $adminArea = session()->get('area');
    $db = \Config\Database::connect();

    // Fetch install requests
    $installBuilder = $db->table('applications');
    $installBuilder->select('applications.*, install_requests.id AS install_request_id, install_requests.schedule_date');
    $installBuilder->orderBy('install_requests.schedule_date', 'DESC');
    $installBuilder->join('install_requests', 'install_requests.application_id = applications.id', 'inner');
    $installBuilder->where('applications.city', $adminArea);
    $installQuery = $installBuilder->get();
    $data['installRequests'] = $installQuery->getResultArray();

    // Fetch repair tickets
    $repairBuilder = $db->table('repair_tickets');
    $repairBuilder->select('repair_tickets.*, subscribers.first_name, subscribers.last_name, subscribers.contact_number1, subscribers.address, subscribers.city');
    $repairBuilder->join('subscribers', 'subscribers.id = repair_tickets.subscriber_id', 'inner');
    $repairBuilder->orderBy('repair_tickets.updated_at', 'DESC');
    $repairBuilder->where('subscribers.city', $adminArea);
    $repairQuery = $repairBuilder->get();
    $data['repairRequests'] = $repairQuery->getResultArray();

    // Fetch active subscribers (for generate repair form)
    $subscriberModel = new \App\Models\SubscriberModel();
    $data['subscribers'] = $subscriberModel
                            ->where('city', $adminArea)
                            ->where('status', 'Active')
                            ->findAll();

    // Log the admin's access to the tickets page
    log_action(session()->get('admin_id'), 'Viewed Tickets', 'Admin viewed install and repair tickets for area: ' . $adminArea, $adminArea);

    return view('admin/tickets', $data);
}


   public function reschedRepair($ticketId)
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/admin/login');
    }

    $newDate = $this->request->getPost('new_date');
    $status = $this->request->getPost('status');
    $newReason = null;

    // Load your model
    $repairTicketModel = new \App\Models\RepairTicketModel();

    // Update the ticket
    $data = [
        'schedule_date' => $newDate,
        'status' => $status, // Set status to 'Open'
        'reason' => $newReason
    ];

    $repairTicketModel->update($ticketId, $data);

    // Log the action of rescheduling the repair ticket
    log_action(session()->get('admin_id'), 'Rescheduled Repair Ticket', 'Rescheduled repair ticket ID: ' . $ticketId . ' to new date: ' . $newDate . ' with status: ' . $status, session()->get('area'));

    // Return a response to AJAX
    return $this->response->setJSON(['success' => true]);
}
public function getByInstallId($install_id)
{
    $model = new \App\Models\InstallMaterialsModel();
    $data = $model->where('install_id', $install_id)->first();

    if ($data) {
        return $this->response->setJSON($data);
    } else {
        return $this->response->setStatusCode(404)->setJSON(['message' => 'No report found.']);
    }
}

   public function update_schedule($ticketId, $newDate)
{
    try {
        $db = \Config\Database::connect();
        $builder = $db->table('repair_tickets');
    
        // Check if the ticket exists
        $ticket = $builder->where('id', $ticketId)->get()->getRow();
        if (!$ticket) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ticket not found']);
        }
    
        // Update the scheduled date and change status to 'On-going'
        $builder->where('id', $ticketId)
                ->update(['scheduled_date' => $newDate, 'status' => 'Open', 'reason' => null]); // Assuming `scheduled_date` is the column

        // Log the action of updating the repair ticket schedule
        log_action(session()->get('admin_id'), 'Updated Repair Ticket Schedule', 'Updated schedule for repair ticket ID: ' . $ticketId . ' to new date: ' . $newDate, session()->get('area'));

        return $this->response->setJSON(['success' => true, 'message' => 'Schedule updated successfully']);
    } catch (\Exception $e) {
        return $this->response->setJSON(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
}
public function updateSchedule($applicationId, $scheduleDate)
{
    $db = \Config\Database::connect();
    $db->transStart();

    try {
        // ✅ Sanitize and validate date
        $formattedDate = date('Y-m-d', strtotime($scheduleDate));
        if (!$formattedDate) {
            throw new \Exception('Invalid date format.');
        }

        // ✅ Update the applications table
        $applicationModel = new \App\Models\ApplicationModel();
        $applicationUpdate = $applicationModel->set([
            'app_status' => 'Assigned',
            'app_reason' => null,
        ])
        ->where('id', $applicationId)
        ->update();

        // ✅ Update the install_requests table
        $installTicketModel = new \App\Models\InstallTicketModel();
        $installRequestUpdate = $installTicketModel->set([
            'schedule_date' => $formattedDate,
            'status' => 'Pending',
        ])
        ->where('application_id', $applicationId)
        ->update();

        // Check if both updates were successful
        if (!$applicationUpdate || !$installRequestUpdate) {
            throw new \Exception('Failed to update one or both tables.');
        }

        $db->transComplete();

        // ✅ Return JSON success response
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Schedule updated successfully.'
        ]);
    } catch (\Exception $e) {
        $db->transRollback();
        log_message('error', 'Update Install Request Error: ' . $e->getMessage());

        // ❌ Return JSON error response
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
}


    
    // public function billings()
    // {
    //     if (!session()->get('isLoggedIn')) {
    //         return redirect()->to('/admin/login');
    //     }

    //     $db = \Config\Database::connect();
    //     $adminArea = session()->get('area');

    //     // Find subscribers in the admin's area who don't have a billing_day set yet
    //     $subscribers = $db->table('subscribers')
    //         ->where('city', $adminArea)
    //         ->where('billing_day IS NULL')  // use raw query for NULL check
    //         ->get()
    //         ->getResultArray();

    //     // Log the action of viewing billings
    //     log_action(session()->get('admin_id'), 'Viewed Billings', 'Admin viewed billings for area: ' . $adminArea, $adminArea);

    //     return view('admin/billings', ['subscribers' => $subscribers]);
    // }

   public function saveBillingDate()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/admin/login');
    }

    $subscriber_id = $this->request->getPost('subscriber_id');
    $billing_day = $this->request->getPost('billing_day');
    $price_to_pay = $this->request->getPost('price_to_pay');

    if (empty($subscriber_id) || empty($billing_day) || empty($price_to_pay)) {
        return redirect()->back()->with('error', 'All fields are required');
    }

    try {
        $subscriberModel = new SubscriberModel();
        $billingModel = new BillsModel();
        $financeModel = new FinanceModel();

        $subscriber = $subscriberModel->find($subscriber_id);
        if (!$subscriber) {
            return redirect()->back()->with('error', 'Subscriber not found.');
        }

        // ✅ Make sure billing day was not already set
        if (!empty($subscriber['billing_day'])) {
            return redirect()->back()->with('error', 'Billing day has already been set for this subscriber.');
        }

        // ✅ Set billing day and price
        $subscriberModel->update($subscriber_id, [
            'billing_day' => $billing_day,
            'price_to_pay' => $price_to_pay,
        ]);

        // ✅ Now send the email notification AFTER updating
        function getOrdinal($number)
        {
            if (!in_array(($number % 100), [11, 12, 13])) {
                switch ($number % 10) {
                    case 1:  return $number . 'st';
                    case 2:  return $number . 'nd';
                    case 3:  return $number . 'rd';
                }
            }
            return $number . 'th';
        }

        $ordinalDay = getOrdinal($billing_day);
        $accountNumber = $subscriber['account_number'];
        $emailBody = "
            <p>Hello <strong>{$subscriber['first_name']} {$subscriber['last_name']}</strong>,</p>
            <p>Your billing day has been set.</p>
            <p><strong>Account Number:</strong> {$accountNumber}</p>
            <p><strong>Billing Day:</strong> Every {$ordinalDay} day of the month.</p>
            <br>
            <p>Please Expect that you will receive an e-mail 7 (seven) days before your Billing Day with regards on settling your account.</p> 
            <p>Thank you for choosing Allstar Tech Wireless Hotspot and Internet Services!</p>
        ";

        $mailSender = new MailSender();
        $mailSender->send(
            $subscriber['email'], 
            $subscriber['first_name'] . ' ' . $subscriber['last_name'], 
            'Billing Day Confirmation', 
            $emailBody
        );

        // ✅ Continue with billing and finance records
        $now = date('Y-m-d H:i:s');
        $fullName = $subscriber['first_name'] . ' ' . $subscriber['last_name'];
        $invoiceNumber = 'INSTALL-' . strtoupper(uniqid());

        $today = date('Y-m-d');
        $currentMonth = date('m');
        $currentYear = date('Y');

        $dueDay = (int) $billing_day;
        $dueDateThisMonth = date('Y-m-d', strtotime("$currentYear-$currentMonth-$dueDay"));

        if (strtotime($dueDateThisMonth) < strtotime($today)) {
            // If the billing day this month already passed, move to next month
            $nextMonth = date('m', strtotime('+1 month'));
            $nextYear = date('Y', strtotime('+1 month'));
            $dueDate = date('Y-m-d', strtotime("$nextYear-$nextMonth-$dueDay"));
        } else {
            $dueDate = $dueDateThisMonth;
        }
        $billingModel->insert([
            'subscriber_id' => $subscriber_id,
            'billing_day' => $billing_day,
            'price_to_pay' => $price_to_pay,
            'status' => 'paid',
            'invoice_number' => $invoiceNumber,
            'paid_date' => $now,
            'created_at' => $now,
            'due_date' => $dueDate,
        ]);

        $financeModel->insert([
            'type' => 'revenue',
            'category' => 'Installation Fee: ' . $fullName,
            'amount' => 1000,
            'record_date' => $now,
            'month_tag' => date('F'),
            'created_by' => session()->get('area'),
            'description' => 'Account Number: ' . $accountNumber,
            'created_at' => $now,
        ]);

        log_action(
            session()->get('admin_id'),
            'Set Billing Info + Install Fee',
            'Set billing info and installation fee paid for subscriber ID: ' . $subscriber_id,
            session()->get('area')
        );

        return redirect()->back()->with('success', 'Billing info set. ₱1000 Installation Fee has been recorded as paid.');
    } catch (\Throwable $e) {
        log_message('error', 'Billing Error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Server error: ' . $e->getMessage());
    }
}
    
public function updateInstallStatus($installId)
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/admin/login');
    }

    // Get the status and reason from the POST request
    $status = $this->request->getPost('status');
    $reason = $this->request->getPost('reason');

    // Load the necessary models
    $installModel = new InstallRequestModel();
    $applicationModel = new ApplicationModel();

    // Retrieve the install request using the ID
    $installRequest = $installModel->find($installId);
    if (!$installRequest) {
        return $this->response->setJSON(['success' => false, 'message' => 'Install request not found']);
    }

    // Retrieve the associated application record using application_id
    $application = $applicationModel->find($installRequest['application_id']);
    if (!$application) {
        return $this->response->setJSON(['success' => false, 'message' => 'Application not found']);
    }

    // Prepare the data to update both tables
    $data = [
        'status' => 'Pending',  // Update status in install_requests table
    ];

    // Only set the reason if the status is 'Re-schedule' or 'Cancelled'
    if (in_array($status, ['Re-schedule', 'Cancelled'])) {
        $data['reason'] = $reason; // Store reason in install_requests table
    }

    // Update the status of the install request
    $installModel->update($installId, $data);

    // Prepare data to update the related application table
    $applicationData = [
        'status' => 'Approved',  // Update status to 'Pending' in applications table
        'app_status' => 'Assigned', // Also set app_status to 'Pending'
    ];

    // Update the application status to 'Pending'
    $applicationModel->update($installRequest['application_id'], $applicationData);

    // Log the action of updating the install request
    log_action(session()->get('admin_id'), 'Updated Install Request Status', 'Updated install request ID: ' . $installId . ' to status: ' . $status . (isset($reason) ? ' with reason: ' . $reason : ''), session()->get('area'));

    // Return a success response
    return $this->response->setJSON(['success' => true, 'message' => 'Install request re-scheduled successfully']);
}

// Generate Subscribers Report
public function generateSubscribersReport()
{
    try {
        $adminArea = session()->get('area');
        
        if (!$adminArea) {
            return redirect()->to('/admin/dashboard')->with('error', 'Admin area not set.');
        }

        $model = new SubscriberModel();
        $subscribers = $model->where('city', $adminArea)->findAll();  

        if (empty($subscribers)) {
            return redirect()->to('/admin/dashboard')->with('error', 'No subscribers found.');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set column headers
        $sheet->setCellValue('A1', 'Account Number');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Address');
        $sheet->setCellValue('E1', 'City');
        $sheet->setCellValue('F1', 'Contact Number(s)');
        $sheet->setCellValue('G1', 'Plan');
        $sheet->setCellValue('G1', 'Status');

        $row = 2;
        foreach ($subscribers as $subscriber) {
            $sheet->setCellValue('A' . $row, $subscriber['account_number']);
            $sheet->setCellValue('B' . $row, $subscriber['first_name'] . ' ' . $subscriber['middle_name'] . ' ' . $subscriber['last_name']);
            $sheet->setCellValue('C' . $row, $subscriber['email']);
            $sheet->setCellValue('D' . $row, $subscriber['address']);
            $sheet->setCellValue('E' . $row, $subscriber['city']);
            $sheet->setCellValue('F' . $row, $subscriber['contact_number1'] . '/' . $subscriber['contact_number2']);
            $sheet->setCellValue('G' . $row, $subscriber['plan']);
            $sheet->setCellValue('G' . $row, $subscriber['status']);
            $row++;
        }

        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'SubscribersReport-' . date('Y-m-d') . '.xlsx';

        // Set headers for file download
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // ✅ Log action before sending the output
        log_action(
            session()->get('admin_id'), 
            'Generated Subscribers Report', 
            'Generated subscribers report for area: ' . $adminArea, 
            $adminArea
        );

        $writer->save('php://output');
        exit;

    } catch (\Exception $e) {
        log_message('error', 'Error generating subscribers report: ' . $e->getMessage());
        return redirect()->to('/admin/dashboard')->with('error', 'Failed to generate report.');
    }
}


    // Generate Billing Report (This can be extended once the database is updated)
public function generateBillingReport()
{
        // ✅ Log action before sending the output
    log_action(
        session()->get('admin_id'), 
        'Generated Billing Report', 
        'Generated billing report by admin at ' . date('Y-m-d H:i:s'), 
        session()->get('area')
    );
    $billsModel = new BillsModel();
    $billingData = $billsModel->getAllWithSubscribers();

    // Filename with date
    $filename = 'billing_report_' . date('Y-m-d_H-i-s') . '.csv';

    // Set headers for file download
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$filename");
    header("Content-Type: application/csv");

    // Open output stream
    $file = fopen('php://output', 'w');

    // Output the header
    fputcsv($file, ['Invoice #', 'Account Number', 'Name', 'Billing Day', 'Amount', 'Status', 'Paid Date']);

    // Output each record
    foreach ($billingData as $row) {
        fputcsv($file, [
            $row['invoice_number'],
            $row['account_number'],
            $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'],
            $row['billing_day'],
            number_format($row['price_to_pay'], 2),
            $row['status'],
            $row['paid_date'] ?? 'N/A',
        ]);
    }

    fclose($file);
    exit;
}
 public function generateInstallTicketsReport()
{
    try {
        $adminArea = session()->get('area');
        $month = $this->request->getGet('month'); // Format: 2025-04

        if (!$adminArea || !$month) {
            throw new \Exception('Missing area or month.');
        }

        $model = new \App\Models\ApplicationModel();

        $builder = $model->asArray()
            ->select('install_requests.schedule_date, install_requests.status, applications.first_name, applications.middle_name, applications.last_name, applications.email, applications.house_number, applications.apartment, applications.city, applications.contact_number1, applications.contact_number2, applications.plan')
            ->join('install_requests', 'install_requests.application_id = applications.id')
            ->where('applications.city', $adminArea)
            ->like('install_requests.schedule_date', $month, 'after')
            ->where('install_requests.status', 'Installed');

        $results = $builder->findAll();

        // ✅ Log action before sending the output
        log_action(
            session()->get('admin_id'), 
            'Generated Install Tickets Report', 
            'Generated Install Tickets report for area: ' . $adminArea . ' for month: ' . $month, 
            $adminArea
        );

        // Generate Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set Headers
        $headers = ['Date Installed', 'Status', 'Name', 'Email', 'Address', 'City', 'Contact Numbers', 'Plan'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        $row = 2;
        foreach ($results as $data) {
            $sheet->setCellValue('A' . $row, $data['schedule_date']);
            $sheet->setCellValue('B' . $row, $data['status']);
            $sheet->setCellValue('C' . $row, $data['first_name'] . ' ' . $data['middle_name'] . ' ' . $data['last_name']);
            $sheet->setCellValue('D' . $row, $data['email']);
            $sheet->setCellValue('E' . $row, $data['house_number'] . ' ' . $data['apartment']);
            $sheet->setCellValue('F' . $row, $data['city']);
            $sheet->setCellValue('G' . $row, $data['contact_number1'] . '/' . $data['contact_number2']);
            $sheet->setCellValue('H' . $row, $data['plan']);
            $row++;
        }

        // Clean output buffer to avoid corruption
        if (ob_get_length()) {
            ob_end_clean();
        }
        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Output file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="InstallTicketsReport-' . $month . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;

    } catch (\Throwable $e) {
        log_message('error', 'Excel export failed: ' . $e->getMessage());
        echo 'Failed to generate report: ' . $e->getMessage();
    }
}


   public function generateRepairTicketsReport()
{
    try {
        $adminArea = session()->get('area');
        $month = $this->request->getGet('month'); // Format: 2025-04

        if (!$adminArea || !$month) {
            throw new \Exception('Missing area or month.');
        }

        $model = new \App\Models\SubscriberModel();

        $builder = $model->asArray()
            ->select('repair_tickets.scheduled_date, repair_tickets.status, subscribers.account_number, subscribers.first_name, subscribers.middle_name, subscribers.last_name, subscribers.email, subscribers.address, subscribers.city, subscribers.contact_number1, subscribers.contact_number2, subscribers.plan, repair_tickets.issue')
            ->join('repair_tickets', 'repair_tickets.subscriber_id = subscribers.id')
            ->where('subscribers.city', $adminArea)
            ->like('repair_tickets.scheduled_date', $month, 'after')
            ->where('repair_tickets.status', "Resolved");

        $results = $builder->findAll();

        // ✅ Log action before sending the output
        log_action(
            session()->get('admin_id'), 
            'Generated Repair Tickets Report', 
            'Generated Repair Tickets report for area: ' . $adminArea . ' for month: ' . $month, 
            $adminArea
        );

        // Generate Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set Headers
        $headers = ['Account Number', 'Status', 'Issue', 'Name', 'Email', 'Address', 'City', 'Contact Numbers', 'Plan', 'Date Resolved'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        $row = 2;
        foreach ($results as $data) {
            $fullName = trim($data['first_name'] . ' ' . ($data['middle_name'] ?? '') . ' ' . $data['last_name']);
            $sheet->setCellValue('A' . $row, $data['account_number']);
            $sheet->setCellValue('B' . $row, $data['status']);
            $sheet->setCellValue('C' . $row, $data['issue']);
            $sheet->setCellValue('D' . $row, $fullName);
            $sheet->setCellValue('E' . $row, $data['email']);
            $sheet->setCellValue('F' . $row, $data['address']);
            $sheet->setCellValue('G' . $row, $data['city']);
            $sheet->setCellValue('H' . $row, $data['contact_number1'] . '/' . $data['contact_number2']);
            $sheet->setCellValue('I' . $row, $data['plan']);
            $sheet->setCellValue('J' . $row, $data['scheduled_date']);
            $row++;
        }

        if (ob_get_length()) {
            ob_end_clean();
        }

        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="RepairTicketsReport-' . $month . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;

    } catch (\Throwable $e) {
        log_message('error', 'Excel export failed: ' . $e->getMessage());
        echo 'Failed to generate report: ' . $e->getMessage();
    }
}
public function fetch_logs()
{
    $session = session();
    $currentArea = $session->get('area');

    $db = \Config\Database::connect();
    $builder = $db->table('action_logs');
    
    // Filter logs by current admin's area
    $builder->where('area', $currentArea);
    $builder->orderBy('timestamp', 'DESC');

    $query = $builder->get();
    $results = $query->getResult();

    // Transform the result
    $formatted = [];

    foreach ($results as $row) {
        $formatted[] = [
            'admin'     => 'Admin',  // replace admin_id with "Admin"
            'action'    => $row->action,
            'details'   => $row->details,
            'area'      => $row->area,
            'timestamp' => $row->timestamp,
        ];
    }

    return $this->response->setJSON($formatted);
}
public function billingStatus()
{
    $adminArea = session()->get('area');
    $billingModel = new \App\Models\BillsModel();

    $data['billing_records'] = $billingModel->getBillingByArea($adminArea);

    // Log action
    log_action(
        session()->get('admin_id'), 
        'Viewed Billing Status', 
        'Viewed billing status list at ' . date('Y-m-d H:i:s'), 
        $adminArea
    );

    return view('admin/billing_status', $data);
}

public function markPaid()
{
    if (!$this->request->isAJAX()) {
        return redirect()->to(base_url('admin/billing-status'));
    }

    $data = json_decode($this->request->getBody(), true);
    $id = $data['id'] ?? null;
    $paid_date = $data['paid_date'] ?? null;

    if (!$id || !$paid_date) {
        return $this->response->setJSON(['success' => false, 'message' => 'Invalid input']);
    }

    $BillsModel = new \App\Models\BillsModel();
    $SubscriberModel = new \App\Models\SubscriberModel();
    $FinanceModel = new \App\Models\FinanceModel();

    $bill = $BillsModel->find($id);
    if (!$bill) {
        return $this->response->setJSON(['success' => false, 'message' => 'Billing record not found.']);
    }

    $subscriber = $SubscriberModel->where('id', $bill['subscriber_id'])->first();
    if (!$subscriber) {
        return $this->response->setJSON(['success' => false, 'message' => 'Subscriber not found.']);
    }

    // Compose full name
    $subsName = trim(
        $subscriber['first_name'] . ' ' .
        (!empty($subscriber['middle_name']) ? $subscriber['middle_name'] . ' ' : '') .
        $subscriber['last_name']
    );

    // Generate Invoice Number
    $datePart = date('Ymd');
    $randomPart = mt_rand(1000, 9999);
    $invoiceNumber = 'INV-' . $datePart . '-' . $randomPart;

    // Format Billing Date
    $billingDay = (int)$bill['billing_day'];
    $currentYear = date('Y');
    $currentMonth = date('m');
    $currentMonthDate = \DateTime::createFromFormat('Y-m-d', "$currentYear-$currentMonth-01");
    $previousMonthDate = clone $currentMonthDate;
    $currentDueDate = new \DateTime($bill['due_date']);  // Convert string to DateTime object
    $dueDateString = $currentDueDate->format('Y-m-d');  // Now call format() safely
    $start_date = \DateTime::createFromFormat('Y-m-d', $previousMonthDate->format('Y-m-') . str_pad($billingDay, 2, '0', STR_PAD_LEFT));
    $end_date = \DateTime::createFromFormat('Y-m-d', $currentDueDate->format('Y-m-') . str_pad($billingDay, 2, '0', STR_PAD_LEFT));
    $bill_date = $start_date->format('F d, Y') . ' to ' . $end_date->format('F d, Y');

    // 🧠 Compute next due date (+1 month)
    if (!empty($bill['due_date'])) {
        $currentDueDate = new \DateTime($bill['due_date']);
    } else {
        $currentDueDate = \DateTime::createFromFormat('Y-m-d', "$currentYear-$currentMonth-" . str_pad($billingDay, 2, '0'));
    }

    $nextDueDate = clone $currentDueDate;
    $nextDueDate->modify('+1 month');

    $daysInNextMonth = (int)$nextDueDate->format('t');
    $adjustedDay = min($billingDay, $daysInNextMonth);
    $nextDueDate->setDate((int)$nextDueDate->format('Y'), (int)$nextDueDate->format('m'), $adjustedDay);

    $dueDateForDB = $nextDueDate->format('Y-m-d');
    $dueDate = $nextDueDate->format('F d, Y');

    // Compute MSF and VAT
    $to_be_payed = (float)$bill['price_to_pay'];
    $vat = round($to_be_payed * 0.12, 2);
    $msf = round($to_be_payed - $vat, 2);
    $monthTag = date('F', strtotime($paid_date));

    $updateData = [
        'status' => 'paid',
        'paid_date' => $paid_date,
        'invoice_number' => $invoiceNumber,
        'due_date' => $dueDateForDB
    ];

    if ($BillsModel->update($id, $updateData)) {
        $FinanceModel->insert([
            'type' => 'revenue',
            'category' => 'Monthly of Subscribers: ' . $subsName,
            'amount' => $to_be_payed,
            'record_date' => $paid_date,
            'month_tag' => $monthTag,
            'created_by' => session()->get('area'),
            'description' => 'FROM Account Number: ' . $subscriber['account_number'],
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $InvoiceHistoryModel = new \App\Models\InvoiceHistoryModel();
        $InvoiceHistoryModel->insert([
            'invoice_number' => $invoiceNumber,
            'subscriber_id' => $bill['subscriber_id'],
            'billing_day' => $bill['billing_day'],
            'price_to_pay' => $to_be_payed,
            'status' => 'paid',
            'paid_date' => $paid_date,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // Prepare invoice
        helper('invoice_helper');
        $invoicePath = WRITEPATH . 'invoices/' . $invoiceNumber . '.pdf';

        // Set logo
        $logoPath = FCPATH . 'assets/images/Logo.png';
        $logoData = '';
        if (file_exists($logoPath)) {
            $imageData = file_get_contents($logoPath);
            $mime = mime_content_type($logoPath);
            $logoData = 'data:' . $mime . ';base64,' . base64_encode($imageData);
        }

        $invoiceData = [
            'invoice_number' => $invoiceNumber,
            'account_number' => $subscriber['account_number'],
            'account_name' => $subsName,
            'address' => ($subscriber['address'] ?? '') . ', ' . ($subscriber['city'] ?? ''),
            'bill_date' => $bill_date,
            'due_date' => $dueDateString,
            'msf' => $msf,
            'vat' => $vat,
            'total' => $to_be_payed,
            'logo' => $logoData
        ];

        ini_set('max_execution_time', 180);
        set_time_limit(180);

        $pdfGenerated = createInvoicePDF($invoiceData, $invoiceNumber, $invoicePath);

        if ($pdfGenerated && file_exists($invoicePath)) {
            $mailSender = new \App\Libraries\MailSender();
            $subject = "Payment Confirmation - Invoice #{$invoiceNumber}";
            $body = "<p>Dear {$subsName},</p>
                     <p>Thank you for your payment. Attached is your official invoice.</p>
                     <p><strong>Invoice No:</strong> {$invoiceNumber}<br>
                     <strong>Amount Paid:</strong> ₱{$to_be_payed}<br>
                     <strong>Billing Period:</strong> {$bill_date}</p>
                     <p>Regards,<br>Allstar Tech Wireless</p>";

            $mailSender->send(
                $subscriber['email'],
                $subsName,
                $subject,
                $body,
                $invoicePath
            );

            log_action(
                session()->get('admin_id'),
                'Marked Billing as Paid',
                "Marked billing id {$id} as paid on {$paid_date} with Invoice #{$invoiceNumber}",
                session()->get('area')
            );

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Billing marked as paid. Invoice sent.',
                'invoice_number' => $invoiceNumber
            ]);
        } else {
            log_message('error', "Invoice PDF generation failed for invoice #{$invoiceNumber}");
            return $this->response->setJSON([
                'success' => false,
                'message' => 'PDF generation failed. Payment marked, but invoice not created.'
            ]);
        }
    }

    return $this->response->setJSON(['success' => false, 'message' => 'Failed to update billing status.']);
}


public function billings()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/admin/login');
    }

    $db = \Config\Database::connect();
    $adminArea = session()->get('area');

    // Subscribers without billing_day set (for the dropdown)
    $subscribers = $db->table('subscribers')
        ->where('city', $adminArea)
        ->where('billing_day IS NULL') // raw where for NULL check
        ->get()
        ->getResultArray();

    // Billing records with subscriber info (for the table)
    $billingModel = new \App\Models\BillsModel();
    $billing_records = $billingModel->getBillingByArea($adminArea);

    // Log the action
    log_action(session()->get('admin_id'), 'Viewed Billing Page', 'Viewed billing page for area: ' . $adminArea, $adminArea);

    return view('admin/billings', [
        'subscribers' => $subscribers,
        'billing_records' => $billing_records,
    ]);
}


public function autoMarkUnpaid()
{
    $billsModel = new BillsModel();

    $targetDay = date('d', strtotime('+7 days'));

    $billsModel->where('billing_day', $targetDay)
               ->where('status !=', 'Paid')
               ->set([
                   'status' => 'Unpaid',
                   'invoice_number' => null,
                   'paid_date' => null
               ])
               ->update();
}


    public function invoice($invoice_number)
    {
        $billsModel = new BillsModel();

        $bill = $billsModel->select('bills.*, subscribers.account_number, subscribers.first_name, subscribers.middle_name, subscribers.last_name, subscribers.address, subscribers.city, subscribers.billing_day, subscribers.price_to_pay')
            ->join('subscribers', 'subscribers.id = bills.subscriber_id')
            ->where('bills.invoice_number', $invoice_number)
            ->first();

        if (!$bill) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Invoice $invoice_number not found");
        }

        return view('invoice_view', ['subscriber' => $bill]);
    }


public function viewStatement($invoiceNumber)
{

    $billModel = new BillsModel();
    $subscriberModel = new SubscriberModel();

    // Fetch the bill
    $bill = $billModel->where('invoice_number', $invoiceNumber)->first();

    if (!$bill) {
        return "❌ No bill found for invoice number: $invoiceNumber";
    }

    // Fetch the related subscriber using subscriber_id in the bill
   $subscriber = $subscriberModel->where('id', $bill['subscriber_id'])->first();

    if (!$subscriber) {
        // Handle error - subscriber not found
        throw new \Exception("Subscriber not found for billing record.");
    }

    $imagePath = FCPATH . 'assets/images/Logo.png';

    if (!file_exists($imagePath)) {
        throw new \Exception("Logo image not found at $imagePath");
    }

    $imageData = file_get_contents($imagePath);
    $mime = mime_content_type($imagePath); // e.g. image/png
    $base64 = 'data:' . $mime . ';base64,' . base64_encode($imageData);

    $data['logo'] = $base64;
    //for due date and bill date
    $billingDay = (int)$bill['billing_day'];
    $currentYear = date('Y');
    $currentMonth = date('m');
    $currentMonthDate = \DateTime::createFromFormat('Y-m-d', "$currentYear-$currentMonth-01");
    $previousMonthDate = (clone $currentMonthDate)->modify('-1 month');
    $start_date = \DateTime::createFromFormat('Y-m-d', $previousMonthDate->format('Y-m-') . str_pad($billingDay, 2, '0', STR_PAD_LEFT));
    $end_date = \DateTime::createFromFormat('Y-m-d', $currentMonthDate->format('Y-m-') . str_pad($billingDay, 2, '0', STR_PAD_LEFT));

    $bill_date = $start_date->format('F d, Y') . ' to ' . $end_date->format('F d, Y');

    $dueDate = $currentMonth . ' ' . $billingDay . ', ' . $currentYear;
    
    //for computation of payment / breakdown
    $to_be_payed = (float) $bill['price_to_pay'];

    // Reverse compute to get MSF before VAT
    $vat = round($to_be_payed * 0.12, 2);
    $msf = round($to_be_payed - $vat, 2);


    if (strtotime("$currentYear-$currentMonth-$billingDay") < time()) {
        $dueDate = date('F', strtotime("$currentYear-$currentMonth-01")) . ' ' . str_pad($billingDay, 2, '0', STR_PAD_LEFT) . ', ' . $currentYear;

    }

       $data = [
    'bill' => [
        'invoice_number' => $bill['invoice_number'],
        'account_number' => $subscriber['account_number'],
        'account_name' => trim($subscriber['first_name'] . ' ' . $subscriber['middle_name'] . ' ' . $subscriber['last_name']),
        'address' => trim($subscriber['address'] . ', ' . $subscriber['city']),
        'amount' => $bill['price_to_pay'],
        'bill_date' => $bill_date,
        'due_date' => $dueDate,
        'msf' => $msf,
        'vat' => $vat,
        'total' => $to_be_payed,
        'logo' => $base64,
    ]
];
    try {
        $html = view('admin/billing_statement', $data);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        
        return $dompdf->stream($invoiceNumber . '.pdf', ['Attachment' => false]);
    } catch (\Throwable $e) {
        echo "❌ PDF Generation Error: " . $e->getMessage();
    }
}
public function downloadStatement($invoiceNumber)
{
    $billModel = new BillsModel();
    $subscriberModel = new SubscriberModel();

    // Fetch the bill
    $bill = $billModel->where('invoice_number', $invoiceNumber)->first();
    if (!$bill) {
        return "❌ No bill found for invoice number: $invoiceNumber";
    }

    // Fetch the related subscriber using subscriber_id in the bill
    $subscriber = $subscriberModel->where('id', $bill['subscriber_id'])->first();
    if (!$subscriber) {
        throw new \Exception("Subscriber not found for billing record.");
    }

    $imagePath = FCPATH . 'assets/images/Logo.png';
    if (!file_exists($imagePath)) {
        throw new \Exception("Logo image not found at $imagePath");
    }

    $imageData = file_get_contents($imagePath);
    $mime = mime_content_type($imagePath);
    $base64 = 'data:' . $mime . ';base64,' . base64_encode($imageData);

    // Calculate billing dates
    $billingDay = (int)$bill['billing_day'];
    $currentYear = date('Y');
    $currentMonth = date('m');
    $currentMonthDate = \DateTime::createFromFormat('Y-m-d', "$currentYear-$currentMonth-01");
    $previousMonthDate = (clone $currentMonthDate)->modify('-1 month');
    $start_date = \DateTime::createFromFormat('Y-m-d', $previousMonthDate->format('Y-m-') . str_pad($billingDay, 2, '0', STR_PAD_LEFT));
    $end_date = \DateTime::createFromFormat('Y-m-d', $currentMonthDate->format('Y-m-') . str_pad($billingDay, 2, '0', STR_PAD_LEFT));
    $bill_date = $start_date->format('F d, Y') . ' to ' . $end_date->format('F d, Y');

    $dueDate = $currentMonth . ' ' . $billingDay . ', ' . $currentYear;

    $to_be_payed = (float) $bill['price_to_pay'];
    $vat = round($to_be_payed * 0.12, 2);
    $msf = round($to_be_payed - $vat, 2);

    if (strtotime("$currentYear-$currentMonth-$billingDay") < time()) {
        $dueDate = date('F', strtotime("$currentYear-$currentMonth-01")) . ' ' . str_pad($billingDay, 2, '0', STR_PAD_LEFT) . ', ' . $currentYear;
    }

    $data = [
        'bill' => [
            'invoice_number' => $bill['invoice_number'],
            'account_number' => $subscriber['account_number'],
            'account_name' => trim($subscriber['first_name'] . ' ' . $subscriber['middle_name'] . ' ' . $subscriber['last_name']),
            'address' => trim($subscriber['address'] . ', ' . $subscriber['city']),
            'amount' => $bill['price_to_pay'],
            'bill_date' => $bill_date,
            'due_date' => $dueDate,
            'msf' => $msf,
            'vat' => $vat,
            'total' => $to_be_payed,
            'logo' => $base64,
        ]
    ];

    try {
        $html = view('admin/billing_statement', $data);

        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Extract year and month from invoice number
        // Assumes invoice number format like: INV-YYYYMMDD-xxxx or INV-YYYYMM-xxxx
        if (preg_match('/INV-(\d{6,8})/', $bill['invoice_number'], $matches)) {
            $yearMonth = substr($matches[1], 0, 6); // YYYYMM
        } else {
            $yearMonth = date('Ym'); // fallback current year month
        }

        // Convert YYYYMM to folder name "May Invoices" etc.
        $monthFolder = date('F', strtotime($yearMonth . '01')) . ' Invoices';

        // Base writable folder path
        $basePath = WRITEPATH . 'invoices';

        // Ensure base invoices folder exists
        if (!is_dir($basePath)) {
            mkdir($basePath, 0777, true);
        }

        // Full folder path for the month
        $folderPath = $basePath . DIRECTORY_SEPARATOR . $monthFolder;

        // Create monthly folder if not exist
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        // Full path for the PDF file
        $filePath = $folderPath . DIRECTORY_SEPARATOR . $invoiceNumber . '.pdf';

        // Save PDF file
        file_put_contents($filePath, $dompdf->output());

        // Send PDF to browser for download
        return $dompdf->stream($invoiceNumber . '.pdf', ['Attachment' => true]);

    } catch (\Throwable $e) {
        echo "❌ PDF Generation Error: " . $e->getMessage();
    }
}

// FINANCE PART

public function showCreateFinanceForm()
{
    $type = $this->request->getGet('type') ?? 'revenue';  // Default type
    return view('admin/finance/create_record', ['type' => $type]);
}

// Handle the form submission
public function storeFinanceRecord()
{
    $financeModel = new \App\Models\FinanceModel();

    $category = $this->request->getPost('category');
    $quantity = $this->request->getPost('quantity');

    // Default quantity if not Monthly or Installation and quantity not set
    if (!in_array($category, ['Monthly', 'Installation']) && empty($quantity)) {
        $quantity = '1';
    }

    $data = [
        'record_date' => $this->request->getPost('record_date'),
        'month_tag'   => date('F', strtotime($this->request->getPost('record_date'))),
        'type'        => $this->request->getPost('type'),
        'category'    => $category,
        'quantity'    => $quantity,
        'description' => $this->request->getPost('description'),
        'amount'      => $this->request->getPost('amount'),
        'created_by'  => session()->get('area'),
        'created_at'  => date('Y-m-d H:i:s'),
    ];

    if ($financeModel->insert($data)) {
        return redirect()->to(base_url('admin/finance/finance-records'))->with('success', ucfirst($data['type']) . ' record created successfully.');
    } else {
        // Dump model errors to check why insert failed
        dd($financeModel->errors());
        return redirect()->back()->withInput()->with('error', 'Failed to save.')->with('errors', $financeModel->errors());
    }
}

public function revenueAndExpenses()
{
    $FinanceModel = new \App\Models\FinanceModel();
    $area = session()->get('area');
    $month = $this->request->getGet('month') ?? date('F'); // Default to current month

    // Fetch revenue records
    $revenue = $FinanceModel->where('type', 'revenue')
                            ->where('created_by', $area)
                            ->where('month_tag', $month)
                            ->orderBy('created_at', 'DESC')
                            ->findAll();

    // Fetch expense records
    $expenses = $FinanceModel->where('type', 'expenses')
                             ->where('created_by', $area)
                             ->where('month_tag', $month)
                             ->orderBy('created_at', 'DESC')
                             ->findAll();

    return view('admin/finance/revenue_and_expenses', [
        'revenue' => $revenue,
        'expenses' => $expenses,
        'selectedMonth' => $month
    ]);
}

public function monthlyReport()
{
    $FinanceModel = new \App\Models\FinanceModel();
    $area = session()->get('area');
    $month = $this->request->getGet('month') ?? date('F');

    $revenue = $FinanceModel->where('type', 'revenue')
                            ->where('created_by', $area)
                            ->where('month_tag', $month)
                            ->orderBy('created_at', 'DESC')
                            ->findAll();

    $expenses = $FinanceModel->where('type', 'expenses')
                             ->where('created_by', $area)
                             ->where('month_tag', $month)
                             ->orderBy('created_at', 'DESC')
                             ->findAll();

    return view('admin/finance/monthly_report', [
        'revenue' => $revenue,
        'expenses' => $expenses,
        'selectedMonth' => $month
    ]);
}

public function getMonthlyRecords($monthTag, $createdBy = null)
{
    $builder = $this->where('month_tag', $monthTag);

    if ($createdBy !== null) {
        $builder = $builder->where('created_by', $createdBy);
    }

    return $builder->orderBy('record_date', 'DESC')->findAll();
}


public function exportReport($monthName = null)
{
    if ($monthName) {
        $timestamp = strtotime($monthName . '-01');
        $monthTag = date('F', $timestamp);
    } else {
        $monthTag = date('F');
    }

    $financeModel = new FinanceModel();
    $createdBy = session('area') ?? null;
    $records = $financeModel->getMonthlyRecords($monthTag, $createdBy);

    if (empty($records)) {
        echo "No finance records found for month '{$monthTag}' and area '{$createdBy}'.";
        exit;
    }

    $revenues = array_filter($records, fn($r) => $r['type'] === 'revenue');
    $expenses = array_filter($records, fn($r) => $r['type'] === 'expenses');

    $monthlyRevenue = [];
    $otherRevenue = [];
    $installationRevenue = [];

    foreach ($revenues as $item) {
        if (stripos($item['category'], 'installation') !== false ||
            (isset($item['description']) && stripos($item['description'], 'installation') !== false)) {
            $installationRevenue[] = $item;
        } elseif (stripos($item['category'], 'monthly') !== false ||
            (isset($item['description']) && stripos($item['description'], 'monthly') !== false)) {
            $monthlyRevenue[] = $item;
        } else {
            $otherRevenue[] = $item;
        }
    }

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $row = 1;
    $spreadsheet->getDefaultStyle()->getFont()->setName('Cambria');

    // Header title with green background
    $headerTitle = "Monthly Finance Report - Month of $monthTag -  $createdBy";
    $sheet->setCellValue("A$row", $headerTitle);
    $sheet->mergeCells("A$row:E$row");
    $sheet->getStyle("A$row")->applyFromArray([
        'font' => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFFFF']],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF228B22']], // ForestGreen background
    ]);
    $row++;

    // Monthly Payments header - lighter green background
    $sheet->setCellValue("A$row", "Monthly Payments");
    $sheet->mergeCells("A$row:E$row");
    $sheet->getStyle("A$row")->applyFromArray([
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFC6EFCE']], // light green background
    ]);
    $row++;

    $sheet->fromArray(['Category', 'Quantity', 'Description', 'Date', 'Amount'], null, "A$row");
    $sheet->getStyle("A$row:E$row")->applyFromArray([
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ]);
    $row++;

    $totalMonthlyRevenue = 0;
    foreach ($monthlyRevenue as $item) {
        $amount = floatval($item['amount']);
        $totalMonthlyRevenue += $amount;
        $sheet->fromArray([
            $item['category'],
            $item['quantity'],
            $item['description'],
            date('M d, Y', strtotime($item['record_date'])),
            $amount,
        ], null, "A$row");

        // Amount cell background lighter green (column D)
        $sheet->getStyle("D$row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFC6EFCE'); // lighter green

        $row++;
    }
    // Monthly Revenue total
    $sheet->fromArray(['', '', '', 'Total Monthly Payments:', $totalMonthlyRevenue], null, "A$row");
    $sheet->getStyle("C{$row}:E{$row}")->applyFromArray([
        'font' => ['bold' => true],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFC6EFCE']],
    ]);
    $sheet->getStyle("E{$row}")->getNumberFormat()->setFormatCode('#,##0.00');
    $row++;

    if (!empty($installationRevenue)) {
        $row++;
        // Installation Revenue header - yellow background
        $sheet->setCellValue("A$row", "Installation Revenue");
        $sheet->mergeCells("A$row:E$row");
        $sheet->getStyle("A$row")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFFF2CC']], // light yellow
        ]);
        $row++;

        $sheet->fromArray(['Category', 'Quantity', 'Description', 'Date', 'Amount'], null, "A$row");
        $sheet->getStyle("A$row:E$row")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $row++;

        $totalInstallationRevenue = 0;
        foreach ($installationRevenue as $item) {
            $amount = floatval($item['amount']);
            $totalInstallationRevenue += $amount;
            $sheet->fromArray([
                $item['category'],
                $item['quantity'],
                $item['description'],
                date('M d, Y', strtotime($item['record_date'])),
                $amount,
            ], null, "A$row");

            // Amount cell yellow background (column D)
            $sheet->getStyle("E$row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFF2CC'); // light yellow

            $row++;
        }
        // Installation Revenue total
        $sheet->fromArray(['', '', '', 'Total Installation Revenue:', $totalInstallationRevenue], null, "A$row");
        $sheet->getStyle("C{$row}:E{$row}")->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFFF2CC']],
        ]);
        $sheet->getStyle("E{$row}")->getNumberFormat()->setFormatCode('#,##0.00');
        $row++;
    } else {
        $totalInstallationRevenue = 0;
    }

    if (!empty($otherRevenue)) {
        $row++;
        // Other Revenue header - blue background
        $sheet->setCellValue("A$row", "Other Revenue");
        $sheet->mergeCells("A$row:E$row");
        $sheet->getStyle("A$row")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFBDD7EE']], // light blue
        ]);
        $row++;

        $sheet->fromArray(['Category','Quantity', 'Description', 'Date', 'Amount'], null, "A$row");
        $sheet->getStyle("A$row:E$row")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $row++;

        $totalOtherRevenue = 0;
        foreach ($otherRevenue as $item) {
            $amount = floatval($item['amount']);
            $totalOtherRevenue += $amount;
            $sheet->fromArray([
                $item['category'],
                $item['quantity'],
                $item['description'],
                date('M d, Y', strtotime($item['record_date'])),
                $amount,
            ], null, "A$row");

            // Amount cell blue background (column D)
            $sheet->getStyle("D$row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFBDD7EE'); // light blue

            $row++;
        }
        // Other Revenue total
        $sheet->fromArray(['', '', '', 'Total Other Revenue:', $totalOtherRevenue], null, "A$row");
        $sheet->getStyle("C{$row}:E{$row}")->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFBDD7EE']],
        ]);
        $sheet->getStyle("D{$row}")->getNumberFormat()->setFormatCode('#,##0.00');
        $row++;
    } else {
        $totalOtherRevenue = 0;
    }

    // Grand total revenue (sum of all revenue categories)
    $grandTotalRevenue = $totalMonthlyRevenue + $totalInstallationRevenue + $totalOtherRevenue;
    $sheet->fromArray(['', '', '', 'Grand Total Revenue:', $grandTotalRevenue], null, "A$row");
    $sheet->getStyle("C{$row}:E{$row}")->applyFromArray([
        'font' => ['bold' => true, 'size' => 12],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF90EE90']], // light green for grand total
    ]);
    $sheet->getStyle("E{$row}")->getNumberFormat()->setFormatCode('#,##0.00');
    $row++;

    // Expenses Header - lighter red background
    $row++;
    $sheet->setCellValue("A$row", "Expenses");
    $sheet->mergeCells("A$row:E$row");
    $sheet->getStyle("A$row")->applyFromArray([
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF4CCCC']], // light red
    ]);
    $row++;

    $sheet->fromArray(['Category', 'Quantity', 'Description', 'Date', 'Amount'], null, "A$row");
    $sheet->getStyle("A$row:E$row")->applyFromArray([
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ]);
    $row++;

    $totalExpenses = 0;
    foreach ($expenses as $item) {
        $amount = floatval($item['amount']);
        $totalExpenses += $amount;
        $sheet->fromArray([
            $item['category'],
            $item['quantity'],
            $item['description'],
            date('M d, Y', strtotime($item['record_date'])),
            $amount,
        ], null, "A$row");

        $row++;
    }
    // Expenses total
    $sheet->fromArray(['', '', '', 'Total Expenses:', $totalExpenses], null, "A$row");
    $sheet->getStyle("C{$row}:E{$row}")->applyFromArray([
        'font' => ['bold' => true],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF4CCCC']],
    ]);
    $sheet->getStyle("E{$row}")->getNumberFormat()->setFormatCode('#,##0.00');
    $row++;

    // Net Income (Grand Total Revenue - Expenses)
    $netIncome = $grandTotalRevenue - $totalExpenses;
    $sheet->fromArray(['', '', '', 'Net Income:', $netIncome], null, "A$row");
    $sheet->getStyle("C{$row}:E{$row}")->applyFromArray([
        'font' => ['bold' => true, 'size' => 12],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFB0E0E6']], // light blue for net income
    ]);
    $sheet->getStyle("E{$row}")->getNumberFormat()->setFormatCode('#,##0.00');

    // Auto size columns A-D
    foreach (range('A', 'E') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Output as downloadable Excel file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=monthly_finance_report_{$monthTag}.xlsx");
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;
}


public function financeRecords()
{
    $financeModel = new \App\Models\FinanceModel();
    $area = session()->get('area');
    $selectedMonth = $this->request->getGet('month') ?? date('F');

    // Define months array
    $months = [
        'January','February','March','April','May','June',
        'July','August','September','October','November','December'
    ];

    // Handle form submission (POST)
    if ($this->request->getMethod() === 'post') {
        $data = [
            'record_date' => $this->request->getPost('record_date'),
            'month_tag'   => date('F', strtotime($this->request->getPost('record_date'))),
            'type'        => $this->request->getPost('type'),
            'category'    => $this->request->getPost('category'),
            'description' => $this->request->getPost('description'),
            'amount'      => $this->request->getPost('amount'),
            'quantity'    => $this->request->getPost('quantity'),
            'created_by'  => $area,
            'created_at'  => date('Y-m-d H:i:s'),
        ];

        if ($financeModel->insert($data)) {
            session()->setFlashdata('success', ucfirst($data['type']) . ' record created successfully.');
            return redirect()->to(base_url('admin/finance/records?type=' . $data['type'] . '&month=' . $data['month_tag']));
        } else {
            return view('admin/finance/finance_records', [
                'errors' => $financeModel->errors(),
                'old' => $this->request->getPost(),
                'type' => $data['type'],
                'months' => $months,
                'selectedMonth' => $selectedMonth,
                'revenue' => [],
                'expenses' => [],
                'allRevenues' => [],
                'allExpenses' => [],
            ]);
        }
    }

    // GET request: fetch records for monthly view (Part 3)
    $revenue = $financeModel->where('type', 'revenue')
                            ->where('created_by', $area)
                            ->where('month_tag', $selectedMonth)
                            ->orderBy('created_at', 'DESC')
                            ->findAll();

    $expenses = $financeModel->where('type', 'expenses')
                             ->where('created_by', $area)
                             ->where('month_tag', $selectedMonth)
                             ->orderBy('created_at', 'DESC')
                             ->findAll();

    // Also fetch all records for full overview tables (Part 2)
    $allRevenues = $financeModel->where('type', 'revenue')
                                ->where('created_by', $area)
                                ->orderBy('created_at', 'DESC')
                                ->findAll();

    $allExpenses = $financeModel->where('type', 'expenses')
                                ->where('created_by', $area)
                                ->orderBy('created_at', 'DESC')
                                ->findAll();

    $type = $this->request->getGet('type') ?? 'revenue';

    $categorySummary = $financeModel->getSummaryByCategoryAndType($area);

    return view('admin/finance/finance_records', [
        'type' => $type,
        'errors' => [],
        'old' => [],
        'months' => $months,
        'selectedMonth' => $selectedMonth,
        'revenue' => $revenue,               // Monthly
        'expenses' => $expenses,             // Monthly
        'allRevenues' => $allRevenues,       // All-time for Revenues & Expenses table
        'allExpenses' => $allExpenses,
        'categorySummary' => $categorySummary,
    ]);
}




}
 