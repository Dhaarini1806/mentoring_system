<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Student.php';
require_role('admin');

// Require TCPDF main file (after you install the library)
require_once __DIR__ . '/../vendor/tcpdf/tcpdf.php';

$studentModel = new Student();
$students = $studentModel->getAll(10000, 0);

$pdf = new TCPDF();
$pdf->SetCreator('Mentoring System');
$pdf->SetAuthor('Mentoring System');
$pdf->SetTitle('Student List');
$pdf->AddPage();

$html = '<h2>Student List</h2><table border="1" cellspacing="0" cellpadding="4">
<tr><th>ID</th><th>Roll No</th><th>Name</th><th>Department</th><th>Semester</th><th>Risk</th></tr>';
foreach ($students as $s) {
    $html .= '<tr>
        <td>'.(int)$s['id'].'</td>
        <td>'.htmlspecialchars($s['roll_no']).'</td>
        <td>'.htmlspecialchars($s['first_name'].' '.$s['last_name']).'</td>
        <td>'.htmlspecialchars($s['department']).'</td>
        <td>'.(int)$s['semester'].'</td>
        <td>'.htmlspecialchars($s['risk_level']).'</td>
    </tr>';
}
$html .= '</table>';

$pdf->writeHTML($html);
$pdf->Output('students.pdf', 'I');
exit;