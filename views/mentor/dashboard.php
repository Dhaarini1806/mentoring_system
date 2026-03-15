<?php
$pageTitle = "Mentor Dashboard";
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
$students = $students ?? [];
?>
<div class="mb-3">
    <h3>Mentor Dashboard</h3>
    <p class="text-muted mb-0">Your assigned students and quick actions.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Assigned Students</h6>
                <h3><?php echo count($students); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">High Risk</h6>
                <h3 class="text-danger"><?php echo count(array_filter($students, fn($s) => ($s['risk_level'] ?? '') === 'HIGH')); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Medium Risk</h6>
                <h3 class="text-warning"><?php echo count(array_filter($students, fn($s) => ($s['risk_level'] ?? '') === 'MEDIUM')); ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Assigned Students</h6>
        <a href="<?php echo BASE_URL; ?>mentor/index.php?page=students" class="btn btn-sm btn-outline-primary">View all</a>
    </div>
    <div class="card-body p-0">
        <?php if (empty($students)): ?>
            <p class="text-muted text-center py-4 mb-0">No students assigned yet. Contact admin for mentor assignment.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Roll No</th>
                            <th>Name</th>
                            <th>Branch / Dept</th>
                            <th>Risk</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($students, 0, 10) as $s): ?>
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
                                <td><span class="badge bg-<?php echo $badge; ?>"><?php echo $s['risk_level'] ?? 'SAFE'; ?></span></td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>mentor/index.php?page=student_profile&student_id=<?php echo (int)$s['id']; ?>" class="btn btn-sm btn-outline-secondary">Profile</a>
                                    <a href="<?php echo BASE_URL; ?>mentor/index.php?page=counseling_form&student_id=<?php echo (int)$s['id']; ?>" class="btn btn-sm btn-outline-primary">Counseling</a>
                                    <a href="<?php echo BASE_URL; ?>mentor/index.php?page=attendance_form&student_id=<?php echo (int)$s['id']; ?>" class="btn btn-sm btn-outline-info">Attendance</a>
                                    <a href="<?php echo BASE_URL; ?>mentor/index.php?page=marks_form&student_id=<?php echo (int)$s['id']; ?>" class="btn btn-sm btn-outline-success">Marks</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
