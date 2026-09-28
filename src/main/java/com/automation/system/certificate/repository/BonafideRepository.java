package com.automation.system.certificate.repository;

import com.automation.system.certificate.model.BonafideRequest;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface BonafideRepository extends JpaRepository<BonafideRequest, Long> {
    List<BonafideRequest> findByPrnnoOrderByCreatedAtDesc(Long prnno);
    List<BonafideRequest> findByStatusOrderByCreatedAtDesc(String status);
}
