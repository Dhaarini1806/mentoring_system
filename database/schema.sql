-- Mentoring System Database Schema
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Table structure for table `attendance` --
CREATE TABLE `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `total_classes` int(11) NOT NULL DEFAULT 0,
  `attended_classes` int(11) NOT NULL DEFAULT 0,
  `month_year` char(7) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_student_month` (`student_id`,`month_year`),
  KEY `idx_month` (`month_year`),
  CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table structure for table `audit_logs` --
CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_user` (`user_id`),
  KEY `idx_action` (`action`),
  CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table structure for table `counseling_sessions` --
CREATE TABLE `counseling_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mentor_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `session_date` date NOT NULL,
  `mode` enum('IN_PERSON','ONLINE') DEFAULT 'IN_PERSON',
  `summary` text NOT NULL,
  `action_items` text DEFAULT NULL,
  `next_followup_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_session_student` (`student_id`),
  KEY `idx_session_mentor` (`mentor_id`),
  KEY `idx_session_date` (`session_date`),
  CONSTRAINT `counseling_sessions_ibfk_1` FOREIGN KEY (`mentor_id`) REFERENCES `mentors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `counseling_sessions_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table structure for table `marks` --
CREATE TABLE `marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `subject_code` varchar(20) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `internal_mark` decimal(5,2) NOT NULL,
  `max_mark` decimal(5,2) NOT NULL DEFAULT 100.00,
  `exam_type` enum('CIA1','CIA2','CIA3','MODEL','ASSIGNMENT') DEFAULT 'CIA1',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_student_subject` (`student_id`,`subject_code`),
  KEY `idx_exam_type` (`exam_type`),
  CONSTRAINT `marks_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table structure for table `mentor_assignment` --
CREATE TABLE `mentor_assignment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mentor_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_mentor_student` (`mentor_id`,`student_id`),
  KEY `idx_student` (`student_id`),
  KEY `idx_mentor` (`mentor_id`),
  CONSTRAINT `mentor_assignment_ibfk_1` FOREIGN KEY (`mentor_id`) REFERENCES `mentors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mentor_assignment_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table structure for table `mentors` --
CREATE TABLE `mentors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `staff_id` varchar(20) NOT NULL,
  `name` varchar(150) NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `staff_id` (`staff_id`),
  KEY `user_id` (`user_id`),
  KEY `idx_staff` (`staff_id`),
  CONSTRAINT `mentors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table structure for table `students` --
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `roll_no` varchar(20) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender` enum('M','F','O') DEFAULT 'O',
  `department` varchar(100) DEFAULT NULL,
  `program` varchar(100) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `risk_level` enum('SAFE','MEDIUM','HIGH') DEFAULT 'SAFE',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `mother_tongue` varchar(50) DEFAULT NULL,
  `linguistic_minority` varchar(10) DEFAULT 'No',
  `goals` text DEFAULT NULL,
  `how_heard_about_college` varchar(100) DEFAULT NULL,
  `residency_type` varchar(50) DEFAULT NULL,
  `mode_of_transport` varchar(50) DEFAULT NULL,
  `boarding_place` varchar(100) DEFAULT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `father_name` varchar(100) DEFAULT NULL,
  `father_mobile` varchar(20) DEFAULT NULL,
  `father_email` varchar(100) DEFAULT NULL,
  `father_qualification` varchar(100) DEFAULT NULL,
  `father_occupation` varchar(100) DEFAULT NULL,
  `father_office_address` text DEFAULT NULL,
  `father_annual_income` varchar(50) DEFAULT NULL,
  `mother_name` varchar(100) DEFAULT NULL,
  `mother_mobile` varchar(20) DEFAULT NULL,
  `mother_email` varchar(100) DEFAULT NULL,
  `mother_qualification` varchar(100) DEFAULT NULL,
  `mother_occupation` varchar(100) DEFAULT NULL,
  `mother_office_address` text DEFAULT NULL,
  `mother_annual_income` varchar(50) DEFAULT NULL,
  `x_school_name` varchar(200) DEFAULT NULL,
  `x_register_no` varchar(50) DEFAULT NULL,
  `x_board` varchar(100) DEFAULT NULL,
  `x_medium` varchar(50) DEFAULT NULL,
  `x_passing_month_year` varchar(50) DEFAULT NULL,
  `x_marks_json` text DEFAULT NULL,
  `x_total_marks` varchar(20) DEFAULT NULL,
  `x_percentage_cgpa` varchar(20) DEFAULT NULL,
  `x_marksheet_path` varchar(255) DEFAULT NULL,
  `xii_school_name` varchar(200) DEFAULT NULL,
  `xii_register_no` varchar(50) DEFAULT NULL,
  `xii_board` varchar(100) DEFAULT NULL,
  `xii_medium` varchar(50) DEFAULT NULL,
  `xii_passing_month_year` varchar(50) DEFAULT NULL,
  `xii_marks_json` text DEFAULT NULL,
  `xii_total_marks` varchar(20) DEFAULT NULL,
  `xii_percentage_cgpa` varchar(20) DEFAULT NULL,
  `xii_marksheet_path` varchar(255) DEFAULT NULL,
  `aadhar_number` varchar(20) DEFAULT NULL,
  `aadhar_path` varchar(255) DEFAULT NULL,
  `is_first_graduate` varchar(10) DEFAULT 'No',
  `fg_certificate_path` varchar(255) DEFAULT NULL,
  `reference` text DEFAULT NULL,
  `domain` varchar(100) DEFAULT NULL,
  `is_honours` tinyint(1) DEFAULT 0,
  `is_minor` tinyint(1) DEFAULT 0,
  `register_number` varchar(50) DEFAULT NULL,
  `academic_year` varchar(20) DEFAULT NULL,
  `course` varchar(30) DEFAULT NULL,
  `branch` varchar(30) DEFAULT NULL,
  `lateral_entry` varchar(10) DEFAULT 'No',
  `quota` varchar(30) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile_no` varchar(20) DEFAULT NULL,
  `address_communication` text DEFAULT NULL,
  `address_permanent` text DEFAULT NULL,
  `community` varchar(100) DEFAULT NULL,
  `caste` varchar(100) DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roll_no` (`roll_no`),
  KEY `user_id` (`user_id`),
  KEY `idx_roll_no` (`roll_no`),
  KEY `idx_risk` (`risk_level`),
  CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table structure for table `users` --
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','mentor','student') NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `idx_role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;
