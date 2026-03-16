<?php
$role = $_SESSION['user']['role'] ?? '';
?>
<div class="sidebar border-end">
    <div class="list-group list-group-flush pt-3">
        <?php if ($role === 'admin'): ?>
            <a href="<?php echo BASE_URL; ?>admin/index.php" class="list-group-item list-group-item-action">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="<?php echo BASE_URL; ?>admin/index.php?page=students" class="list-group-item list-group-item-action">
                <i class="bi bi-people"></i> Students
            </a>
            <a href="<?php echo BASE_URL; ?>admin/index.php?page=mentors" class="list-group-item list-group-item-action">
                <i class="bi bi-person-badge"></i> Mentors
            </a>
            <a href="<?php echo BASE_URL; ?>admin/index.php?page=mentor_assignment" class="list-group-item list-group-item-action">
                <i class="bi bi-link-45deg"></i> Mentor Assignment
            </a>
            <a href="<?php echo BASE_URL; ?>admin/index.php?page=high_risk" class="list-group-item list-group-item-action">
                <i class="bi bi-exclamation-triangle"></i> High-Risk Students
            </a>
            <a href="<?php echo BASE_URL; ?>admin/index.php?page=reports" class="list-group-item list-group-item-action">
                <i class="bi bi-file-earmark-bar-graph"></i> Reports
            </a>
            <a href="<?php echo BASE_URL; ?>admin/index.php?page=import" class="list-group-item list-group-item-action">
                <i class="bi bi-cloud-arrow-up"></i> Bulk Import
            </a>
        <?php elseif ($role === 'mentor'): ?>
            <a href="<?php echo BASE_URL; ?>mentor/index.php" class="list-group-item list-group-item-action">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="<?php echo BASE_URL; ?>mentor/index.php?page=students" class="list-group-item list-group-item-action">
                <i class="bi bi-people"></i> My Students
            </a>
        <?php elseif ($role === 'student'): ?>
            <a href="<?php echo BASE_URL; ?>student/index.php" class="list-group-item list-group-item-action">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="<?php echo BASE_URL; ?>student/index.php?page=profile" class="list-group-item list-group-item-action">
                <i class="bi bi-person"></i> Profile
            </a>
            <a href="<?php echo BASE_URL; ?>student/index.php?page=attendance" class="list-group-item list-group-item-action">
                <i class="bi bi-calendar-check"></i> Attendance
            </a>
            <a href="<?php echo BASE_URL; ?>student/index.php?page=marks" class="list-group-item list-group-item-action">
                <i class="bi bi-journal-text"></i> Marks
            </a>
            <a href="<?php echo BASE_URL; ?>student/index.php?page=counseling" class="list-group-item list-group-item-action">
                <i class="bi bi-chat-left-text"></i> Counseling History
            </a>
        <?php endif; ?>
    </div>
</div>
<div class="content-area">