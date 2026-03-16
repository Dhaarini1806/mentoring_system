<?php
$pageTitle = "My Students";
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
$students = $students ?? [];
?>
<div class="mb-4">
    <h3>My Students</h3>
    <p class="text-muted mb-3">Assigned students — add counseling, attendance, and marks.</p>
    
    <!-- Filters -->
    <div class="card shadow-sm border-0 bg-light">
        <div class="card-body py-2">
            <form class="row g-2 align-items-center" id="filterForm">
                <div class="col-auto">
                    <label class="small fw-bold">Filter By:</label>
                </div>
                <div class="col-md-3">
                    <select class="form-select form-select-sm" id="domainFilter">
                        <option value="">All Domains</option>
                        <?php 
                        $domains = array_unique(array_filter(array_column($students, 'domain')));
                        foreach ($domains as $d): ?>
                            <option value="<?php echo sanitize($d); ?>"><?php echo sanitize($d); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-auto">
                    <div class="form-check form-check-inline small">
                        <input class="form-check-input" type="checkbox" id="honoursFilter">
                        <label class="form-check-label" for="honoursFilter">Honours</label>
                    </div>
                    <div class="form-check form-check-inline small">
                        <input class="form-check-input" type="checkbox" id="minorFilter">
                        <label class="form-check-label" for="minorFilter">Minor</label>
                    </div>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-sm btn-primary" onclick="applyFilters()">Apply</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="resetFilters()">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if (empty($students)): ?>
    <div class="alert alert-info">No students assigned to you yet. Contact admin for mentor assignment.</div>
<?php else: ?>
<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Roll No</th>
                <th>Name</th>
                <th>Domain</th>
                <th>Classification</th>
                <th>Risk</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $s): ?>
                <?php
                $badge = 'success';
                if (($s['risk_level'] ?? '') === 'HIGH') $badge = 'danger';
                elseif (($s['risk_level'] ?? '') === 'MEDIUM') $badge = 'warning';
                $name = trim(($s['first_name'] ?? '') . ' ' . ($s['last_name'] ?? ''));
                if ($name === '') $name = $s['name'] ?? '—';
                ?>
                <tr class="student-row" 
                    data-domain="<?php echo sanitize($s['domain'] ?? ''); ?>" 
                    data-honours="<?php echo (int)($s['is_honours'] ?? 0); ?>" 
                    data-minor="<?php echo (int)($s['is_minor'] ?? 0); ?>">
                    <td><?php echo sanitize($s['roll_no'] ?? '—'); ?></td>
                    <td><?php echo sanitize($name); ?></td>
                    <td><span class="small"><?php echo sanitize($s['domain'] ?? '—'); ?></span></td>
                    <td>
                        <?php if ($s['is_honours']): ?>
                            <span class="badge bg-info text-dark">Honours</span>
                        <?php endif; ?>
                        <?php if ($s['is_minor']): ?>
                            <span class="badge bg-secondary">Minor</span>
                        <?php endif; ?>
                        <?php if (!$s['is_honours'] && !$s['is_minor']): ?>
                            <span class="text-muted small">Regular</span>
                        <?php endif; ?>
                    </td>
                    <td><span class="badge bg-<?php echo $badge; ?>"><?php echo $s['risk_level'] ?? 'SAFE'; ?></span></td>
                    <td>
                        <a href="<?php echo BASE_URL; ?>mentor/index.php?page=student_profile&student_id=<?php echo (int)$s['id']; ?>" class="btn btn-sm btn-outline-secondary" title="Profile"><i class="bi bi-person"></i></a>
                        <a href="<?php echo BASE_URL; ?>mentor/index.php?page=counseling_form&student_id=<?php echo (int)$s['id']; ?>" class="btn btn-sm btn-outline-primary" title="Counseling"><i class="bi bi-chat-left-text"></i></a>
                        <a href="<?php echo BASE_URL; ?>mentor/index.php?page=attendance_form&student_id=<?php echo (int)$s['id']; ?>" class="btn btn-sm btn-outline-info" title="Attendance"><i class="bi bi-calendar-check"></i></a>
                        <a href="<?php echo BASE_URL; ?>mentor/index.php?page=marks_form&student_id=<?php echo (int)$s['id']; ?>" class="btn btn-sm btn-outline-success" title="Marks"><i class="bi bi-journal-text"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
<script>
function applyFilters() {
    const domain = document.getElementById('domainFilter').value;
    const honours = document.getElementById('honoursFilter').checked;
    const minor = document.getElementById('minorFilter').checked;
    
    document.querySelectorAll('.student-row').forEach(row => {
        let show = true;
        if (domain && row.dataset.domain !== domain) show = false;
        if (honours && row.dataset.honours !== '1') show = false;
        if (minor && row.dataset.minor !== '1') show = false;
        
        row.style.display = show ? '' : 'none';
    });
}

function resetFilters() {
    document.getElementById('domainFilter').value = '';
    document.getElementById('honoursFilter').checked = false;
    document.getElementById('minorFilter').checked = false;
    document.querySelectorAll('.student-row').forEach(row => row.style.display = '');
}
</script>
<?php include __DIR__ . '/../partials/footer.php'; ?>
