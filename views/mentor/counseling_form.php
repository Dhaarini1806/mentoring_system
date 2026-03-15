<?php
$pageTitle = "Add Counseling Session";
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
$studentId = (int)($_GET['student_id'] ?? 0);
?>
<div class="mb-3">
    <a href="<?php echo BASE_URL; ?>mentor/index.php?page=students" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
    <h3 class="mt-2">Add Counseling Session</h3>
</div>
<?php if ($studentId <= 0): ?>
    <div class="alert alert-warning">Select a student from My Students first.</div>
<?php else: ?>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="post" action="<?php echo BASE_URL; ?>mentor/index.php?page=counseling_save">
            <input type="hidden" name="<?php echo CSRF_TOKEN_NAME; ?>" value="<?php echo generate_csrf_token(); ?>">
            <input type="hidden" name="student_id" value="<?php echo $studentId; ?>">
            <div class="mb-3">
                <label class="form-label">Session Date <span class="text-danger">*</span></label>
                <input type="date" name="session_date" class="form-control" required value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Mode</label>
                <select name="mode" class="form-select">
                    <option value="In Person">In Person</option>
                    <option value="Phone">Phone</option>
                    <option value="Online">Online</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Summary <span class="text-danger">*</span></label>
                <textarea name="summary" class="form-control" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Action Items</label>
                <textarea name="action_items" class="form-control" rows="2"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Next Follow-up Date</label>
                <input type="date" name="next_followup_date" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Save Session</button>
        </form>
    </div>
</div>
<?php endif; ?>
<?php include __DIR__ . '/../partials/footer.php'; ?>
