<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Commands extends BaseConfig
{
    public $commands = [
    'billing:mark-overdue' => \App\Commands\BillingMarkOverdue::class,
];
}


