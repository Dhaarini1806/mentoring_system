<?php
$pageTitle = "Add Marks";
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
$studentId = (int)($_GET['student_id'] ?? 0);
?>
<div class="mb-3">
    <a href="<?php echo BASE_URL; ?>mentor/index.php?page=students" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
    <h3 class="mt-2">Add / Update Marks</h3>
</div>
<?php if ($studentId <= 0): ?>
    <div class="alert alert-warning">Select a student from My Students first.</div>
<?php else: ?>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="post" action="<?php echo BASE_URL; ?>mentor/index.php?page=marks_save">
            <input type="hidden" name="<?php echo CSRF_TOKEN_NAME; ?>" value="<?php echo generate_csrf_token(); ?>">
            <input type="hidden" name="student_id" value="<?php echo $studentId; ?>">
            <div class="mb-3">
                <label class="form-label">Subject Code <span class="text-danger">*</span></label>
                <input type="text" name="subject_code" class="form-control" required placeholder="e.g. CS101">
            </div>
            <div class="mb-3">
                <label class="form-label">Subject Name</label>
                <input type="text" name="subject_name" class="form-control" placeholder="e.g. Programming">
            </div>
            <div class="mb-3">
                <label class="form-label">Exam Type</label>
                <select name="exam_type" class="form-select">
                    <option value="Internal 1">Internal 1</option>
                    <option value="Internal 2">Internal 2</option>
                    <option value="Assignment">Assignment</option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Marks Obtained</label>
                    <input type="number" name="internal_mark" class="form-control" step="0.01" min="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Max Marks</label>
                    <input type="number" name="max_mark" class="form-control" min="1" value="100">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save Marks</button>
        </form>
    </div>
</div>
<?php endif; ?>
<?php include __DIR__ . '/../partials/footer.php'; ?>
