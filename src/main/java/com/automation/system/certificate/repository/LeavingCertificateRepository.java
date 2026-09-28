package com.automation.system.certificate.repository;

import com.automation.system.certificate.model.LeavingCertificateRequest;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface LeavingCertificateRepository extends JpaRepository<LeavingCertificateRequest, Long> {
    List<LeavingCertificateRequest> findByPrnnoOrderByCreatedAtDesc(Long prnno);
    List<LeavingCertificateRequest> findByStatusOrderByCreatedAtDesc(String status);
}
