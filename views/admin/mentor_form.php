<?php
$pageTitle = $mentor ? 'Edit Mentor' : 'Add Mentor';
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
$mentor = $mentor ?: [];
?>
<div class="page-heading">
    <h3><?php echo $mentor ? 'Edit Mentor' : 'Add Mentor'; ?></h3>
    <a href="<?php echo BASE_URL; ?>admin/index.php?page=mentors" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="post" action="<?php echo BASE_URL; ?>admin/index.php?page=mentor_save">
            <input type="hidden" name="<?php echo CSRF_TOKEN_NAME; ?>" value="<?php echo generate_csrf_token(); ?>">
            <?php if (!empty($mentor['id'])): ?>
                <input type="hidden" name="id" value="<?php echo (int)$mentor['id']; ?>">
            <?php endif; ?>

            <?php if (empty($mentor['id'])): ?>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Link to login account (optional)</label>
                <div class="col-sm-6">
                    <select name="user_id" class="form-select">
                        <option value="0">— None —</option>
                        <?php foreach ($users as $u): ?>
                            <option value="<?php echo (int)$u['id']; ?>"><?php echo sanitize($u['username']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <?php endif; ?>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Staff ID <span class="text-danger">*</span></label>
                <div class="col-sm-6">
                    <input type="text" name="staff_id" class="form-control" required
                           value="<?php echo sanitize($mentor['staff_id'] ?? ''); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name <span class="text-danger">*</span></label>
                <div class="col-sm-6">
                    <input type="text" name="name" class="form-control" required
                           value="<?php echo sanitize($mentor['name'] ?? ''); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Department <span class="text-danger">*</span></label>
                <div class="col-sm-6">
                    <input type="text" name="department" class="form-control" required
                           value="<?php echo sanitize($mentor['department'] ?? ''); ?>" placeholder="e.g. CSE, ECE">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Designation</label>
                <div class="col-sm-6">
                    <input type="text" name="designation" class="form-control"
                           value="<?php echo sanitize($mentor['designation'] ?? ''); ?>" placeholder="e.g. Assistant Professor">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Contact No</label>
                <div class="col-sm-6">
                    <input type="text" name="contact_no" class="form-control"
                           value="<?php echo sanitize($mentor['contact_no'] ?? ''); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="email" name="email" class="form-control"
                           value="<?php echo sanitize($mentor['email'] ?? ''); ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 offset-sm-3">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check2"></i> Save Mentor</button>
                    <a href="<?php echo BASE_URL; ?>admin/index.php?page=mentors" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
