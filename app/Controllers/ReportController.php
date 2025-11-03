<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Donation;

class ReportController extends Controller
{
    public function donations(): void
    {
        $from = $_GET['from'] ?? date('Y-m-01');
        $to = $_GET['to'] ?? date('Y-m-t');
        $data = (new Donation())->totalByDateRange($from . ' 00:00:00', $to . ' 23:59:59');
        $this->view('reports/donations', ['title' => 'Relatório de Doações', 'from' => $from, 'to' => $to, 'rows' => $data]);
    }

    public function rankings(): void
    {
        $donationModel = new Donation();
        $byInstitution = $donationModel->totalByInstitution();
        $byUser = $donationModel->totalByUser();
        $this->view('reports/rankings', ['title' => 'Rankings', 'byInstitution' => $byInstitution, 'byUser' => $byUser]);
    }
}
