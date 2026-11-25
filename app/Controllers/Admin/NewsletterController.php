<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;

class NewsletterController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('newsletter:manage');
        $subscribers = Database::fetchAll('SELECT * FROM newsletter_subscribers ORDER BY subscribed_at DESC');
        return $this->render('admin.newsletter.index', [
            'title' => 'Newsletter Subscribers — Dynamice CMS',
            'subscribers' => $subscribers,
        ]);
    }

    public function toggle(Request $request, array $params): Response
    {
        $this->checkPermission('newsletter:manage');
        $id = (int)($params['id'] ?? 0);
        $sub = Database::fetchOne('SELECT * FROM newsletter_subscribers WHERE id = :id', ['id' => $id]);

        if ($sub) {
            $newStatus = $sub['is_subscribed'] ? 0 : 1;
            Database::query('UPDATE newsletter_subscribers SET is_subscribed = :s WHERE id = :id', ['s' => $newStatus, 'id' => $id]);
            $this->logAudit('TOGGLE', 'NewsletterSubscriber', (string)$id, ['is_subscribed' => $newStatus]);
        }

        return $this->redirect('/admin/newsletter', 'Subscription status updated.');
    }

    public function exportCsv(Request $request): Response
    {
        $this->checkPermission('newsletter:manage');
        $subscribers = Database::fetchAll('SELECT id, email, is_subscribed, subscribed_at FROM newsletter_subscribers ORDER BY id DESC');

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="newsletter_subscribers_' . date('Y-m-d') . '.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Email', 'Is Subscribed', 'Subscribed At']);

        foreach ($subscribers as $row) {
            fputcsv($output, [
                $row['id'],
                $row['email'],
                $row['is_subscribed'] ? 'Yes' : 'No',
                $row['subscribed_at'],
            ]);
        }
        fclose($output);
        exit;
    }

    public function delete(Request $request, array $params): Response
    {
        $this->checkPermission('newsletter:manage');
        $id = (int)($params['id'] ?? 0);
        Database::query('DELETE FROM newsletter_subscribers WHERE id = :id', ['id' => $id]);
        $this->logAudit('DELETE', 'NewsletterSubscriber', (string)$id);
        return $this->redirect('/admin/newsletter', 'Subscriber removed.');
    }
}
