package com.automation.system.certificate.repository;

import com.automation.system.certificate.model.LcSectionClearance;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface LcSectionClearanceRepository extends JpaRepository<LcSectionClearance, Long> {
    List<LcSectionClearance> findByLcRequestId(Long lcRequestId);
    List<LcSectionClearance> findBySectionCodeAndStatus(String sectionCode, String status);
    List<LcSectionClearance> findByStatus(String status);
}
