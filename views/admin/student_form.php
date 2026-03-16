<?php
$pageTitle = $student ? 'Edit Student' : 'Add Student';
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
$student = $student ?: [];
?>
<div class="page-heading">
    <h3><?php echo $student ? 'Edit Student' : 'Add Student'; ?></h3>
    <a href="<?php echo BASE_URL; ?>admin/index.php?page=students" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>

<form method="post" action="<?php echo BASE_URL; ?>admin/index.php?page=student_save">
    <input type="hidden" name="<?php echo CSRF_TOKEN_NAME; ?>" value="<?php echo generate_csrf_token(); ?>">
    <?php if (!empty($student['id'])): ?>
        <input type="hidden" name="id" value="<?php echo (int)$student['id']; ?>">
    <?php endif; ?>

    <?php if (empty($student['id'])): ?>
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-header bg-white">Link to login (optional)</div>
        <div class="card-body">
            <select name="user_id" class="form-select" style="max-width:300px">
                <option value="0">— None —</option>
                <?php foreach ($users as $u): ?>
                    <option value="<?php echo (int)$u['id']; ?>"><?php echo sanitize($u['username']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 mb-3">
        <div class="card-header bg-white"><strong>Registration info</strong></div>
        <div class="card-body">
            <div class="row g-2 mb-2">
                <div class="col-md-4">
                    <label class="form-label">Register Number <span class="text-danger">*</span></label>
                    <input type="text" name="register_number" class="form-control" required value="<?php echo sanitize($student['register_number'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Roll No / Admission No</label>
                    <input type="text" name="roll_no" class="form-control" value="<?php echo sanitize($student['roll_no'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Academic Year</label>
                    <input type="text" name="academic_year" class="form-control" placeholder="e.g. 2024-2025" value="<?php echo sanitize($student['academic_year'] ?? ''); ?>">
                </div>
            </div>
            <div class="row g-2 mb-2">
                <div class="col-md-4">
                    <label class="form-label">Course</label>
                    <input type="text" name="course" class="form-control" placeholder="e.g. B.E." value="<?php echo sanitize($student['course'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Branch / Department <span class="text-danger">*</span></label>
                    <input type="text" name="branch" class="form-control" value="<?php echo sanitize($student['branch'] ?? $student['department'] ?? ''); ?>" placeholder="e.g. CSE">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Lateral Entry</label>
                    <select name="lateral_entry" class="form-select">
                        <option value="No" <?php echo ($student['lateral_entry'] ?? '') === 'Yes' ? '' : 'selected'; ?>>No</option>
                        <option value="Yes" <?php echo ($student['lateral_entry'] ?? '') === 'Yes' ? 'selected' : ''; ?>>Yes</option>
                    </select>
                </div>
            </div>
            <div class="row g-2">
                <div class="col-md-4">
                    <label class="form-label">Quota</label>
                    <select name="quota" class="form-select">
                        <option value="">— Select —</option>
                        <option value="govt" <?php echo ($student['quota'] ?? '') === 'govt' ? 'selected' : ''; ?>>Government</option>
                        <option value="management" <?php echo ($student['quota'] ?? '') === 'management' ? 'selected' : ''; ?>>Management</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Program</label>
                    <input type="text" name="program" class="form-control" placeholder="e.g. B.Tech" value="<?php echo sanitize($student['program'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Semester</label>
                    <select name="semester" class="form-select">
                        <?php for ($i = 1; $i <= 8; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo (int)($student['semester'] ?? 0) === $i ? 'selected' : ''; ?>><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="row g-2">
                <div class="col-md-4">
                    <label class="form-label">Domain</label>
                    <input type="text" name="domain" class="form-control" placeholder="e.g. Cyber Security" value="<?php echo sanitize($student['domain'] ?? ''); ?>">
                </div>
                <div class="col-md-4 p-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_honours" value="1" id="honoursCheck" <?php echo ($student['is_honours'] ?? 0) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="honoursCheck">Is Honours Student?</label>
                    </div>
                </div>
                <div class="col-md-4 p-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_minor" value="1" id="minorCheck" <?php echo ($student['is_minor'] ?? 0) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="minorCheck">Is Minor Student?</label>
                    </div>
                </div>
            </div>

    <div class="card shadow-sm border-0 mb-3">
        <div class="card-header bg-white"><strong>Personal info</strong></div>
        <div class="card-body">
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
            <div class="row g-2">
                <div class="col-12">
                    <label class="form-label">Permanent address</label>
                    <textarea name="address_permanent" class="form-control" rows="2"><?php echo sanitize($student['address_permanent'] ?? ''); ?></textarea>
                </div>
            </div>
            <input type="hidden" name="address" value="">
        </div>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary"><i class="bi bi-check2"></i> Save Student</button>
        <a href="<?php echo BASE_URL; ?>admin/index.php?page=students" class="btn btn-secondary">Cancel</a>
    </div>
</form>
<?php include __DIR__ . '/../partials/footer.php'; ?>
