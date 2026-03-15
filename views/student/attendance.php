<?php
$pageTitle = "Attendance";
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
$rows = $rows ?? [];
$studentId = $studentId ?? 0; // from controller
?>
<div class="mb-3">
    <h3>Attendance</h3>
    <p class="text-muted mb-0">Your monthly attendance records.</p>
</div>

<?php if (!$studentId): ?>
    <div class="alert alert-warning">No student record linked. Data will appear once your account is linked.</div>
<?php else: ?>
<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Month / Year</th>
                <th>Total Classes</th>
                <th>Attended</th>
                <th>Percentage</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($rows)): ?>
                <tr><td colspan="4" class="text-muted text-center py-4">No attendance records yet.</td></tr>
            <?php else: ?>
                <?php foreach ($rows as $r): ?>
                    <?php
                    $pct = $r['total_classes'] > 0 ? round(($r['attended_classes'] / $r['total_classes']) * 100, 1) : 0;
                    ?>
                    <tr>
                        <td><?php echo sanitize($r['month_year']); ?></td>
                        <td><?php echo (int)$r['total_classes']; ?></td>
                        <td><?php echo (int)$r['attended_classes']; ?></td>
                        <td><?php echo $pct; ?>%</td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
<?php include __DIR__ . '/../partials/footer.php'; ?>
