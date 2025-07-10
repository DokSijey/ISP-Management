<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Landing extends Controller
{
    public function index()
    {
        $plans = [
            ["speed" => "50 Mbps", "price" => "₱799/month", "description" => "Basic browsing & streaming"],
            ["speed" => "100 Mbps", "price" => "₱999/month", "description" => "Gaming & HD streaming", "best_seller" => true],
            ["speed" => "130 Mbps", "price" => "₱1299/month", "description" => "Multiple devices & heavy usage"],
            ["speed" => "150 Mbps", "price" => "₱1499/month", "description" => "Ultra-fast speeds for work-from-home"]
        ];

        // Pass $plans to the view
        return view('landing_page', ['plans' => $plans]);
    }
}

?>