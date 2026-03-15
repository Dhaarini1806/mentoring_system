<?php
$pageTitle = "Admin Dashboard";
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
?>
<h3 class="mb-4">Admin Dashboard</h3>
<div class="row g-3">
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Total Students</h6>
                <h3><?php echo (int)$totalStudents; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Total Mentors</h6>
                <h3><?php echo (int)$totalMentors; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">High Risk</h6>
                <h3 class="text-danger"><?php echo (int)$high; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Medium Risk</h6>
                <h3 class="text-warning"><?php echo (int)$medium; ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4 g-3">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h6 class="mb-0">Risk Distribution</h6>
            </div>
            <div class="card-body">
                <canvas id="riskChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h6 class="mb-0">Attendance Trend</h6>
            </div>
            <div class="card-body">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo BASE_URL; ?>assets/js/dashboard.js"></script>
<?php include __DIR__ . '/../partials/footer.php'; ?>