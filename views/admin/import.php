<?php
$pageTitle = "Bulk Import";
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
?>
<div class="mb-4">
    <h3>Bulk Import Data</h3>
    <p class="text-muted">Upload CSV files to import students or assignments in bulk.</p>
</div>

<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row g-4">
    <!-- Student Import -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white">
                <h6 class="mb-0 text-primary">Import Students</h6>
            </div>
            <div class="card-body">
                <p class="small text-muted">Upload a CSV file with: <code>roll_no, first_name, last_name, email, department, domain, is_honours, is_minor</code></p>
                <form action="<?php echo BASE_URL; ?>admin/index.php?page=import_students" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo CSRF_TOKEN_NAME; ?>" value="<?php echo generate_csrf_token(); ?>">
                    <div class="mb-3">
                        <input type="file" name="file" class="form-control" accept=".csv" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Upload & Import</button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Assignment Import -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white">
                <h6 class="mb-0 text-primary">Import Mentor Assignments</h6>
            </div>
            <div class="card-body">
                <p class="small text-muted">Upload a CSV file with: <code>mentor_staff_id, student_roll_no</code></p>
                <form action="<?php echo BASE_URL; ?>admin/index.php?page=import_assignments" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo CSRF_TOKEN_NAME; ?>" value="<?php echo generate_csrf_token(); ?>">
                    <div class="mb-3">
                        <input type="file" name="file" class="form-control" accept=".csv" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Upload & Assign</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="mt-5 p-4 bg-info bg-opacity-10 border rounded">
    <h5><i class="bi bi-info-circle"></i> Tip for Excel/Google Sheets</h5>
    <p class="mb-0 small">To import your data, simply go to <strong>File > Download > Comma Separated Values (.csv)</strong> in Excel or Google Sheets, then upload that file here.</p>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
