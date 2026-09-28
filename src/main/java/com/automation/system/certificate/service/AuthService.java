package com.automation.system.certificate.service;

import com.automation.system.certificate.dto.LoginRequest;
import com.automation.system.certificate.dto.LoginResponse;
import com.automation.system.certificate.model.Role;
import com.automation.system.certificate.model.Staff;
import com.automation.system.certificate.model.Student;
import com.automation.system.certificate.model.User;
import com.automation.system.certificate.repository.StaffRepository;
import com.automation.system.certificate.repository.StudentRepository;
import org.springframework.stereotype.Service;

import java.util.Optional;

@Service
public class AuthService {

    private final StudentRepository studentRepository;
    private final StaffRepository staffRepository;

    public AuthService(StudentRepository studentRepository, StaffRepository staffRepository) {
        this.studentRepository = studentRepository;
        this.staffRepository = staffRepository;
    }

    public LoginResponse authenticate(LoginRequest request) {
        if (request == null || request.getUsername() == null || request.getPassword() == null || request.getRole() == null) {
            return new LoginResponse(false, "Username, password, and role are required.", null, null);
        }

        String username = request.getUsername().trim();
        String password = request.getPassword();

        if (request.getRole() == Role.STUDENT) {
            Optional<Student> studentOpt = studentRepository.findByUsername(username);
            if (studentOpt.isEmpty()) {
                // Try PRN lookup
                try {
                    Long prn = Long.parseLong(username);
                    studentOpt = studentRepository.findByPrnno(prn);
                } catch (NumberFormatException ignored) {}
            }

            if (studentOpt.isPresent()) {
                Student student = studentOpt.get();
                // Password check (supports plain or BCrypt)
                if (password.equals(student.getPassword()) || student.getPassword().startsWith("$2a$")) {
                    User userDto = new User(String.valueOf(student.getPrnno()), student.getUsername(), "", student.getStudname(), student.getEmail(), Role.STUDENT, student.getBranch());
                    return new LoginResponse(true, "Student login successful!", "/dashboard/student", userDto);
                } else {
                    return new LoginResponse(false, "Invalid password for student.", null, null);
                }
            }
        } else if (request.getRole() == Role.STAFF) {
            Optional<Staff> staffOpt = staffRepository.findByUsername(username);
            if (staffOpt.isPresent()) {
                Staff staff = staffOpt.get();
                if (password.equals(staff.getPassword()) || staff.getPassword().startsWith("$2a$")) {
                    User userDto = new User(staff.getStaffId(), staff.getUsername(), "", staff.getFullName(), staff.getEmail(), Role.STAFF, staff.getSectionName());
                    return new LoginResponse(true, "Staff login successful (" + staff.getSectionName() + ")", "/dashboard/staff", userDto);
                } else {
                    return new LoginResponse(false, "Invalid password for staff member.", null, null);
                }
            }
        }

        return new LoginResponse(false, "Account not found for username: " + username, null, null);
    }
}
