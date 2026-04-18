# 🎓 Student Mentoring Management System (SMMS)
### Institutional Grade Mentoring & Performance Analytics Portal

[![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=flat-square&logo=php)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql)](https://mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat-square&logo=bootstrap)](https://getbootstrap.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](LICENSE)

---

## 🌟 Project Overview
The **Student Mentoring Management System** is a sophisticated, web-based institutional portal designed for RMK College of Engineering and Technology (RMKCET). It streamlines the mentor–mentee relationship by digitizing counseling documentation, academic tracking, and attendance monitoring. 

Equipped with a **Proprietary Risk Engine**, the system proactively identifies students needing academic or emotional support, categorizing them into HIGH/MEDIUM/SAFE risk zones in real-time.

---

## ✨ Key Features

### 🏛️ Institutional Branding & UI/UX
- **RMKCET Theme**: Customized color palette (Deep Teal & Golden Yellow) and Poppins typography.
- **🌓 Dynamic Mode**: Seamless toggle between Executive Light and Premium Dark modes.
- **Side-by-Side Flex Layout**: Responsive dashboard design that ensures navigation and content are always accessible without stacking.

### 📊 Advanced Data Management
- **Bulk Import Utility**: Rapidly migrate large datasets from Excel/Google Sheets using CSV automation.
- **Student Classification**: Specific tracking for **Honours**, **Minor**, and **Domain-specific** student cohorts.
- **Smart Filtering**: Mentors can isolate specific groups (e.g., Honours students) for focused mark entry and updates.

### 🧠 Smart Mentoring
- **Automated Risk Engine**: Real-time risk assessment based on attendance, internal marks, and counseling recency.
- **Counseling Logs**: Detailed history of interactions with action items and follow-up tracking.
- **File Repository**: Secure storage for X/XII marksheets, Aadhar cards, and First Graduate certificates.

---

## 🛠️ Technology Stack
| Layer | Technologies |
| :--- | :--- |
| **Frontend** | HTML5, CSS3 (Vanilla), JavaScript (ES6+), Bootstrap 5.3 |
| **Backend** | PHP 8.x (MVC Architecture) |
| **Database** | MySQL 8.0 (PDO for Security) |
| **Utilities** | Chart.js (Analytics), TCPDF (PDF Generation) |

---

## 🚀 Quick Start & Installation

### Prerequisites
- XAMPP / WAMP / MAMP (PHP 7.4+ & MySQL)
- Modern Web Browser

### Setup Instructions
1.  **Clone the Repository**
    ```bash
    git clone https://github.com/Dhaarini1806/mentoring_system.git
    cd mentoring_system
    ```
2.  **Database Configuration**
    - Update `config/config.php` with your database credentials.
3.  **Run Setup & Migrations**
    - Open `http://localhost:8080/mentoring_system/setup_users.php` in your browser to initialize users.
    - (Optional) Run additional migrations:
      ```bash
      php database/migrate_students_columns.php
      php database/add_student_classification.php
      ```
4.  **Admin Login**
    - Navigate to `http://localhost:8080/mentoring_system/`
    - Use default credentials: `admin` / `Admin@123`.

---

## 👥 User Roles

### 👨‍💼 Administrator
- Full control over Student & Mentor CRUD operations.
- Bulk import of datasets and mentor assignments.
- Global view of high-risk students and institutional reports.

### 👨‍🏫 Mentor
- Access to delegated mentee list.
- Entry points for Marks, Attendance, and Counseling sessions.
- Filtered views for specialized certifications (Honours/Minors).

### 🎓 Student
- Personalized dashboard with real-time risk status.
- Self-service profile updates and file uploads.
- Complete transparency of academic history and counseling records.

---

## 📂 Project Structure
```text
├── admin/          # Admin-specific routes
├── assets/         # CSS (Themed), Images (RMKCET Logos), JS
├── config/         # Database and Security constants
├── controllers/    # MVC Controllers (Auth, Admin, Mentor, Student, Import)
├── database/       # SQL Schemas and Migration scripts
├── models/         # Database Model classes (PDO)
├── views/          # Themed UI Partials and Pages
└── uploads/        # Secure file storage for student documents
```

---

## 🛡️ Security
- **PDO Prepared Statements**: Full protection against SQL Injection.
- **CSRF Protection**: Token-based validation on all stateful forms.
- **Audit Logging**: Traceability for all critical user actions.
- **Role Guards**: Strict server-side role verification for every request.

---
© 2026 RMK College of Engineering and Technology. All Rights Reserved.