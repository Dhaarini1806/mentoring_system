<?php
$pageTitle = "Counseling History";
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
$rows = $rows ?? [];
$studentId = $studentId ?? 0;
?>
<div class="mb-3">
    <h3>Counseling History</h3>
    <p class="text-muted mb-0">Records of counseling sessions with your mentor.</p>
</div>

<?php if (!$studentId): ?>
    <div class="alert alert-warning">No student record linked. Data will appear once your account is linked.</div>
<?php else: ?>
<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Date</th>
                <th>Mentor</th>
                <th>Mode</th>
                <th>Summary</th>
                <th>Action Items</th>
                <th>Next Follow-up</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($rows)): ?>
                <tr><td colspan="6" class="text-muted text-center py-4">No counseling sessions recorded yet.</td></tr>
            <?php else: ?>
                <?php foreach ($rows as $r): ?>
                    <tr>
                        <td><?php echo date('d M Y', strtotime($r['session_date'])); ?></td>
                        <td><?php echo sanitize($r['mentor_name'] ?? '—'); ?></td>
                        <td><?php echo sanitize($r['mode'] ?? '—'); ?></td>
                        <td><?php echo sanitize($r['summary'] ?? '—'); ?></td>
                        <td><?php echo sanitize($r['action_items'] ?? '—'); ?></td>
                        <td><?php echo !empty($r['next_followup_date']) ? date('d M Y', strtotime($r['next_followup_date'])) : '—'; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
<?php include __DIR__ . '/../partials/footer.php'; ?>
