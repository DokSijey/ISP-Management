<?php
namespace App\Models;

use CodeIgniter\Model;

class TechnicianModel extends Model
{
    protected $table = 'technicians';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'phone', 'password', 'area', 'created_at'];

    // Add method to validate login
    public function validateLogin($name, $password)
    {
        $technician = $this->where('name', $name)->first();

        if ($technician && password_verify($password, $technician['password'])) {
            return $technician;
        }

        return false;
    }
}
