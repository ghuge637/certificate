package com.automation.system.certificate.model;

import jakarta.persistence.*;
import java.time.LocalDate;
import java.time.LocalDateTime;

@Entity
@Table(name = "students")
public class Student {

    @Id
    @Column(name = "prnno", nullable = false)
    private Long prnno;

    @Column(nullable = false, unique = true)
    private String username;

    @Column(nullable = false)
    private String password;

    @Column(name = "studname", nullable = false)
    private String studname;

    @Column(name = "studdob", nullable = false)
    private LocalDate studdob;

    @Column(nullable = false)
    private String gender;

    @Column(nullable = false)
    private String branch;

    @Column(nullable = false)
    private String division;

    @Column(nullable = false)
    private Integer year;

    @Column(nullable = false)
    private Integer rollno;

    private String batch;

    @Column(name = "batch_year")
    private Integer batchYear;

    @Column(nullable = false, unique = true)
    private String email;

    @Column(name = "phone_no", nullable = false, unique = true)
    private String phoneNo;

    private String parentsphone;
    private String address;
    private String pincode;

    @Column(name = "created_at", insertable = false, updatable = false)
    private LocalDateTime createdAt;

    public Student() {
    }

    public Student(Long prnno, String username, String password, String studname, LocalDate studdob, String gender, String branch, String division, Integer year, Integer rollno, String batch, Integer batchYear, String email, String phoneNo, String parentsphone, String address, String pincode) {
        this.prnno = prnno;
        this.username = username;
        this.password = password;
        this.studname = studname;
        this.studdob = studdob;
        this.gender = gender;
        this.branch = branch;
        this.division = division;
        this.year = year;
        this.rollno = rollno;
        this.batch = batch;
        this.batchYear = batchYear;
        this.email = email;
        this.phoneNo = phoneNo;
        this.parentsphone = parentsphone;
        this.address = address;
        this.pincode = pincode;
    }

    public Long getPrnno() {
        return prnno;
    }

    public void setPrnno(Long prnno) {
        this.prnno = prnno;
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

    public String getStudname() {
        return studname;
    }

    public void setStudname(String studname) {
        this.studname = studname;
    }

    public LocalDate getStuddob() {
        return studdob;
    }

    public void setStuddob(LocalDate studdob) {
        this.studdob = studdob;
    }

    public String getGender() {
        return gender;
    }

    public void setGender(String gender) {
        this.gender = gender;
    }

    public String getBranch() {
        return branch;
    }

    public void setBranch(String branch) {
        this.branch = branch;
    }

    public String getDivision() {
        return division;
    }

    public void setDivision(String division) {
        this.division = division;
    }

    public Integer getYear() {
        return year;
    }

    public void setYear(Integer year) {
        this.year = year;
    }

    public Integer getRollno() {
        return rollno;
    }

    public void setRollno(Integer rollno) {
        this.rollno = rollno;
    }

    public String getBatch() {
        return batch;
    }

    public void setBatch(String batch) {
        this.batch = batch;
    }

    public Integer getBatchYear() {
        return batchYear;
    }

    public void setBatchYear(Integer batchYear) {
        this.batchYear = batchYear;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getPhoneNo() {
        return phoneNo;
    }

    public void setPhoneNo(String phoneNo) {
        this.phoneNo = phoneNo;
    }

    public String getParentsphone() {
        return parentsphone;
    }

    public void setParentsphone(String parentsphone) {
        this.parentsphone = parentsphone;
    }

    public String getAddress() {
        return address;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public String getPincode() {
        return pincode;
    }

    public void setPincode(String pincode) {
        this.pincode = pincode;
    }

    public LocalDateTime getCreatedAt() {
        return createdAt;
    }

    public void setCreatedAt(LocalDateTime createdAt) {
        this.createdAt = createdAt;
    }
}
