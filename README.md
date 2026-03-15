Abstract

The Student Mentoring Management System is a web-based portal for colleges to manage mentor–mentee relationships, student performance tracking, counseling documentation, and risk detection. It replaces manual workflows with a secure, role-based system for administrators, mentors, and students, providing real-time analytics and institutional reporting.

Objectives

Digitize mentoring records: Store attendance, marks, counseling sessions, and mentor assignments in a centralized system.
Enable proactive risk detection: Automatically classify students into risk categories based on academic and counseling indicators.
Improve transparency: Provide dashboards and portals for admin, mentors, and students to access relevant data.
Support decision-making: Offer analytics and exportable reports for institutional review and accreditation purposes.
Ensure security and compliance: Implement secure authentication, access control, and auditing.
System Architecture Explanation

Presentation Layer: HTML5, Bootstrap 5, and vanilla JavaScript render responsive dashboards, forms, tables, and charts for each user role.
Business Logic Layer: PHP controllers (AdminController, MentorController, StudentController, AuthController, AnalyticsController) handle HTTP requests, orchestrate models, enforce validation, and perform redirections.
Data Access Layer: PHP models encapsulate PDO-based prepared queries for each entity (Student, Mentor, Attendance, Marks, CounselingSession, MentorAssignment, AuditLog).
Security Layer: config/config.php centralizes session management, CSRF tokens, input sanitization, and role-based authorization checks (require_role), with AuditLog providing traceability.
ER Diagram Explanation (conceptual)

Entities:

User: Attributes (id, username, password_hash, role, email) – base entity for all login accounts.
Student: Attributes (id, user_id, roll_no, personal and academic details, risk_level). Relationship: many students to one user (1:1 in practice via FK).
Mentor: Attributes (id, user_id, staff_id, name, department). Relationship: many mentors to one user (1:1 in practice).
MentorAssignment: Associates mentor and student in a many-to-many relationship with uniqueness constraint.
Attendance: Records monthly attendance per student (student_id, month_year, total_classes, attended_classes) – relationship: one student to many attendance records.
Marks: Records subject-wise internal marks per student – relationship: one student to many marks records.
CounselingSession: Captures mentoring sessions between mentor and student – relationships: many sessions to one mentor and one student.
AuditLog: Logs user-level events (user_id, action, details).
Keys and constraints ensure referential integrity (ON DELETE CASCADE for student and mentor children, SET NULL for audit logs).

DFD Level 0 Explanation

Single external entity: User (admin, mentor, student).
Single main process: Student Mentoring Management System.
Main data stores: Users, Students, Mentors, MentorAssignment, Attendance, Marks, CounselingSessions, AuditLogs.
Data flow: Users send login and operation requests; the system authenticates, accesses data stores, updates records, recalculates risk, and returns views and reports.
DFD Level 1 Explanation (decomposed processes)

1.0 Authentication & Security: Handles login, session management, role checks, CSRF validation, and logs actions.
2.0 Admin Management: CRUD operations for students and mentors, mentor assignment, high-risk listing, and report exports.
3.0 Mentoring Operations: Mentor views assigned students, records attendance, marks, and counseling sessions; triggers risk recalculation.
4.0 Student Self-Service: Students view mentor information, attendance, marks, risk status, counseling history; can update selected profile fields.
5.0 Analytics & Reporting: Aggregates risk distribution, attendance trends, and mentor performance for visualizations and downloadable reports.
Module Descriptions

Admin Module: Central dashboard with key metrics; CRUD screens for students and mentors; mentor-to-student assignment; risk-based student listing; Excel/PDF/printable reports.
Mentor Module: Mentor dashboard with list of assigned students and their risk levels; forms for counseling sessions, attendance entry, marks entry; quick navigation to student profiles and progress tracking.
Student Module: Student dashboard with risk badge, attendance and marks overview; profile management; detailed attendance, marks, and counseling history.
Risk Engine: Backend component that uses attendance percentage, average internal marks, and counseling recency to classify students into HIGH/MEDIUM/SAFE categories.
Analytics Module: Chart.js-based visualizations for risk distribution and attendance trends via JSON endpoints.
Testing Scenarios

Authentication:
Valid login for each role.
Invalid credentials rejection.
Unauthorized access redirection (e.g., student trying to open admin URL).
CSRF and security:
Submitting forms with missing/invalid CSRF token should fail.
Session regeneration after login.
Direct access to config and vendor folders blocked.
Admin operations:
Create/edit/delete student and mentor records.
Assign multiple students to a mentor; ensure uniqueness constraint.
View high-risk students list and verify risk logic.
Generate Excel and PDF exports; validate file content.
Mentor operations:
Update attendance and verify overall percentage and risk update.
Insert marks and confirm average mark calculation and risk update.
Add counseling session and confirm last-session date and risk update (no-counseling rule).
Student operations:
View accurate attendance, marks, counseling history.
Update profile fields safely and persistently.
Analytics:
Risk distribution chart matches underlying counts.
Attendance trend chart matches average attendance per month.
Future Scalability

Role extension: Add roles like HoD, principal, or parents with additional dashboards and read-only access to student data.
Fine-grained access control: Introduce permission tables for module-level and field-level access.
API layer: Wrap business logic with a REST API for integration with mobile apps or other campus systems.
Bulk operations: Add CSV import for student/mentor data, and bulk attendance/marks upload.
Performance optimizations: Implement caching for heavy dashboards and archived records; index tuning and query optimization for large student populations.
Multi-college tenancy: Add an institution table and partition data by campus for cloud-hosted multi-tenant deployment.