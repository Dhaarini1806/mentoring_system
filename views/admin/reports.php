<?php
$pageTitle = "Reports";
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
?>
<div class="mb-3">
    <h3>Institutional Reports</h3>
    <p class="text-muted mb-0">Generate and download reports for records and auditing.</p>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center">
                <div class="report-icon mb-2"><i class="bi bi-file-earmark-excel text-success"></i></div>
                <h6>Students – Excel</h6>
                <p class="small text-muted">Export full student list to .xls</p>
                <a href="<?php echo BASE_URL; ?>exports/export_students_excel.php" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-download"></i> Download Excel
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center">
                <div class="report-icon mb-2"><i class="bi bi-file-pdf text-danger"></i></div>
                <h6>Students – PDF</h6>
                <p class="small text-muted">Export student list as PDF report</p>
                <a href="<?php echo BASE_URL; ?>exports/export_students_pdf.php" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-download"></i> Download PDF
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center">
                <div class="report-icon mb-2"><i class="bi bi-printer text-primary"></i></div>
                <h6>Mentoring Summary</h6>
                <p class="small text-muted">Printable mentoring summary</p>
                <a href="<?php echo BASE_URL; ?>exports/print_mentoring_summary.php" target="_blank" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-printer"></i> Print Summary
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 mt-4">
    <div class="card-header bg-white">
        <h6 class="mb-0">Analytics</h6>
    </div>
    <div class="card-body">
        <p class="mb-2">View charts and analytics on the <a href="<?php echo BASE_URL; ?>admin/index.php">Dashboard</a> (risk distribution, attendance trends) and <a href="<?php echo BASE_URL; ?>admin/index.php?page=high_risk">High-Risk Students</a>.</p>
        <a href="<?php echo BASE_URL; ?>analytics.php" class="btn btn-sm btn-outline-secondary">Analytics Page</a>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
