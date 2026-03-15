<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../models/MentorAssignment.php';
require_once __DIR__ . '/../models/Attendance.php';
require_once __DIR__ . '/../models/Marks.php';
require_once __DIR__ . '/../models/CounselingSession.php';

require_role('admin'); // you can also allow mentor

$studentId = (int)($_GET['student_id'] ?? 0);
$studentModel = new Student();
$assignModel = new MentorAssignment();
$attendance = new Attendance();
$marks = new Marks();
$sessions = new CounselingSession();

$student = $studentModel->getById($studentId);
$mentor = $assignModel->getMentorByStudent($studentId);
$attRows = $attendance->getByStudent($studentId);
$markRows = $marks->getByStudent($studentId);
$sessionRows = $sessions->getByStudent($studentId);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mentoring Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body onload="window.print()">
<div class="container mt-4">
    <h3>Mentoring Summary - <?php echo htmlspecialchars($student['first_name'].' '.$student['last_name']); ?></h3>
    <p><strong>Roll No:</strong> <?php echo htmlspecialchars($student['roll_no']); ?> |
       <strong>Department:</strong> <?php echo htmlspecialchars($student['department']); ?></p>
    <p><strong>Mentor:</strong> <?php echo $mentor ? htmlspecialchars($mentor['name']) : 'N/A'; ?></p>

    <h5 class="mt-4">Attendance</h5>
    <table class="table table-sm table-bordered">
        <thead><tr><th>Month</th><th>Total</th><th>Attended</th><th>%</th></tr></thead>
        <tbody>
        <?php foreach ($attRows as $r): 
            $p = $r['total_classes'] ? ($r['attended_classes'] / $r['total_classes'] * 100) : 0;
        ?>
            <tr>
                <td><?php echo htmlspecialchars($r['month_year']); ?></td>
                <td><?php echo (int)$r['total_classes']; ?></td>
                <td><?php echo (int)$r['attended_classes']; ?></td>
                <td><?php echo number_format($p, 2); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h5 class="mt-4">Marks</h5>
    <table class="table table-sm table-bordered">
        <thead><tr><th>Subject</th><th>Exam</th><th>Mark</th><th>Max</th></tr></thead>
        <tbody>
        <?php foreach ($markRows as $m): ?>
            <tr>
                <td><?php echo htmlspecialchars($m['subject_name']); ?></td>
                <td><?php echo htmlspecialchars($m['exam_type']); ?></td>
                <td><?php echo $m['internal_mark']; ?></td>
                <td><?php echo $m['max_mark']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h5 class="mt-4">Counseling Sessions</h5>
    <table class="table table-sm table-bordered">
        <thead><tr><th>Date</th><th>Mode</th><th>Mentor</th><th>Summary</th><th>Action Items</th></tr></thead>
        <tbody>
        <?php foreach ($sessionRows as $s): ?>
            <tr>
                <td><?php echo htmlspecialchars($s['session_date']); ?></td>
                <td><?php echo htmlspecialchars($s['mode']); ?></td>
                <td><?php echo htmlspecialchars($s['mentor_name']); ?></td>
                <td><?php echo htmlspecialchars($s['summary']); ?></td>
                <td><?php echo htmlspecialchars($s['action_items']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>