<?php
$pageTitle = "Student Dashboard";
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
$student = $student ?? [];
$mentor = $mentor ?? null;
$hasRecord = !empty($student['id']);
$name = trim(($student['first_name'] ?? '') . ' ' . ($student['last_name'] ?? ''));
if ($name === '') $name = 'Student';
?>
<div class="mb-3">
    <h3>Dashboard</h3>
    <p class="text-muted mb-0">Welcome, <?php echo sanitize($name); ?>.</p>
</div>

<?php if (!$hasRecord): ?>
    <div class="alert alert-warning">
        <strong>No student record linked to your account.</strong> Your attendance, marks, and counseling data will appear here once an admin links your login to a student record.
    </div>
<?php else: ?>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Attendance</h6>
                <h4><?php echo $attendancePercent !== null ? round($attendancePercent, 1) . '%' : '—'; ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Average Marks</h6>
                <h4><?php echo $avgMarks !== null ? round($avgMarks, 1) . '%' : '—'; ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Risk Level</h6>
                <?php
                $level = $student['risk_level'] ?? 'SAFE';
                $badge = $level === 'HIGH' ? 'danger' : ($level === 'MEDIUM' ? 'warning' : 'success');
                ?>
                <h4><span class="badge bg-<?php echo $badge; ?>"><?php echo $level; ?></span></h4>
            </div>
        </div>
    </div>
</div>

<?php if ($mentor): ?>
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white">
        <h6 class="mb-0">My Mentor</h6>
    </div>
    <div class="card-body">
        <p class="mb-1"><strong><?php echo sanitize($mentor['name']); ?></strong> — <?php echo sanitize($mentor['designation'] ?? ''); ?></p>
        <p class="mb-1 small text-muted"><?php echo sanitize($mentor['department']); ?></p>
        <?php if (!empty($mentor['contact_no'])): ?>
            <p class="mb-0 small">Contact: <?php echo sanitize($mentor['contact_no']); ?></p>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Recent Counseling Sessions</h6>
        <a href="<?php echo BASE_URL; ?>student/index.php?page=counseling" class="btn btn-sm btn-outline-primary">View all</a>
    </div>
    <div class="card-body p-0">
        <?php if (empty($sessions)): ?>
            <p class="text-muted text-center py-4 mb-0">No counseling sessions recorded yet.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Mode</th>
                            <th>Summary</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($sessions, 0, 5) as $s): ?>
                            <tr>
                                <td><?php echo date('d M Y', strtotime($s['session_date'])); ?></td>
                                <td><?php echo sanitize($s['mode'] ?? '—'); ?></td>
                                <td><?php echo sanitize(substr($s['summary'] ?? '', 0, 80)); ?><?php echo strlen($s['summary'] ?? '') > 80 ? '…' : ''; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
<?php include __DIR__ . '/../partials/footer.php'; ?>
