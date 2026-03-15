<?php
$pageTitle = "Mentors";
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Mentors</h3>
    <a href="<?php echo BASE_URL; ?>admin/index.php?page=mentor_form" class="btn btn-primary btn-sm">
        <i class="bi bi-plus"></i> Add Mentor
    </a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Staff ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Contact</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mentors as $m): ?>
                <tr>
                    <td><?php echo (int)$m['id']; ?></td>
                    <td><?php echo sanitize($m['staff_id']); ?></td>
                    <td><?php echo sanitize($m['name']); ?></td>
                    <td><?php echo sanitize($m['department']); ?></td>
                    <td><?php echo sanitize($m['designation'] ?? '—'); ?></td>
                    <td><?php echo sanitize($m['contact_no'] ?? '—'); ?></td>
                    <td>
                        <a href="<?php echo BASE_URL; ?>admin/index.php?page=mentor_form&id=<?php echo (int)$m['id']; ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a onclick="return confirm('Delete this mentor?');"
                           href="<?php echo BASE_URL; ?>admin/index.php?page=mentor_delete&id=<?php echo (int)$m['id']; ?>"
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
