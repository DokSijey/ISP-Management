<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admins'; // Your database table
    protected $primaryKey = 'id';
    protected $allowedFields = ['area', 'password'];
}
