<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('get-csrf', function () {
    return response()->setJSON([
        'csrf_token_name' => csrf_token(),
        'csrf_hash' => csrf_hash()
    ]);
});



$routes->get('/', 'Landing::index');

/*handles application form*/
$routes->get('application-form', 'ApplicationController::index');
$routes->post('submit-application', 'ApplicationController::submit');
$routes->get('location/getProvinces', 'LocationController::getProvinces');
$routes->get('location/getCities', 'LocationController::getCities');

$routes->group('admin', function($routes) {
    // Authentication & Dashboard
    $routes->get('login', 'AdminController::login');
    $routes->post('authenticate', 'AdminController::authenticate');
    $routes->get('dashboard', 'AdminController::dashboard');
    $routes->post('subscriberCountPerMonth', 'AdminController::subscriberCountPerMonth');
    $routes->get('expensesSum', 'AdminController::expensesSum');
    $routes->get('revenuesQuery', 'AdminController::revenuesQuery');
    $routes->get('logout', 'AdminController::logout'); // Logout

    // Applications
    $routes->get('pending-applications', 'AdminController::pendingApplications');
    $routes->get('applications', 'AdminController::approvedApplications');
    $routes->get('declined-applications', 'AdminController::declinedApplications');
    $routes->post('admit', 'AdminController::admit');
    $routes->post('decline', 'AdminController::decline');
    $routes->post('reAdmitApplication', 'AdminController::reAdmitApplication');

    // Subscribers
    $routes->get('subscribers', 'AdminController::subscribersList');
    $routes->post('connectSubscriber', 'AdminController::connectSubscriber');
    $routes->post('disconnectSubscriber', 'AdminController::disconnectSubscriber');
    $routes->get('get-subscriber/(:num)', 'AdminController::getSubscriber/$1');
    $routes->post('saveAccountNumber', 'AdminController::saveAccountNumber');
    $routes->post('updateSubscriber', 'AdminController::updateSubscriber');
    $routes->post('sendToTechnician', 'AdminController::sendToTechnician');
    $routes->post('update-subscriber-status', 'AdminController::updateSubscriberStatus');
    $routes->post('add-subscriber', 'AdminController::addSubscriber');
    $routes->get('predictAccountNumber/(:any)', 'AdminController::predictAccountNumber/$1');



    // Tickets
    $routes->get('install-tickets', 'AdminController::installTickets');
    $routes->get('rescheduled-tickets', 'AdminController::rescheduledTickets');
    $routes->get('cancelled-tickets', 'AdminController::cancelledTickets');
    $routes->get('generate-ticket', 'AdminController::showGenerateRepairForm');
    $routes->post('submit-repair-ticket', 'AdminController::submitRepairTicket');
    $routes->post('repair/save_schedule_ajax', 'AdminController::save_schedule_ajax');
    $routes->get('tickets', 'AdminController::Tickets');
    $routes->post('resched-repair/(:num)', 'AdminController::reschedRepair/$1');
    // Repair tickets reschedule
    $routes->get('update_repair_schedule/(:num)/(:any)', 'AdminController::update_schedule/$1/$2');
    // Install tickets reschedule
    $routes->get('update_install_schedule/(:num)/(:any)', 'AdminController::updateSchedule/$1/$2');
    $routes->get('install-materials/(:num)', 'AdminController::getByInstallId/$1');




    // Billing
    $routes->get('billings', 'AdminController::billings');
    $routes->post('save-billing-date', 'AdminController::saveBillingDate');
    $routes->get('billing-status', 'AdminController::billingStatus');
    $routes->post('mark-paid', 'AdminController::markPaid');
    $routes->get('billingStatusFiltered', 'AdminController::billingStatusFiltered');
    $routes->get('view-statement/(:segment)', 'AdminController::viewStatement/$1');
    $routes->get('invoice/(:segment)', 'AdminController::invoice/$1');
    $routes->get('print-statement/(:any)', 'AdminController::printStatement/$1');
    $routes->get('download-invoice/(:segment)', 'AdminController::downloadStatement/$1');
    $routes->get('totalUnpaidAmount', 'AdminController::totalUnpaidAmount');

    // Finance
    $routes->get('finance/create', 'AdminController::showCreateFinanceForm');
    $routes->post('finance/store', 'AdminController::storeFinanceRecord');
    $routes->get('finance/revenue', 'AdminController::revenue');
    $routes->get('finance/expenses', 'AdminController::expenses');
    $routes->get('finance/revenue-and-expenses', 'AdminController::revenueAndExpenses');
    $routes->get('finance/monthly-report', 'AdminController::monthlyReport');
    $routes->get('finance/export-report/(:segment)', 'AdminController::exportReport/$1');
    $routes->get('finance/finance-records', 'AdminController::financeRecords');




    // Reports
    $routes->get('generateReport', 'AdminController::generateReport');
    $routes->get('generate-subscribers-report', 'AdminController::generateSubscribersReport');
    $routes->get('generate-billing-report', 'AdminController::generateBillingReport');
    $routes->get('generate-install-tickets-report', 'AdminController::generateInstallTicketsReport');
    $routes->get('generate-repair-tickets-report', 'AdminController::generateRepairTicketsReport');

    // Logs
    $routes->get('logs', 'AdminController::logs');
    $routes->get('fetch-logs', 'AdminController::fetch_logs');
});


// Public technician routes (login only)
$routes->get('technician/login', 'TechnicianController::login');
$routes->post('technician/authenticate', 'TechnicianController::authenticate');

// Group technician routes for organization (no filter applied here)
$routes->group('technician', function($routes) {
    $routes->get('dashboard', 'TechnicianController::dashboard');
    $routes->get('logout', 'TechnicianController::logout');
    $routes->get('installRequests', 'TechnicianController::installRequests');
    $routes->match(['get', 'post'],'updateStatus', 'TechnicianController::updateInstallStatus');
    $routes->match(['get', 'post'], 'updateRepairStatus', 'TechnicianController::updateRepairStatus');
    $routes->get('repairRequests', 'TechnicianController::repairRequests');
    $routes->post('submitMaterialsReport', 'TechnicianController::submitMaterialsReport');
    $routes->post('submitInstallMaterials', 'TechnicianController::submitInstallMaterials');
    $routes->post('set-status-open', 'TechnicianController::setStatusOpen');

});

$routes->get('/testemail', 'TestEmail::index');
$routes->get('cron/mark-overdue', 'CronController::markOverdue');


?>