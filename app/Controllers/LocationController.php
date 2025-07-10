<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class LocationController extends Controller
{
    // Get Provinces
    public function getProvinces()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        $apiUrl = "https://psgc.gitlab.io/api/provinces/";

        try {
            $client = \Config\Services::curlrequest();
            $response = $client->get($apiUrl);
            return $this->response->setJSON(json_decode($response->getBody(), true));
        } catch (\Exception $e) {
            return $this->response->setJSON(["error" => "Server error: " . $e->getMessage()], 500);
        }
    }

    // Get Cities
    public function getCities()
    {
        $provinceCode = $this->request->getGet('province_code');
    
        if ($provinceCode) {
            try {
                $client = \Config\Services::curlrequest();
    
                // Get cities
                $citiesResponse = $client->get("https://psgc.gitlab.io/api/provinces/{$provinceCode}/cities/");
                $cities = json_decode($citiesResponse->getBody(), true);
    
                // Get municipalities
                $municipalitiesResponse = $client->get("https://psgc.gitlab.io/api/provinces/{$provinceCode}/municipalities/");
                $municipalities = json_decode($municipalitiesResponse->getBody(), true);
    
                // Merge both
                $all = array_merge($cities, $municipalities);
    
                // Reformat
                $data = [];
                foreach ($all as $location) {
                    $data[] = [
                        'name' => $location['name'],
                        'code' => $location['code']
                    ];
                }
    
                return $this->response->setJSON($data);
            } catch (\Exception $e) {
                return $this->response->setStatusCode(500)->setJSON([
                    'error' => 'Error fetching data: ' . $e->getMessage()
                ]);
            }
        }
    
        return $this->response->setJSON([]);
    }
    


    // Get Barangays
    public function getBarangays()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        $cityCode = $this->request->getPost('city_code');
        $apiUrl = "https://psgc.gitlab.io/api/cities/{$cityCode}/barangays/";

        try {
            $client = \Config\Services::curlrequest();
            $response = $client->get($apiUrl);
            return $this->response->setJSON(json_decode($response->getBody(), true));
        } catch (\Exception $e) {
            return $this->response->setJSON(["error" => "Server error: " . $e->getMessage()], 500);
        }
    }
}
