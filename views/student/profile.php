<?php
$pageTitle = "My Profile";
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
$student = $student ?? [];
$hasRecord = !empty($student['id']);
?>
<div class="mb-3">
    <h3>My Profile</h3>
    <?php if (!empty($_GET['saved'])): ?>
        <div class="alert alert-success py-2">Profile updated successfully.</div>
    <?php endif; ?>
</div>

<?php if (!$hasRecord): ?>
    <div class="alert alert-warning">
        <strong>No student record linked to your account.</strong> Ask your admin to link your login to a student record, or to create a student with your user account.
    </div>
<?php else: ?>

<!-- Registration info (read-only) -->
<div class="card shadow-sm border-0 mb-3">
    <div class="card-header bg-white"><strong>Registration info</strong></div>
    <div class="card-body">
        <div class="row g-2 small">
            <div class="col-md-4"><span class="text-muted">Roll No / Admission No</span><br><?php echo sanitize($student['roll_no'] ?? '—'); ?></div>
            <div class="col-md-4"><span class="text-muted">Register Number</span><br><?php echo sanitize($student['register_number'] ?? '—'); ?></div>
            <div class="col-md-4"><span class="text-muted">Academic Year</span><br><?php echo sanitize($student['academic_year'] ?? '—'); ?></div>
            <div class="col-md-4"><span class="text-muted">Course</span><br><?php echo sanitize($student['course'] ?? '—'); ?></div>
            <div class="col-md-4"><span class="text-muted">Branch</span><br><?php echo sanitize($student['branch'] ?? $student['department'] ?? '—'); ?></div>
            <div class="col-md-4"><span class="text-muted">Lateral Entry</span><br><?php echo sanitize($student['lateral_entry'] ?? '—'); ?></div>
            <div class="col-md-4"><span class="text-muted">Quota</span><br><?php echo sanitize($student['quota'] ?? '—'); ?></div>
            <div class="col-md-4"><span class="text-muted">Program</span><br><?php echo sanitize($student['program'] ?? '—'); ?></div>
            <div class="col-md-4"><span class="text-muted">Semester</span><br><?php echo (int)($student['semester'] ?? 0) ?: '—'; ?></div>
        </div>
    </div>
</div>

<!-- Personal info (editable) -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white"><strong>Personal info</strong> — you can update these</div>
    <div class="card-body">
        <form method="post" action="<?php echo BASE_URL; ?>student/index.php?page=profile">
            <input type="hidden" name="<?php echo CSRF_TOKEN_NAME; ?>" value="<?php echo generate_csrf_token(); ?>">
            <div class="row g-2 mb-2">
                <div class="col-md-4">
                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" class="form-control" required value="<?php echo sanitize($student['first_name'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="last_name" class="form-control" required value="<?php echo sanitize($student['last_name'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">DOB</label>
                    <input type="date" name="dob" class="form-control" value="<?php echo sanitize($student['dob'] ?? ''); ?>">
                </div>
            </div>
            <div class="row g-2 mb-2">
                <div class="col-md-4">
                    <label class="form-label">Age</label>
                    <input type="number" name="age" class="form-control" min="1" max="120" value="<?php echo (int)($student['age'] ?? 0) ?: ''; ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo sanitize($student['email'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Mobile No</label>
                    <input type="text" name="mobile_no" class="form-control" value="<?php echo sanitize($student['mobile_no'] ?? $student['contact_no'] ?? ''); ?>">
                </div>
            </div>
            <div class="row g-2 mb-2">
                <div class="col-md-4">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">— Select —</option>
                        <option value="Male" <?php echo ($student['gender'] ?? '') === 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo ($student['gender'] ?? '') === 'Female' ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?php echo ($student['gender'] ?? '') === 'Other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Community</label>
                    <input type="text" name="community" class="form-control" value="<?php echo sanitize($student['community'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Caste</label>
                    <input type="text" name="caste" class="form-control" value="<?php echo sanitize($student['caste'] ?? ''); ?>">
                </div>
            </div>
            <div class="row g-2 mb-2">
                <div class="col-md-4">
                    <label class="form-label">Nationality</label>
                    <input type="text" name="nationality" class="form-control" value="<?php echo sanitize($student['nationality'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Religion</label>
                    <input type="text" name="religion" class="form-control" value="<?php echo sanitize($student['religion'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Contact No (alt)</label>
                    <input type="text" name="contact_no" class="form-control" value="<?php echo sanitize($student['contact_no'] ?? ''); ?>">
                </div>
            </div>
            <div class="row g-2 mb-2">
                <div class="col-12">
                    <label class="form-label">Address for communication</label>
                    <textarea name="address_communication" class="form-control" rows="2"><?php echo sanitize($student['address_communication'] ?? $student['address'] ?? ''); ?></textarea>
                </div>
            </div>
            <div class="row g-2 mb-2">
                <div class="col-12">
                    <label class="form-label">Permanent address</label>
                    <textarea name="address_permanent" class="form-control" rows="2"><?php echo sanitize($student['address_permanent'] ?? ''); ?></textarea>
                </div>
            </div>
            <input type="hidden" name="department" value="<?php echo sanitize($student['department'] ?? $student['branch'] ?? ''); ?>">
            <input type="hidden" name="program" value="<?php echo sanitize($student['program'] ?? ''); ?>">
            <input type="hidden" name="semester" value="<?php echo (int)($student['semester'] ?? 0); ?>">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check2"></i> Update Profile</button>
        </form>
    </div>
</div>
<?php endif; ?>
<?php include __DIR__ . '/../partials/footer.php'; ?>
