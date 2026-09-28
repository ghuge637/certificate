package com.automation.system.certificate.model;

import jakarta.persistence.*;
import java.time.LocalDateTime;

@Entity
@Table(name = "lc_section_clearances")
public class LcSectionClearance {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(name = "lc_request_id", nullable = false)
    private Long lcRequestId;

    @Column(name = "section_code", nullable = false)
    private String sectionCode;

    @Column(name = "section_name", nullable = false)
    private String sectionName;

    @Column(name = "staff_id")
    private String staffId;

    @Column(nullable = false)
    private String status; // Pending, Approved, Rejected

    private String remark;

    @Column(name = "cleared_at")
    private LocalDateTime clearedAt;

    public LcSectionClearance() {
    }

    public LcSectionClearance(Long lcRequestId, String sectionCode, String sectionName, String staffId, String status, String remark, LocalDateTime clearedAt) {
        this.lcRequestId = lcRequestId;
        this.sectionCode = sectionCode;
        this.sectionName = sectionName;
        this.staffId = staffId;
        this.status = status;
        this.remark = remark;
        this.clearedAt = clearedAt;
    }

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public Long getLcRequestId() {
        return lcRequestId;
    }

    public void setLcRequestId(Long lcRequestId) {
        this.lcRequestId = lcRequestId;
    }

    public String getSectionCode() {
        return sectionCode;
    }

    public void setSectionCode(String sectionCode) {
        this.sectionCode = sectionCode;
    }

    public String getSectionName() {
        return sectionName;
    }

    public void setSectionName(String sectionName) {
        this.sectionName = sectionName;
    }

    public String getStaffId() {
        return staffId;
    }

    public void setStaffId(String staffId) {
        this.staffId = staffId;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public String getRemark() {
        return remark;
    }

    public void setRemark(String remark) {
        this.remark = remark;
    }

    public LocalDateTime getClearedAt() {
        return clearedAt;
    }

    public void setClearedAt(LocalDateTime clearedAt) {
        this.clearedAt = clearedAt;
    }
}
