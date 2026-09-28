-- ====================================================================
-- Certificate Automation System - 12 Desks Workflow Script
-- Bonafide Certificate (Desk 1 Only) & Living Certificate (Desks 1 to 12)
-- Execute this script in MySQL Workbench
-- ====================================================================

-- Step 1: Create Database
CREATE DATABASE IF NOT EXISTS certificate_db;
USE certificate_db;

-- Step 2: Drop Old Tables (Fresh setup for 12 desks workflow)
DROP TABLE IF EXISTS certificate_requests;
DROP TABLE IF EXISTS certificate_types;
DROP TABLE IF EXISTS staff_members;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS approval_desks;

-- Step 3: Create 'students' Table
CREATE TABLE students (
    student_id VARCHAR(255) NOT NULL,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150),
    department VARCHAR(100),
    enrollment_number VARCHAR(100),
    PRIMARY KEY (student_id)
);

-- Step 4: Create 'staff_members' Table (Mapped to Desks 1 through 12)
CREATE TABLE staff_members (
    staff_id VARCHAR(255) NOT NULL,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150),
    department VARCHAR(100),
    desk_number INT NOT NULL, -- Desk 1 to 12
    desk_name VARCHAR(150) NOT NULL,
    PRIMARY KEY (staff_id)
);

-- Step 5: Create 'approval_desks' Table (12 Approval Desks)
CREATE TABLE approval_desks (
    desk_number INT NOT NULL,
    desk_name VARCHAR(150) NOT NULL,
    description VARCHAR(255),
    PRIMARY KEY (desk_number)
);

-- Step 6: Create 'certificate_types' Table
CREATE TABLE certificate_types (
    type_code VARCHAR(50) NOT NULL,
    type_name VARCHAR(150) NOT NULL,
    total_desks_required INT NOT NULL, -- 1 for Bonafide, 12 for Living
    description VARCHAR(255),
    PRIMARY KEY (type_code)
);

-- Step 7: Create 'certificate_requests' Table
CREATE TABLE certificate_requests (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(255) NOT NULL,
    certificate_type VARCHAR(50) NOT NULL, -- 'BONAFIDE' or 'LIVING'
    current_desk_level INT DEFAULT 1,     -- Current Desk (1 to 12)
    total_desks_required INT NOT NULL,   -- 1 for BONAFIDE, 12 for LIVING
    overall_status VARCHAR(50) DEFAULT 'PENDING', -- PENDING, APPROVED, REJECTED
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- ====================================================================
-- SEED DATA INSERTION
-- ====================================================================

-- 1. Insert Certificate Types Rules
INSERT INTO certificate_types (type_code, type_name, total_desks_required, description) VALUES
('BONAFIDE', 'Bonafide Certificate', 1, 'Requires Desk 1 approval only'),
('LIVING', 'Living Certificate (LC)', 12, 'Requires approval from all 12 desks sequentially');

-- 2. Insert 12 Approval Desks Definition
INSERT INTO approval_desks (desk_number, desk_name, description) VALUES
(1, 'Desk 1 - Student Section & Bonafide Cell', 'Handles Bonafide certificates and initial student application screening'),
(2, 'Desk 2 - Library Clearance', 'Verifies no outstanding library books or fines'),
(3, 'Desk 3 - Hostel & Warden Clearance', 'Verifies hostel room dues and clearance'),
(4, 'Desk 4 - Accounts & Fee Section', 'Verifies tuition fees and pending dues'),
(5, 'Desk 5 - Sports & Gymkhana Cell', 'Verifies sports equipment return and dues'),
(6, 'Desk 6 - Laboratories Clearance', 'Verifies lab equipment & practical clearance'),
(7, 'Desk 7 - Department Head (HOD)', 'Departmental academic approval'),
(8, 'Desk 8 - Academic Affairs Section', 'Academic credits and eligibility check'),
(9, 'Desk 9 - Examination Cell', 'Marksheet and grade verification'),
(10, 'Desk 10 - Training & Placement Cell', 'Placement record and NOC check'),
(11, 'Desk 11 - Registrar Office', 'Official institute seal & verification'),
(12, 'Desk 12 - Principal / Dean Office', 'Final Living Certificate generation & issuance');

-- 3. Insert Staff Members Assigned to Desks 1 through 12
INSERT INTO staff_members (staff_id, username, password, full_name, email, department, desk_number, desk_name) VALUES
('STF-101', 'staff1', 'password123', 'Mr. John Carter', 'j.carter@university.edu', 'Student Section', 1, 'Desk 1 - Student Section & Bonafide Cell'),
('STF-102', 'staff2', 'password123', 'Mr. David Miller', 'd.miller@university.edu', 'Library Department', 2, 'Desk 2 - Library Clearance'),
('STF-103', 'staff3', 'password123', 'Mr. James Wilson', 'j.wilson@university.edu', 'Hostel Administration', 3, 'Desk 3 - Hostel Clearance'),
('STF-104', 'staff4', 'password123', 'Mrs. Sarah Connor', 's.connor@university.edu', 'Finance & Accounts', 4, 'Desk 4 - Accounts & Fee Section'),
('STF-105', 'staff5', 'password123', 'Coach Mike Tyson', 'm.tyson@university.edu', 'Sports Cell', 5, 'Desk 5 - Sports Clearance'),
('STF-106', 'staff6', 'password123', 'Dr. Alan Turing', 'a.turing@university.edu', 'Central Labs', 6, 'Desk 6 - Laboratories Clearance'),
('STF-107', 'staff7', 'password123', 'Dr. Robert Smith', 'r.smith@university.edu', 'Computer Science Dept', 7, 'Desk 7 - Department Head (HOD)'),
('STF-108', 'staff8', 'password123', 'Mrs. Laura Croft', 'l.croft@university.edu', 'Academic Section', 8, 'Desk 8 - Academic Affairs'),
('STF-109', 'staff9', 'password123', 'Prof. Emily Davis', 'e.davis@university.edu', 'Examination Controller', 9, 'Desk 9 - Examination Cell'),
('STF-110', 'staff10', 'password123', 'Mr. Bruce Wayne', 'b.wayne@university.edu', 'Placement Cell', 10, 'Desk 10 - Placement Cell'),
('STF-111', 'staff11', 'password123', 'Dr. Charles Xavier', 'c.xavier@university.edu', 'Registrar Office', 11, 'Desk 11 - Registrar Office'),
('STF-112', 'staff12', 'password123', 'Principal Arthur Pendelton', 'a.pendelton@university.edu', 'Principal Office', 12, 'Desk 12 - Principal Office / Living Cert');

-- 4. Insert Student Records
INSERT INTO students (student_id, username, password, full_name, email, department, enrollment_number) VALUES
('STU-1001', 'student1', 'password123', 'Alex Johnson', 'alex.j@university.edu', 'Computer Science', 'EN2024CS001'),
('STU-1002', 'student2', 'password123', 'Sophia Chen', 'sophia.c@university.edu', 'Information Technology', 'EN2024IT042');

-- 5. Insert Sample Requests (Bonafide vs Living Certificate)
INSERT INTO certificate_requests (student_id, certificate_type, current_desk_level, total_desks_required, overall_status) VALUES
-- Bonafide Certificate Request (Requires 1 Desk only)
('STU-1001', 'BONAFIDE', 1, 1, 'APPROVED'), 

-- Living Certificate Request (Requires 12 Desks - Currently at Desk 3)
('STU-1002', 'LIVING', 3, 12, 'PENDING');

-- ====================================================================
-- VERIFICATION QUERIES
-- ====================================================================

SELECT '--- CERTIFICATE TYPES & DESK RULES ---' AS Info;
SELECT * FROM certificate_types;

SELECT '--- 12 DESKS DEFINITION ---' AS Info;
SELECT * FROM approval_desks;

SELECT '--- STAFF MEMBERS MAPPED TO DESKS 1-12 ---' AS Info;
SELECT staff_id, username, full_name, desk_number, desk_name FROM staff_members ORDER BY desk_number;

SELECT '--- CERTIFICATE REQUESTS WORKFLOW ---' AS Info;
SELECT id, student_id, certificate_type, current_desk_level, total_desks_required, overall_status FROM certificate_requests;
