<?php
$pageTitle = "Students";
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Students</h3>
    <div>
        <a href="<?php echo BASE_URL; ?>exports/export_students_excel.php" class="btn btn-sm btn-outline-success">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>
        <a href="<?php echo BASE_URL; ?>exports/export_students_pdf.php" class="btn btn-sm btn-outline-danger">
            <i class="bi bi-file-pdf"></i> Export PDF
        </a>
        <a href="<?php echo BASE_URL; ?>admin/index.php?page=student_form" class="btn btn-sm btn-primary">
            <i class="bi bi-plus"></i> Add Student
        </a>
    </div>
</div>

<div class="table-responsive">
<table class="table table-striped table-hover align-middle">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Roll No</th>
            <th>Name</th>
            <th>Department</th>
            <th>Sem</th>
            <th>Risk</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($students as $s): ?>
        <tr>
            <td><?php echo (int)$s['id']; ?></td>
            <td><?php echo sanitize($s['roll_no']); ?></td>
            <td><?php echo sanitize($s['first_name'] . ' ' . $s['last_name']); ?></td>
            <td><?php echo sanitize($s['branch'] ?? $s['department'] ?? '—'); ?></td>
            <td><?php echo (int)($s['semester'] ?? 0); ?></td>
            <td>
                <?php
                $rl = $s['risk_level'] ?? 'SAFE';
                $badge = $rl === 'HIGH' ? 'danger' : ($rl === 'MEDIUM' ? 'warning' : 'success');
                ?>
                <span class="badge bg-<?php echo $badge; ?>"><?php echo $rl; ?></span>
            </td>
            <td>
                <a href="<?php echo BASE_URL; ?>admin/index.php?page=student_form&id=<?php echo (int)$s['id']; ?>" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-pencil"></i>
                </a>
                <a onclick="return confirm('Delete student?');"
                   href="<?php echo BASE_URL; ?>admin/index.php?page=student_delete&id=<?php echo (int)$s['id']; ?>"
                   class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>