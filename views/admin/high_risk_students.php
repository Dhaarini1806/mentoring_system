<?php
$pageTitle = "High-Risk Students";
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
$students = $students ?? [];
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3><i class="bi bi-exclamation-triangle text-danger"></i> High-Risk Students</h3>
    <div>
        <a href="<?php echo BASE_URL; ?>exports/export_students_excel.php" class="btn btn-sm btn-outline-success">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>
        <a href="<?php echo BASE_URL; ?>exports/export_students_pdf.php" class="btn btn-sm btn-outline-danger">
            <i class="bi bi-file-pdf"></i> Export PDF
        </a>
    </div>
</div>

<div class="alert alert-warning py-2">
    Students are classified as <strong>High Risk</strong> when attendance &lt; 75%, average marks &lt; 50%, or no counseling in the last 30 days.
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Roll No</th>
                <th>Name</th>
                <th>Department</th>
                <th>Semester</th>
                <th>Risk Level</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($students)): ?>
                <tr><td colspan="7" class="text-muted text-center py-4">No high-risk students at the moment.</td></tr>
            <?php else: ?>
                <?php foreach ($students as $s): ?>
                    <tr>
                        <td><?php echo (int)$s['id']; ?></td>
                        <td><?php echo sanitize($s['roll_no']); ?></td>
                        <td><?php echo sanitize($s['first_name'] . ' ' . $s['last_name']); ?></td>
                        <td><?php echo sanitize($s['department']); ?></td>
                        <td><?php echo (int)$s['semester']; ?></td>
                        <td><span class="badge bg-danger">HIGH</span></td>
                        <td>
                            <a href="<?php echo BASE_URL; ?>admin/index.php?page=student_form&id=<?php echo (int)$s['id']; ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
