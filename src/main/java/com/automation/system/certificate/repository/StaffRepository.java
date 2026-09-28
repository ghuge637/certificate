package com.automation.system.certificate.repository;

import com.automation.system.certificate.model.Staff;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.Optional;

@Repository
public interface StaffRepository extends JpaRepository<Staff, String> {
    Optional<Staff> findByUsername(String username);
    Optional<Staff> findBySectionRole(String sectionRole);
}
