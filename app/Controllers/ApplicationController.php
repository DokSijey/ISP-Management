<?php

namespace App\Controllers;

use App\Models\ApplicationModel;

class ApplicationController extends BaseController
{
    public function index()
    {
        return view('application_form');
    }

    public function submit()
    {
        // Load the model
        $model = new ApplicationModel();

        // Get POST data
        $data = [
            'first_name'     => $this->request->getPost('first_name'),
            'middle_name'    => $this->request->getPost('middle_name'),
            'last_name'      => $this->request->getPost('last_name'),
            'suffix'         => $this->request->getPost('suffix'),
            'province'       => $this->request->getPost('province'),
            'city'           => $this->request->getPost('city'),
            'barangay'       => $this->request->getPost('barangay'),
            'house_number'   => $this->request->getPost('house_number'),
            'apartment'      => $this->request->getPost('apartment'),
            'landmark'       => $this->request->getPost('landmark'),
            'contact_number1'=> $this->request->getPost('contact_number1'),
            'contact_number2'=> $this->request->getPost('contact_number2'),
            'email'          => $this->request->getPost('email'),
            'plan'           => $this->request->getPost('plan'),
            'application_date'=> date('Y-m-d H:i:s'),
            'status'         => 'Pending',
            'decline_reason' => null,
            'schedule_date'  => null,
            'app_status'     => 'Pending',
            'app_reason'     => null
        ];

        // Insert data into the database
        if ($model->insert($data)) {
            return redirect()->to('/application-form')->with('success', 'Application submitted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to submit application!');
        }
    }
}

?>
