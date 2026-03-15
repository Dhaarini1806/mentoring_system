<?php
$pageTitle = "Marks";
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
$rows = $rows ?? [];
$studentId = $studentId ?? 0;
?>
<div class="mb-3">
    <h3>Marks</h3>
    <p class="text-muted mb-0">Your internal marks by subject.</p>
</div>

<?php if (!$studentId): ?>
    <div class="alert alert-warning">No student record linked. Data will appear once your account is linked.</div>
<?php else: ?>
<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Subject Code</th>
                <th>Subject Name</th>
                <th>Exam Type</th>
                <th>Marks</th>
                <th>Max</th>
                <th>Percentage</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($rows)): ?>
                <tr><td colspan="6" class="text-muted text-center py-4">No marks recorded yet.</td></tr>
            <?php else: ?>
                <?php foreach ($rows as $r): ?>
                    <?php
                    $pct = isset($r['max_mark']) && $r['max_mark'] > 0
                        ? round(($r['internal_mark'] / $r['max_mark']) * 100, 1) : 0;
                    ?>
                    <tr>
                        <td><?php echo sanitize($r['subject_code'] ?? '—'); ?></td>
                        <td><?php echo sanitize($r['subject_name'] ?? '—'); ?></td>
                        <td><?php echo sanitize($r['exam_type'] ?? '—'); ?></td>
                        <td><?php echo (int)($r['internal_mark'] ?? 0); ?></td>
                        <td><?php echo (int)($r['max_mark'] ?? 0); ?></td>
                        <td><?php echo $pct; ?>%</td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
<?php include __DIR__ . '/../partials/footer.php'; ?>
