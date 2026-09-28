-- ====================================================================
-- Enterprise Database Schema for Certificate Automation System
-- Compatible with MySQL 8.0+ and Spring Data JPA / Hibernate
-- Open and Execute this script in MySQL Workbench
-- ====================================================================

-- Step 1: Create Database
CREATE DATABASE IF NOT EXISTS certificate_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE certificate_db;

-- Step 2: Drop Old Tables cleanly
DROP TABLE IF EXISTS lc_section_clearances;
DROP TABLE IF EXISTS lc_requests;
DROP TABLE IF EXISTS bonafide_requests;
DROP TABLE IF EXISTS student_academic_records;
DROP TABLE IF EXISTS previous_academic_details;
DROP TABLE IF EXISTS staff_members;
DROP TABLE IF EXISTS students;

-- ====================================================================
-- 1. MASTER TABLES
-- ====================================================================

-- 1.1 Students Master Table
CREATE TABLE students (
    prnno BIGINT NOT NULL,                  -- PRN Number (Primary Key)
    username VARCHAR(100) NOT NULL UNIQUE,  -- Login username
    password VARCHAR(255) NOT NULL,         -- BCrypt hashed password
    studname VARCHAR(150) NOT NULL,        -- Student Full Name
    studdob DATE NOT NULL,                 -- Date of Birth
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    branch VARCHAR(100) NOT NULL,           -- Computer Science, IT, AI&DS, E&TC, Mechanical
    division CHAR(1) NOT NULL,             -- A, B, C
    year INT NOT NULL,                     -- Year of study (1, 2, 3, 4)
    rollno INT NOT NULL,                   -- Roll Number
    batch VARCHAR(50),                     -- Morning / Afternoon
    batch_year INT,                        -- Batch Year
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_no CHAR(10) NOT NULL UNIQUE,
    parentsphone CHAR(10),
    address TEXT,
    pincode CHAR(6),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (prnno)
);

-- 1.2 Staff Members Master Table
CREATE TABLE staff_members (
    staff_id VARCHAR(100) NOT NULL,          -- e.g. STF-101
    username VARCHAR(100) NOT NULL UNIQUE,  -- Login Username
    password VARCHAR(255) NOT NULL,         -- BCrypt hashed password
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    department VARCHAR(100),                -- Department / Section
    section_role VARCHAR(50) NOT NULL,      -- STUDENT_SECTION, LIBRARY, ACCOUNT, SCHOLARSHIP, PLACEMENT, WORKSHOP, HOD_COMP, HOD_AIDS, HOD_ENTC, HOD_MECH, PRINCIPAL
    section_name VARCHAR(150) NOT NULL,
    PRIMARY KEY (staff_id)
);

-- 1.3 Previous Academic Details (For Leaving Certificate generation)
CREATE TABLE previous_academic_details (
    prnno BIGINT NOT NULL,
    mother_name VARCHAR(100) NOT NULL,
    religion VARCHAR(50),
    caste VARCHAR(50),
    place_of_birth VARCHAR(100),
    nationality VARCHAR(50) DEFAULT 'Indian',
    dob_in_words VARCHAR(150),
    previous_institute VARCHAR(255),
    date_of_admission DATE,
    standard VARCHAR(50),
    PRIMARY KEY (prnno),
    FOREIGN KEY (prnno) REFERENCES students(prnno) ON DELETE CASCADE
);

-- 1.4 Student Academic Records (Fees, Scholarship, SGPA, CGPA)
CREATE TABLE student_academic_records (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    prnno BIGINT NOT NULL,
    academic_year VARCHAR(20) NOT NULL,     -- FE, SE, TE, BE
    total_fees INT DEFAULT 0,
    paid_fees INT DEFAULT 0,
    scholarship_form_status TINYINT(1) DEFAULT 0,
    first_installment INT DEFAULT 0,
    second_installment INT DEFAULT 0,
    exam_form_status TINYINT(1) DEFAULT 0,
    academic_status VARCHAR(50) DEFAULT 'Completed',
    sgpa DECIMAL(4,2),
    cgpa DECIMAL(4,2),
    FOREIGN KEY (prnno) REFERENCES students(prnno) ON DELETE CASCADE
);

-- ====================================================================
-- 2. WORKFLOW & REQUEST TABLES
-- ====================================================================

-- 2.1 Bonafide Certificate Requests
CREATE TABLE bonafide_requests (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    prnno BIGINT NOT NULL,
    reason TEXT NOT NULL,
    status ENUM('Pending', 'Approved', 'Rejected', 'Completed') DEFAULT 'Pending',
    rejection_reason VARCHAR(255) DEFAULT 'NO',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    approved_at TIMESTAMP NULL,
    FOREIGN KEY (prnno) REFERENCES students(prnno) ON DELETE CASCADE
);

-- 2.2 Leaving Certificate (LC) Requests
CREATE TABLE lc_requests (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    prnno BIGINT NOT NULL,
    reason VARCHAR(255) NOT NULL,
    current_section INT DEFAULT 1,          -- 1 to 12
    status ENUM('Pending', 'In_Progress', 'Approved', 'Rejected', 'Completed') DEFAULT 'Pending',
    rejection_remark TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    FOREIGN KEY (prnno) REFERENCES students(prnno) ON DELETE CASCADE
);

-- 2.3 Leaving Certificate Multi-Desk Audit Log
CREATE TABLE lc_section_clearances (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    lc_request_id BIGINT NOT NULL,
    section_code VARCHAR(50) NOT NULL,      -- STUDENT_SECTION, LIBRARY, ACCOUNTS, SCHOLARSHIP, PLACEMENT, WORKSHOP, HOD, PRINCIPAL
    section_name VARCHAR(150) NOT NULL,
    staff_id VARCHAR(100),
    status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    remark TEXT,
    cleared_at TIMESTAMP NULL,
    FOREIGN KEY (lc_request_id) REFERENCES lc_requests(id) ON DELETE CASCADE,
    FOREIGN KEY (staff_id) REFERENCES staff_members(staff_id) ON DELETE SET NULL
);

-- ====================================================================
-- 3. SEED DEMO DATA
-- ====================================================================

-- Seed Students
INSERT INTO students (prnno, username, password, studname, studdob, gender, branch, division, year, rollno, batch, batch_year, email, phone_no, parentsphone, address, pincode) VALUES
(202213149, 'student1', '$2a$10$e8wF4M9M1Q/b4E5U78N1d.VfJ7K2Q4rN2s9L1M3P5Q7R9S1T3U5V6', 'Vishal Shriram Ghuge', '2004-04-15', 'Male', 'Computer Science', 'A', 3, 149, 'Morning', 2025, 'vishal@gmail.com', '7620290331', '9876543210', 'Jintur, Parbhani', '431510'),
(202213144, 'student2', '$2a$10$e8wF4M9M1Q/b4E5U78N1d.VfJ7K2Q4rN2s9L1M3P5Q7R9S1T3U5V6', 'Priyanka Gaikwad', '2004-06-02', 'Female', 'Computer Science', 'A', 3, 144, 'Morning', 2025, 'p@gmail.com', '9876543810', '9123456789', 'Pune', '411001');

-- Seed Previous Academic Details
INSERT INTO previous_academic_details (prnno, mother_name, religion, caste, place_of_birth, nationality, dob_in_words, previous_institute, date_of_admission, standard) VALUES
(202213149, 'Sangita', 'Hindu', 'Vanjari (NTD)', 'Sawali (Bk)', 'Indian', 'Fifteenth April Two Thousand Four', 'Shri Shivaji College, Parbhani', '2022-11-12', 'TE Computer');

-- Seed Academic Records
INSERT INTO student_academic_records (prnno, academic_year, total_fees, paid_fees, scholarship_form_status, first_installment, second_installment, exam_form_status, academic_status, sgpa, cgpa) VALUES
(202213149, 'TE', 81000, 80000, 1, 1, 1, 1, 'Completed', 8.50, 8.20);

-- Seed Staff Members (For all Sections & HODs)
INSERT INTO staff_members (staff_id, username, password, full_name, email, department, section_role, section_name) VALUES
('STF-101', 'staff_stud', '$2a$10$e8wF4M9M1Q/b4E5U78N1d.VfJ7K2Q4rN2s9L1M3P5Q7R9S1T3U5V6', 'Mr. John Carter', 'student.sec@university.edu', 'Student Section', 'STUDENT_SECTION', 'Student Section & Bonafide Cell'),
('STF-102', 'staff_lib', '$2a$10$e8wF4M9M1Q/b4E5U78N1d.VfJ7K2Q4rN2s9L1M3P5Q7R9S1T3U5V6', 'Mr. David Miller', 'library@university.edu', 'Library Department', 'LIBRARY', 'Library Clearance Section'),
('STF-103', 'staff_acc', '$2a$10$e8wF4M9M1Q/b4E5U78N1d.VfJ7K2Q4rN2s9L1M3P5Q7R9S1T3U5V6', 'Mrs. Sarah Connor', 'accounts@university.edu', 'Finance & Accounts', 'ACCOUNT', 'Accounts & Fees Clearance'),
('STF-104', 'staff_scholar', '$2a$10$e8wF4M9M1Q/b4E5U78N1d.VfJ7K2Q4rN2s9L1M3P5Q7R9S1T3U5V6', 'Mr. Robert Vance', 'scholarship@university.edu', 'Scholarship Cell', 'SCHOLARSHIP', 'Scholarship Clearance Section'),
('STF-105', 'staff_placement', '$2a$10$e8wF4M9M1Q/b4E5U78N1d.VfJ7K2Q4rN2s9L1M3P5Q7R9S1T3U5V6', 'Mr. Bruce Wayne', 'placement@university.edu', 'Placement Cell', 'PLACEMENT', 'Training & Placement Cell'),
('STF-106', 'staff_workshop', '$2a$10$e8wF4M9M1Q/b4E5U78N1d.VfJ7K2Q4rN2s9L1M3P5Q7R9S1T3U5V6', 'Mr. Tony Stark', 'workshop@university.edu', 'Central Workshop', 'WORKSHOP', 'Workshop Clearance Section'),
('STF-107', 'hod_comp', '$2a$10$e8wF4M9M1Q/b4E5U78N1d.VfJ7K2Q4rN2s9L1M3P5Q7R9S1T3U5V6', 'Dr. Robert Smith', 'hod.comp@university.edu', 'Computer Science Dept', 'HOD_COMP', 'Computer Engineering HOD'),
('STF-108', 'principal', '$2a$10$e8wF4M9M1Q/b4E5U78N1d.VfJ7K2Q4rN2s9L1M3P5Q7R9S1T3U5V6', 'Dr. Arthur Pendelton', 'principal@university.edu', 'Principal Office', 'PRINCIPAL', 'Principal Office Final Seal');

-- Seed Sample Bonafide Request
INSERT INTO bonafide_requests (prnno, reason, status) VALUES
(202213149, 'Bus Pass and Scholarship Application', 'Pending');

-- ====================================================================
-- VERIFICATION QUERIES
-- ====================================================================
SELECT * FROM students;
SELECT * FROM staff_members;
SELECT * FROM previous_academic_details;
SELECT * FROM bonafide_requests;
