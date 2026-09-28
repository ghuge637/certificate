package com.automation.system.certificate.model;

import jakarta.persistence.*;

@Entity
@Table(name = "staff_members")
public class Staff {

    @Id
    @Column(name = "staff_id", nullable = false)
    private String staffId;

    @Column(nullable = false, unique = true)
    private String username;

    @Column(nullable = false)
    private String password;

    @Column(name = "full_name", nullable = false)
    private String fullName;

    @Column(nullable = false, unique = true)
    private String email;

    private String department;

    @Column(name = "section_role", nullable = false)
    private String sectionRole;

    @Column(name = "section_name", nullable = false)
    private String sectionName;

    public Staff() {
    }

    public Staff(String staffId, String username, String password, String fullName, String email, String department, String sectionRole, String sectionName) {
        this.staffId = staffId;
        this.username = username;
        this.password = password;
        this.fullName = fullName;
        this.email = email;
        this.department = department;
        this.sectionRole = sectionRole;
        this.sectionName = sectionName;
    }

    public String getStaffId() {
        return staffId;
    }

    public void setStaffId(String staffId) {
        this.staffId = staffId;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getFullName() {
        return fullName;
    }

    public void setFullName(String fullName) {
        this.fullName = fullName;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getDepartment() {
        return department;
    }

    public void setDepartment(String department) {
        this.department = department;
    }

    public String getSectionRole() {
        return sectionRole;
    }

    public void setSectionRole(String sectionRole) {
        this.sectionRole = sectionRole;
    }

    public String getSectionName() {
        return sectionName;
    }

    public void setSectionName(String sectionName) {
        this.sectionName = sectionName;
    }
}
