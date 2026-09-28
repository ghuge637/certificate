# Bonafide & Living Certificate Workflow Setup (12 Desks)

This document details the approval workflow rules for the two certificate types: **Bonafide Certificate** and **Living Certificate**.

---

## 1. Certificate Workflow Rules

| Certificate Type | Code | Required Desks | Approval Process |
|---|---|---|---|
| **Bonafide Certificate** | `BONAFIDE` | **1 Desk** | Approved immediately by **Desk 1** (Student Section / Bonafide Cell) |
| **Living Certificate** | `LIVING` | **12 Desks** | Must pass sequentially through **all 12 Desks** (Desk 1 $\rightarrow$ Desk 12) |

---

## 2. The 12 Approval Desks List

| Desk # | Desk Name | Assigned Staff | Purpose / Action |
|---|---|---|---|
| **Desk 1** | Student Section & Bonafide Cell | `staff1` | **Bonafide Certificate Approval** & initial screening |
| **Desk 2** | Library Clearance | `staff2` | Library dues & book returns check |
| **Desk 3** | Hostel & Warden Clearance | `staff3` | Hostel room clearance |
| **Desk 4** | Accounts & Fee Section | `staff4` | Tuition fees check |
| **Desk 5** | Sports & Gymkhana Cell | `staff5` | Sports kit returns check |
| **Desk 6** | Laboratories Clearance | `staff6` | Equipment & lab clearance |
| **Desk 7** | Department Head (HOD) | `staff7` | Departmental academic approval |
| **Desk 8** | Academic Affairs Section | `staff8` | Academic credits check |
| **Desk 9** | Examination Cell | `staff9` | Marksheet & grades verification |
| **Desk 10** | Training & Placement Cell | `staff10` | Placement NOC clearance |
| **Desk 11** | Registrar Office | `staff11` | Official institute seal |
| **Desk 12** | Principal / Dean Office | `staff12` | **Final Living Certificate Issuance** |

---

## 3. How to Execute in MySQL Workbench

Open **MySQL Workbench**, create a new Query tab, and run the complete script in [docs/script.sql](file:///e:/environment/certificate/docs/script.sql).

### Sample Verification Queries:
```sql
-- View all Certificate Types & Required Desks
SELECT * FROM certificate_types;

-- View 12 Desks Definition
SELECT * FROM approval_desks;

-- View Staff Mapped to Desks 1 to 12
SELECT staff_id, username, full_name, desk_number, desk_name FROM staff_members ORDER BY desk_number;

-- View Certificate Requests Workflow Progress
SELECT id, student_id, certificate_type, current_desk_level, total_desks_required, overall_status FROM certificate_requests;
```
