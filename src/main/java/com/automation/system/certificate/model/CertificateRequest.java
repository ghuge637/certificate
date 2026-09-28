package com.automation.system.certificate.model;

import jakarta.persistence.*;
import java.time.LocalDateTime;

@Entity
@Table(name = "certificate_requests")
public class CertificateRequest {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(nullable = false)
    private String studentId;

    @Column(nullable = false)
    private String certificateType; // "BONAFIDE" or "LIVING"

    @Column(nullable = false)
    private Integer currentDeskLevel; // 1 to 12

    @Column(nullable = false)
    private Integer totalDesksRequired; // 1 for BONAFIDE, 12 for LIVING

    @Column(nullable = false)
    private String overallStatus; // PENDING, APPROVED, REJECTED

    private LocalDateTime createdAt;
    private LocalDateTime completedAt;

    public CertificateRequest() {
    }

    public CertificateRequest(String studentId, String certificateType, Integer currentDeskLevel, Integer totalDesksRequired, String overallStatus, LocalDateTime createdAt) {
        this.studentId = studentId;
        this.certificateType = certificateType;
        this.currentDeskLevel = currentDeskLevel;
        this.totalDesksRequired = totalDesksRequired;
        this.overallStatus = overallStatus;
        this.createdAt = createdAt;
    }

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public String getStudentId() {
        return studentId;
    }

    public void setStudentId(String studentId) {
        this.studentId = studentId;
    }

    public String getCertificateType() {
        return certificateType;
    }

    public void setCertificateType(String certificateType) {
        this.certificateType = certificateType;
    }

    public Integer getCurrentDeskLevel() {
        return currentDeskLevel;
    }

    public void setCurrentDeskLevel(Integer currentDeskLevel) {
        this.currentDeskLevel = currentDeskLevel;
    }

    public Integer getTotalDesksRequired() {
        return totalDesksRequired;
    }

    public void setTotalDesksRequired(Integer totalDesksRequired) {
        this.totalDesksRequired = totalDesksRequired;
    }

    public String getOverallStatus() {
        return overallStatus;
    }

    public void setOverallStatus(String overallStatus) {
        this.overallStatus = overallStatus;
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
