<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;

class EnquiriesController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('enquiries:view');
        $enquiries = Database::fetchAll('SELECT * FROM enquiries ORDER BY created_at DESC');
        return $this->render('admin.enquiries.index', [
            'title' => 'Admission Enquiries CRM — Dynamice CMS',
            'enquiries' => $enquiries,
        ]);
    }

    public function updateStatus(Request $request, array $params): Response
    {
        $this->checkPermission('enquiries:update');
        $id = (int)($params['id'] ?? 0);
        $data = $request->getBody();

        $status = in_array($data['status'] ?? '', ['NEW', 'CONTACTED', 'CONVERTED', 'CLOSED']) ? $data['status'] : 'NEW';
        $adminNotes = $data['admin_notes'] ?? null;

        Database::query(
            'UPDATE enquiries SET status = :status, admin_notes = :admin_notes, updated_at = NOW() WHERE id = :id',
            ['status' => $status, 'admin_notes' => $adminNotes, 'id' => $id]
        );

        $this->logAudit('UPDATE_STATUS', 'Enquiry', (string)$id, ['status' => $status]);
        return $this->redirect('/admin/enquiries', 'Enquiry record updated.');
    }

    public function exportCsv(Request $request): Response
    {
        $this->checkPermission('enquiries:view');
        $enquiries = Database::fetchAll('SELECT id, name, email, phone, subject, preferred_branch, status, admin_notes, created_at FROM enquiries ORDER BY id DESC');

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="enquiries_export_' . date('Y-m-d') . '.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Name', 'Email', 'Phone', 'Subject', 'Branch', 'Status', 'Admin Notes', 'Date']);

        foreach ($enquiries as $row) {
            fputcsv($output, [
                $row['id'],
                $row['name'],
                $row['email'],
                $row['phone'],
                $row['subject'],
                $row['preferred_branch'] ?? 'Main Academy',
                $row['status'],
                $row['admin_notes'] ?? '',
                $row['created_at'],
            ]);
        }
        fclose($output);
        exit;
    }

    public function delete(Request $request, array $params): Response
    {
        $this->checkPermission('enquiries:update');
        $id = (int)($params['id'] ?? 0);
        Database::query('DELETE FROM enquiries WHERE id = :id', ['id' => $id]);
        $this->logAudit('DELETE', 'Enquiry', (string)$id);
        return $this->redirect('/admin/enquiries', 'Enquiry deleted.');
    }
}
