<?php
$pageTitle = "My Students";
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
$students = $students ?? [];
?>
<div class="mb-3">
    <h3>My Students</h3>
    <p class="text-muted mb-0">Assigned students — add counseling, attendance, and marks.</p>
</div>

<?php if (empty($students)): ?>
    <div class="alert alert-info">No students assigned to you yet. Contact admin for mentor assignment.</div>
<?php else: ?>
<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Roll No</th>
                <th>Name</th>
                <th>Branch / Dept</th>
                <th>Semester</th>
                <th>Risk</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $s): ?>
                <?php
                $badge = 'success';
                if (($s['risk_level'] ?? '') === 'HIGH') $badge = 'danger';
                elseif (($s['risk_level'] ?? '') === 'MEDIUM') $badge = 'warning';
                $name = trim(($s['first_name'] ?? '') . ' ' . ($s['last_name'] ?? ''));
                if ($name === '') $name = $s['name'] ?? '—';
                ?>
                <tr>
                    <td><?php echo sanitize($s['roll_no'] ?? '—'); ?></td>
                    <td><?php echo sanitize($name); ?></td>
                    <td><?php echo sanitize($s['department'] ?? $s['branch'] ?? '—'); ?></td>
                    <td><?php echo (int)($s['semester'] ?? 0); ?></td>
                    <td><span class="badge bg-<?php echo $badge; ?>"><?php echo $s['risk_level'] ?? 'SAFE'; ?></span></td>
                    <td>
                        <a href="<?php echo BASE_URL; ?>mentor/index.php?page=student_profile&student_id=<?php echo (int)$s['id']; ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-person"></i></a>
                        <a href="<?php echo BASE_URL; ?>mentor/index.php?page=counseling_form&student_id=<?php echo (int)$s['id']; ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-chat-left-text"></i></a>
                        <a href="<?php echo BASE_URL; ?>mentor/index.php?page=attendance_form&student_id=<?php echo (int)$s['id']; ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-calendar-check"></i></a>
                        <a href="<?php echo BASE_URL; ?>mentor/index.php?page=marks_form&student_id=<?php echo (int)$s['id']; ?>" class="btn btn-sm btn-outline-success"><i class="bi bi-journal-text"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
<?php include __DIR__ . '/../partials/footer.php'; ?>
