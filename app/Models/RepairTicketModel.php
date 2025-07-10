<?php

namespace App\Models;

use CodeIgniter\Model;

class RepairTicketModel extends Model
{
    protected $table = 'repair_tickets';
    protected $primaryKey = 'id';
    protected $allowedFields = ['status', 'reason', 'updated_at'];
    protected $useTimestamps = true;

    /**
     * Update the status and optional reason of a repair ticket.
     *
     * @param int $id The repair ticket ID
     * @param string $status The new status
     * @param string|null $reason Optional reason for status update
     * @return bool
     */
    public function updateStatus(int $id, string $status, ?string $reason = null): bool
    {
        $data = ['status' => $status];

        if ($reason !== null) {
            $data['reason'] = $reason;
        }

        return $this->update($id, $data);
    }

public function getRepairRequestsWithDetails($adminArea, $date)
{
    return $this->select('repair_tickets.*, subscribers.address, subscribers.city, subscribers.first_name, subscribers.middle_name, subscribers.last_name')
        ->join('subscribers', 'subscribers.id = repair_tickets.subscriber_id')
        ->where('subscribers.city', $adminArea)
        ->where('repair_tickets.updated_at >=', $date . ' 00:00:00')
        ->where('repair_tickets.updated_at <=', $date . ' 23:59:59')
        ->orderBy("FIELD(repair_tickets.status, 'Open', 'On-going', 'Re-schedule', 'Cancelled', 'Resolved') ASC")
        ->orderBy('repair_tickets.updated_at', 'DESC')
        ->findAll();
}
}
