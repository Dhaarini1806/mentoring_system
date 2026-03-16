<?php
$pageTitle = "Student Profile";
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
$student = $student ?? [];
$name = trim(($student['first_name'] ?? '') . ' ' . ($student['last_name'] ?? ''));
if ($name === '') $name = $student['name'] ?? '—';
?>
<div class="mb-3">
    <a href="<?php echo BASE_URL; ?>mentor/index.php?page=students" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
    <h3 class="mt-2"><?php echo sanitize($name); ?> — <?php echo sanitize($student['register_number'] ?: $student['roll_no'] ?: ''); ?></h3>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Attendance</h6>
                <h4><?php echo isset($attendancePercent) && $attendancePercent !== null ? round($attendancePercent, 1) . '%' : '—'; ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Avg Marks</h6>
                <h4><?php echo isset($avgMarks) && $avgMarks !== null ? round($avgMarks, 1) . '%' : '—'; ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Risk</h6>
                <?php $level = $student['risk_level'] ?? 'SAFE'; $b = $level === 'HIGH' ? 'danger' : ($level === 'MEDIUM' ? 'warning' : 'success'); ?>
                <h4><span class="badge bg-<?php echo $b; ?>"><?php echo $level; ?></span></h4>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 mb-3">
    <div class="card-header bg-white">Quick actions</div>
    <div class="card-body">
        <a href="<?php echo BASE_URL; ?>mentor/index.php?page=counseling_form&student_id=<?php echo (int)$student['id']; ?>" class="btn btn-primary me-2">Add Counseling</a>
        <a href="<?php echo BASE_URL; ?>mentor/index.php?page=attendance_form&student_id=<?php echo (int)$student['id']; ?>" class="btn btn-info me-2">Attendance</a>
        <a href="<?php echo BASE_URL; ?>mentor/index.php?page=marks_form&student_id=<?php echo (int)$student['id']; ?>" class="btn btn-success">Marks</a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white">Recent counseling</div>
    <div class="card-body p-0">
        <?php if (empty($sessions)): ?>
            <p class="text-muted text-center py-3 mb-0">No sessions yet.</p>
        <?php else: ?>
            <ul class="list-group list-group-flush">
                <?php foreach (array_slice($sessions, 0, 5) as $s): ?>
                    <li class="list-group-item"><?php echo date('d M Y', strtotime($s['session_date'])); ?> — <?php echo sanitize(substr($s['summary'] ?? '', 0, 60)); ?>…</li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
