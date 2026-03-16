<?php
$pageTitle = "My Profile";
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
$student = $student ?: [];
$hasRecord = !empty($student['id']);

$x_marks = json_decode($student['x_marks_json'] ?? '[]', true);
$xii_marks = json_decode($student['xii_marks_json'] ?? '[]', true);

function renderMarksTable($prefix, $marks) {
    ?>
    <table class="table table-bordered table-sm small">
        <thead>
            <tr class="table-light">
                <th>Subject Name</th>
                <th>Marks Obtained</th>
                <th>Maximum Marks</th>
            </tr>
        </thead>
        <tbody>
            <?php for($i=0; $i<6; $i++): ?>
            <tr>
                <td><input type="text" name="<?php echo $prefix; ?>_marks[<?php echo $i; ?>][subject]" class="form-control form-control-sm" value="<?php echo sanitize($marks[$i]['subject'] ?? ''); ?>"></td>
                <td><input type="number" name="<?php echo $prefix; ?>_marks[<?php echo $i; ?>][obtained]" class="form-control form-control-sm" value="<?php echo sanitize($marks[$i]['obtained'] ?? ''); ?>"></td>
                <td><input type="number" name="<?php echo $prefix; ?>_marks[<?php echo $i; ?>][max]" class="form-control form-control-sm" value="<?php echo sanitize($marks[$i]['max'] ?? ''); ?>"></td>
            </tr>
            <?php endfor; ?>
        </tbody>
    </table>
    <?php
}
?>

<div class="mb-3">
    <h3>My Profile</h3>
    <?php if (!empty($_GET['saved'])): ?>
        <div class="alert alert-success py-2">Profile updated successfully.</div>
    <?php endif; ?>
</div>

<?php if (!$hasRecord): ?>
    <div class="alert alert-warning">
        <strong>No student record linked to your account.</strong> Ask your admin to link your login to a student record.
    </div>
<?php else: ?>

<form method="post" action="<?php echo BASE_URL; ?>student/index.php?page=profile" enctype="multipart/form-data">
    <input type="hidden" name="<?php echo CSRF_TOKEN_NAME; ?>" value="<?php echo generate_csrf_token(); ?>">

    <!-- Registration info (read-only) -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white"><strong>Registration Info</strong></div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="text-muted small">Roll No / Admission No</label>
                    <div class="fw-bold"><?php echo sanitize($student['roll_no'] ?? '—'); ?></div>
                </div>
                <div class="col-md-3">
                    <label class="text-muted small">Register Number</label>
                    <div class="fw-bold"><?php echo sanitize($student['register_number'] ?? '—'); ?></div>
                </div>
                <div class="col-md-3">
                    <label class="text-muted small">Academic Year</label>
                    <div class="fw-bold"><?php echo sanitize($student['academic_year'] ?? '—'); ?></div>
                </div>
                <div class="col-md-3">
                    <label class="text-muted small">Course</label>
                    <div class="fw-bold"><?php echo sanitize($student['course'] ?? '—'); ?></div>
                </div>
                <div class="col-md-3">
                    <label class="text-muted small">Branch</label>
                    <div class="fw-bold"><?php echo sanitize($student['branch'] ?? $student['department'] ?? '—'); ?></div>
                </div>
                <div class="col-md-3">
                    <label class="text-muted small">Lateral Entry</label>
                    <div class="fw-bold"><?php echo sanitize($student['lateral_entry'] ?? 'No'); ?></div>
                </div>
                <div class="col-md-3">
                    <label class="text-muted small">Quota</label>
                    <div class="fw-bold"><?php echo sanitize($student['quota'] ?? '—'); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Personal info -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white"><strong>Personal Info</strong></div>
        <div class="card-body">
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" name="first_name" class="form-control" required placeholder="First Name" value="<?php echo sanitize($student['first_name'] ?? ''); ?>">
                        <input type="text" name="last_name" class="form-control" required placeholder="Last Name" value="<?php echo sanitize($student['last_name'] ?? ''); ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label">DOB</label>
                    <input type="date" name="dob" class="form-control" value="<?php echo sanitize($student['dob'] ?? ''); ?>">
                </div>
                <div class="col-md-1">
                    <label class="form-label">Age</label>
                    <input type="number" name="age" class="form-control" value="<?php echo (int)($student['age'] ?? 0) ?: ''; ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo sanitize($student['email'] ?? ''); ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Mobile No</label>
                    <input type="text" name="mobile_no" class="form-control" value="<?php echo sanitize($student['mobile_no'] ?? ''); ?>">
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-2">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">Select</option>
                        <option value="Male" <?php echo ($student['gender'] ?? '') === 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo ($student['gender'] ?? '') === 'Female' ? 'selected' : ''; ?>>Female</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Community</label>
                    <input type="text" name="community" class="form-control" value="<?php echo sanitize($student['community'] ?? ''); ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Caste</label>
                    <input type="text" name="caste" class="form-control" value="<?php echo sanitize($student['caste'] ?? ''); ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Nationality</label>
                    <input type="text" name="nationality" class="form-control" value="<?php echo sanitize($student['nationality'] ?? ''); ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Religion</label>
                    <input type="text" name="religion" class="form-control" value="<?php echo sanitize($student['religion'] ?? ''); ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Mother Tongue</label>
                    <input type="text" name="mother_tongue" class="form-control" value="<?php echo sanitize($student['mother_tongue'] ?? ''); ?>">
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <label class="form-label">Linguistic Minority</label>
                    <select name="linguistic_minority" class="form-select">
                        <option value="No" <?php echo ($student['linguistic_minority'] ?? 'No') === 'No' ? 'selected' : ''; ?>>No</option>
                        <option value="Yes" <?php echo ($student['linguistic_minority'] ?? '') === 'Yes' ? 'selected' : ''; ?>>Yes</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Blood Group</label>
                    <input type="text" name="blood_group" class="form-control" value="<?php echo sanitize($student['blood_group'] ?? ''); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Your Goals</label>
                    <input type="text" name="goals" class="form-control" value="<?php echo sanitize($student['goals'] ?? ''); ?>">
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label">How did you hear about our college?</label>
                    <input type="text" name="how_heard_about_college" class="form-control" value="<?php echo sanitize($student['how_heard_about_college'] ?? ''); ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Residency Type</label>
                    <input type="text" name="residency_type" class="form-control" value="<?php echo sanitize($student['residency_type'] ?? ''); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Mode of Transport</label>
                    <input type="text" name="mode_of_transport" class="form-control" value="<?php echo sanitize($student['mode_of_transport'] ?? ''); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Boarding Place</label>
                    <input type="text" name="boarding_place" class="form-control" value="<?php echo sanitize($student['boarding_place'] ?? ''); ?>">
                </div>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Address for Communication</label>
                    <textarea name="address_communication" class="form-control" rows="2"><?php echo sanitize($student['address_communication'] ?? ''); ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Permanent Address</label>
                    <textarea name="address_permanent" class="form-control" rows="2"><?php echo sanitize($student['address_permanent'] ?? ''); ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Parents Information -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white"><strong>Parents Information</strong></div>
        <div class="card-body">
            <div class="row g-4">
                <!-- Father's Info -->
                <div class="col-md-6">
                    <h6 class="border-bottom pb-2 mb-3">Father's Details</h6>
                    <div class="mb-2">
                        <label class="form-label small mb-1">Name</label>
                        <input type="text" name="father_name" class="form-control" value="<?php echo sanitize($student['father_name'] ?? ''); ?>">
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label small mb-1">Mobile</label>
                            <input type="text" name="father_mobile" class="form-control" value="<?php echo sanitize($student['father_mobile'] ?? ''); ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label small mb-1">Email</label>
                            <input type="email" name="father_email" class="form-control" value="<?php echo sanitize($student['father_email'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label small mb-1">Qualification</label>
                            <input type="text" name="father_qualification" class="form-control" value="<?php echo sanitize($student['father_qualification'] ?? ''); ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label small mb-1">Occupation</label>
                            <input type="text" name="father_occupation" class="form-control" value="<?php echo sanitize($student['father_occupation'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small mb-1">Office Address</label>
                        <textarea name="father_office_address" class="form-control" rows="2"><?php echo sanitize($student['father_office_address'] ?? ''); ?></textarea>
                    </div>
                    <div>
                        <label class="form-label small mb-1">Annual Income</label>
                        <input type="text" name="father_annual_income" class="form-control" value="<?php echo sanitize($student['father_annual_income'] ?? ''); ?>">
                    </div>
                </div>
                <!-- Mother's Info -->
                <div class="col-md-6">
                    <h6 class="border-bottom pb-2 mb-3">Mother's Details</h6>
                    <div class="mb-2">
                        <label class="form-label small mb-1">Name</label>
                        <input type="text" name="mother_name" class="form-control" value="<?php echo sanitize($student['mother_name'] ?? ''); ?>">
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label small mb-1">Mobile</label>
                            <input type="text" name="mother_mobile" class="form-control" value="<?php echo sanitize($student['mother_mobile'] ?? ''); ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label small mb-1">Email</label>
                            <input type="email" name="mother_email" class="form-control" value="<?php echo sanitize($student['mother_email'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label small mb-1">Qualification</label>
                            <input type="text" name="mother_qualification" class="form-control" value="<?php echo sanitize($student['mother_qualification'] ?? ''); ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label small mb-1">Occupation</label>
                            <input type="text" name="mother_occupation" class="form-control" value="<?php echo sanitize($student['mother_occupation'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small mb-1">Office Address</label>
                        <textarea name="mother_office_address" class="form-control" rows="2"><?php echo sanitize($student['mother_office_address'] ?? ''); ?></textarea>
                    </div>
                    <div>
                        <label class="form-label small mb-1">Annual Income</label>
                        <input type="text" name="mother_annual_income" class="form-control" value="<?php echo sanitize($student['mother_annual_income'] ?? ''); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Academic Detail -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white"><strong>Academic Detail</strong></div>
        <div class="card-body">
            <!-- X Std -->
            <div class="mb-4">
                <h6 class="border-bottom pb-2 mb-3">Standard X or equivalent</h6>
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label small mb-1">Name of School</label>
                        <input type="text" name="x_school_name" class="form-control" value="<?php echo sanitize($student['x_school_name'] ?? ''); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small mb-1">Register No</label>
                        <input type="text" name="x_register_no" class="form-control" value="<?php echo sanitize($student['x_register_no'] ?? ''); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small mb-1">Board of Education</label>
                        <input type="text" name="x_board" class="form-control" value="<?php echo sanitize($student['x_board'] ?? ''); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small mb-1">Medium</label>
                        <input type="text" name="x_medium" class="form-control" value="<?php echo sanitize($student['x_medium'] ?? ''); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small mb-1">Passing Month & Year</label>
                        <input type="text" name="x_passing_month_year" class="form-control" value="<?php echo sanitize($student['x_passing_month_year'] ?? ''); ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small mb-1">Subjects & Marks</label>
                    <?php renderMarksTable('x', $x_marks); ?>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label small mb-1">Total Marks Obtained</label>
                        <input type="text" name="x_total_marks" class="form-control" value="<?php echo sanitize($student['x_total_marks'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small mb-1">Overall % or CGPA</label>
                        <input type="text" name="x_percentage_cgpa" class="form-control" value="<?php echo sanitize($student['x_percentage_cgpa'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small mb-1">Upload Marksheet</label>
                        <input type="file" name="x_marksheet" class="form-control">
                        <?php if(!empty($student['x_marksheet_path'])): ?>
                            <small class="text-success"><i class="bi bi-file-earmark-check"></i> Already uploaded: <a href="<?php echo BASE_URL . $student['x_marksheet_path']; ?>" target="_blank">View</a></small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- XII Std -->
            <div>
                <h6 class="border-bottom pb-2 mb-3">Qualifying Examination (10+2)</h6>
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label small mb-1">Name of School/College</label>
                        <input type="text" name="xii_school_name" class="form-control" value="<?php echo sanitize($student['xii_school_name'] ?? ''); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small mb-1">Register No</label>
                        <input type="text" name="xii_register_no" class="form-control" value="<?php echo sanitize($student['xii_register_no'] ?? ''); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small mb-1">Board of Education</label>
                        <input type="text" name="xii_board" class="form-control" value="<?php echo sanitize($student['xii_board'] ?? ''); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small mb-1">Medium</label>
                        <input type="text" name="xii_medium" class="form-control" value="<?php echo sanitize($student['xii_medium'] ?? ''); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small mb-1">Passing Month & Year</label>
                        <input type="text" name="xii_passing_month_year" class="form-control" value="<?php echo sanitize($student['xii_passing_month_year'] ?? ''); ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small mb-1">Subjects & Marks</label>
                    <?php renderMarksTable('xii', $xii_marks); ?>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small mb-1">Total Marks Obtained</label>
                        <input type="text" name="xii_total_marks" class="form-control" value="<?php echo sanitize($student['xii_total_marks'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small mb-1">Overall % or CGPA</label>
                        <input type="text" name="xii_percentage_cgpa" class="form-control" value="<?php echo sanitize($student['xii_percentage_cgpa'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small mb-1">Upload Marksheet</label>
                        <input type="file" name="xii_marksheet" class="form-control">
                        <?php if(!empty($student['xii_marksheet_path'])): ?>
                            <small class="text-success"><i class="bi bi-file-earmark-check"></i> Already uploaded: <a href="<?php echo BASE_URL . $student['xii_marksheet_path']; ?>" target="_blank">View</a></small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aadhar and Free Education -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white"><strong>Identity & Other Details</strong></div>
        <div class="card-body">
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Aadhar Number</label>
                    <input type="text" name="aadhar_number" class="form-control" value="<?php echo sanitize($student['aadhar_number'] ?? ''); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Upload Aadhar</label>
                    <input type="file" name="aadhar_file" class="form-control">
                    <?php if(!empty($student['aadhar_path'])): ?>
                        <small class="text-success"><i class="bi bi-file-earmark-check"></i> Already uploaded: <a href="<?php echo BASE_URL . $student['aadhar_path']; ?>" target="_blank">View</a></small>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">First Graduate? (Yes/No)</label>
                    <select name="is_first_graduate" class="form-select">
                        <option value="No" <?php echo ($student['is_first_graduate'] ?? 'No') === 'No' ? 'selected' : ''; ?>>No</option>
                        <option value="Yes" <?php echo ($student['is_first_graduate'] ?? '') === 'Yes' ? 'selected' : ''; ?>>Yes</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">FG Certificate Upload</label>
                    <input type="file" name="fg_certificate" class="form-control">
                    <?php if(!empty($student['fg_certificate_path'])): ?>
                        <small class="text-success"><i class="bi bi-file-earmark-check"></i> Already uploaded: <a href="<?php echo BASE_URL . $student['fg_certificate_path']; ?>" target="_blank">View</a></small>
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Reference (if any field)</label>
                    <input type="text" name="reference" class="form-control" value="<?php echo sanitize($student['reference'] ?? ''); ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between mb-5">
        <a href="<?php echo BASE_URL; ?>student/index.php" class="btn btn-secondary">Back</a>
        <button type="submit" class="btn btn-primary px-5">Update Profile</button>
    </div>
</form>

<?php endif; ?>
<?php include __DIR__ . '/../partials/footer.php'; ?>
