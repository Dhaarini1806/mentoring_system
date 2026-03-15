<?php
$pageTitle = "Mentor Assignment";
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
$assignments = $assignments ?? [];
?>
<div class="mb-3">
    <h3>Mentor Assignment</h3>
    <?php if (!empty($_GET['success'])): ?>
        <div class="alert alert-success py-2">Assignments updated successfully.</div>
    <?php endif; ?>
</div>

<!-- Current assignments table -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white">
        <h6 class="mb-0">Current Assignments</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Mentor</th>
                        <th>Department</th>
                        <th>Student (Roll No)</th>
                        <th>Student Department</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($assignments)): ?>
                        <tr><td colspan="4" class="text-muted text-center py-4">No assignments yet. Use the form below to assign students to mentors.</td></tr>
                    <?php else: ?>
                        <?php foreach ($assignments as $a): ?>
                            <tr>
                                <td><?php echo sanitize($a['mentor_name']); ?></td>
                                <td><?php echo sanitize($a['mentor_dept']); ?></td>
                                <td><?php echo sanitize($a['roll_no'] . ' - ' . $a['first_name'] . ' ' . $a['last_name']); ?></td>
                                <td><?php echo sanitize($a['student_dept']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Assign form -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white">
        <h6 class="mb-0">Assign Students to Mentor</h6>
    </div>
    <div class="card-body">
        <form method="post" action="<?php echo BASE_URL; ?>admin/index.php?page=mentor_assignment">
            <input type="hidden" name="<?php echo CSRF_TOKEN_NAME; ?>" value="<?php echo generate_csrf_token(); ?>">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Mentor <span class="text-danger">*</span></label>
                <div class="col-sm-6">
                    <select name="mentor_id" class="form-select" required>
                        <option value="">— Select Mentor —</option>
                        <?php foreach ($mentors as $m): ?>
                            <option value="<?php echo (int)$m['id']; ?>"><?php echo sanitize($m['name'] . ' (' . $m['department'] . ')'); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Students <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <select name="student_ids[]" class="form-select" multiple size="10">
                        <?php foreach ($students as $s): ?>
                            <option value="<?php echo (int)$s['id']; ?>">
                                <?php echo sanitize($s['roll_no'] . ' - ' . $s['first_name'] . ' ' . $s['last_name'] . ' (' . $s['department'] . ')'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple students.</small>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8 offset-sm-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-link-45deg"></i> Assign</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
