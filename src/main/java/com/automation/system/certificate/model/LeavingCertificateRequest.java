package com.automation.system.certificate.model;

import jakarta.persistence.*;
import java.time.LocalDateTime;

@Entity
@Table(name = "lc_requests")
public class LeavingCertificateRequest {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(nullable = false)
    private Long prnno;

    @Column(nullable = false)
    private String reason;

    @Column(name = "current_section", nullable = false)
    private Integer currentSection; // 1 to 12

    @Column(nullable = false)
    private String status; // Pending, In_Progress, Approved, Rejected, Completed

    @Column(name = "rejection_remark")
    private String rejectionRemark;

    @Column(name = "created_at", insertable = false, updatable = false)
    private LocalDateTime createdAt;

    @Column(name = "completed_at")
    private LocalDateTime completedAt;

    public LeavingCertificateRequest() {
    }

    public LeavingCertificateRequest(Long prnno, String reason, Integer currentSection, String status) {
        this.prnno = prnno;
        this.reason = reason;
        this.currentSection = currentSection;
        this.status = status;
    }

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public Long getPrnno() {
        return prnno;
    }

    public void setPrnno(Long prnno) {
        this.prnno = prnno;
    }

    public String getReason() {
        return reason;
    }

    public void setReason(String reason) {
        this.reason = reason;
    }

    public Integer getCurrentSection() {
        return currentSection;
    }

    public void setCurrentSection(Integer currentSection) {
        this.currentSection = currentSection;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public String getRejectionRemark() {
        return rejectionRemark;
    }

    public void setRejectionRemark(String rejectionRemark) {
        this.rejectionRemark = rejectionRemark;
    }

    public LocalDateTime getCreatedAt() {
        return createdAt;
    }

    public void setCreatedAt(LocalDateTime createdAt) {
        this.createdAt = createdAt;
    }

    public LocalDateTime getCompletedAt() {
        return completedAt;
    }

    public void setCompletedAt(LocalDateTime completedAt) {
        this.completedAt = completedAt;
    }
}
