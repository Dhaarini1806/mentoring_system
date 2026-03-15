<?php
$pageTitle = "Record Attendance";
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
$studentId = (int)($_GET['student_id'] ?? 0);
?>
<div class="mb-3">
    <a href="<?php echo BASE_URL; ?>mentor/index.php?page=students" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
    <h3 class="mt-2">Record Attendance</h3>
</div>
<?php if ($studentId <= 0): ?>
    <div class="alert alert-warning">Select a student from My Students first.</div>
<?php else: ?>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="post" action="<?php echo BASE_URL; ?>mentor/index.php?page=attendance_save">
            <input type="hidden" name="<?php echo CSRF_TOKEN_NAME; ?>" value="<?php echo generate_csrf_token(); ?>">
            <input type="hidden" name="student_id" value="<?php echo $studentId; ?>">
            <div class="mb-3">
                <label class="form-label">Month / Year <span class="text-danger">*</span></label>
                <input type="text" name="month_year" class="form-control" required placeholder="e.g. 2025-03 or March 2025">
            </div>
            <div class="mb-3">
                <label class="form-label">Total Classes</label>
                <input type="number" name="total_classes" class="form-control" required min="1" value="1">
            </div>
            <div class="mb-3">
                <label class="form-label">Attended Classes</label>
                <input type="number" name="attended_classes" class="form-control" required min="0" value="0">
            </div>
            <button type="submit" class="btn btn-primary">Save Attendance</button>
        </form>
    </div>
</div>
<?php endif; ?>
<?php include __DIR__ . '/../partials/footer.php'; ?>
