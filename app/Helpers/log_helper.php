<?php
use CodeIgniter\Model;

function log_action($admin_id, $action, $details)
{
    $db = \Config\Database::connect();
    $builder = $db->table('action_logs');

    try {
        $builder->insert([
            'admin_id' => $admin_id,
            'action' => $action,
            'details' => $details,
            'area' => session()->get('area'),
        ]);
    } catch (\Exception $e) {
        log_message('error', 'Failed to log action: ' . $e->getMessage());
    }
}


