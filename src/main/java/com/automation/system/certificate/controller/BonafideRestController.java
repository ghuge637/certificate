package com.automation.system.certificate.controller;

import com.automation.system.certificate.model.BonafideRequest;
import com.automation.system.certificate.model.Student;
import com.automation.system.certificate.repository.BonafideRepository;
import com.automation.system.certificate.repository.StudentRepository;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.List;
import java.util.Map;
import java.util.Optional;

@RestController
@RequestMapping("/api/v1/bonafide")
@CrossOrigin(origins = "*")
public class BonafideRestController {

    private final BonafideRepository bonafideRepository;
    private final StudentRepository studentRepository;

    public BonafideRestController(BonafideRepository bonafideRepository, StudentRepository studentRepository) {
        this.bonafideRepository = bonafideRepository;
        this.studentRepository = studentRepository;
    }

    @PostMapping("/apply")
    public ResponseEntity<?> apply(@RequestBody Map<String, Object> payload) {
        if (!payload.containsKey("prnno") || !payload.containsKey("reason")) {
            return ResponseEntity.badRequest().body(Map.of("success", false, "message", "PRN Number and reason are required."));
        }

        Long prnno = Long.parseLong(payload.get("prnno").toString());
        String reason = payload.get("reason").toString();

        BonafideRequest request = new BonafideRequest(prnno, reason, "Pending");
        bonafideRepository.save(request);

        return ResponseEntity.ok(Map.of("success", true, "message", "Bonafide request submitted successfully!", "requestId", request.getId()));
    }

    @GetMapping("/student/{prnno}")
    public ResponseEntity<List<BonafideRequest>> getStudentRequests(@PathVariable Long prnno) {
        return ResponseEntity.ok(bonafideRepository.findByPrnnoOrderByCreatedAtDesc(prnno));
    }

    @GetMapping("/pending")
    public ResponseEntity<List<BonafideRequest>> getPendingRequests() {
        return ResponseEntity.ok(bonafideRepository.findByStatusOrderByCreatedAtDesc("Pending"));
    }

    @PostMapping("/approve/{id}")
    public ResponseEntity<?> approve(@PathVariable Long id) {
        return bonafideRepository.findById(id).map(request -> {
            request.setStatus("Approved");
            request.setApprovedAt(LocalDateTime.now());
            bonafideRepository.save(request);
            return ResponseEntity.ok(Map.of("success", true, "message", "Bonafide request approved successfully!"));
        }).orElse(ResponseEntity.notFound().build());
    }

    @PostMapping("/reject/{id}")
    public ResponseEntity<?> reject(@PathVariable Long id, @RequestBody Map<String, String> payload) {
        String reason = payload.getOrDefault("reason", "Rejected by Student Section");
        return bonafideRepository.findById(id).map(request -> {
            request.setStatus("Rejected");
            request.setRejectionReason(reason);
            bonafideRepository.save(request);
            return ResponseEntity.ok(Map.of("success", true, "message", "Bonafide request rejected."));
        }).orElse(ResponseEntity.notFound().build());
    }

    @GetMapping(value = "/view/{id}", produces = MediaType.TEXT_HTML_VALUE)
    public ResponseEntity<String> viewBonafideCertificate(@PathVariable Long id) {
        Optional<BonafideRequest> requestOpt = bonafideRepository.findById(id);
        if (requestOpt.isEmpty()) {
            return ResponseEntity.notFound().build();
        }

        BonafideRequest request = requestOpt.get();
        Optional<Student> studentOpt = studentRepository.findByPrnno(request.getPrnno());
        Student student = studentOpt.orElseGet(() -> {
            Student s = new Student();
            s.setStudname("Vishal Shriram Ghuge");
            s.setPrnno(request.getPrnno());
            s.setBranch("Computer Science");
            s.setYear(3);
            s.setRollno(149);
            return s;
        });

        String issueDate = request.getApprovedAt() != null 
                ? request.getApprovedAt().format(DateTimeFormatter.ofPattern("dd-MM-yyyy"))
                : LocalDateTime.now().format(DateTimeFormatter.ofPattern("dd-MM-yyyy"));

        String html = """
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Bonafide Certificate - %s</title>
                <style>
                    body { font-family: 'Times New Roman', serif; background: #f8fafc; padding: 2rem; display: flex; justify-content: center; }
                    .certificate-container { width: 800px; background: #ffffff; padding: 3rem; border: 12px double #1e3a8a; box-shadow: 0 10px 25px rgba(0,0,0,0.15); position: relative; }
                    .header { text-align: center; border-bottom: 2px solid #1e3a8a; padding-bottom: 1rem; margin-bottom: 2rem; }
                    .header h1 { font-size: 24px; color: #1e3a8a; margin: 0; text-transform: uppercase; letter-spacing: 1px; }
                    .header h2 { font-size: 16px; color: #475569; margin-top: 5px; font-weight: normal; }
                    .cert-title { text-align: center; font-size: 26px; font-weight: bold; text-decoration: underline; margin: 2rem 0; color: #0f172a; letter-spacing: 2px; }
                    .content { font-size: 18px; line-height: 2.2; text-align: justify; color: #1e293b; margin-bottom: 3rem; }
                    .content strong { color: #0f172a; text-decoration: underline; }
                    .footer { display: flex; justify-content: space-between; align-items: flex-end; margin-top: 4rem; }
                    .seal { border: 2px dashed #1e3a8a; border-radius: 50%%; width: 110px; height: 110px; display: flex; align-items: center; justify-content: center; font-size: 12px; color: #1e3a8a; font-weight: bold; text-align: center; }
                    .signature { text-align: center; border-top: 1px solid #0f172a; width: 200px; padding-top: 5px; font-size: 15px; font-weight: bold; }
                    .print-btn { display: block; margin: 0 auto 1.5rem auto; padding: 0.75rem 1.5rem; background: #1e3a8a; color: white; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; }
                    @media print { .print-btn { display: none; } body { padding: 0; background: white; } }
                </style>
            </head>
            <body>
                <div>
                    <button class="print-btn" onclick="window.print()">🖨️ Print Certificate / Save as PDF</button>
                    <div class="certificate-container">
                        <div class="header">
                            <h1>Government College of Engineering</h1>
                            <h2>Approved by AICTE & Affiliated to University</h2>
                            <p style="margin-top:8px; font-size:14px; color:#64748b;">Ref No: GCET/BONAFIDE/2026/%d &nbsp;&nbsp;|&nbsp;&nbsp; Date: %s</p>
                        </div>

                        <div class="cert-title">BONAFIDE CERTIFICATE</div>

                        <div class="content">
                            This is to certify that <strong>Mr. %s</strong> (PRN Number: <strong>%d</strong>) is a bonafide student of this institute studying in <strong>%s Year (%s Engineering)</strong> for the Academic Year 2025-2026.
                            <br><br>
                            To the best of our knowledge and belief, he bears good moral character and conduct. This certificate is issued upon his application for the purpose of: <strong>%s</strong>.
                        </div>

                        <div class="footer">
                            <div class="seal">
                                OFFICIAL<br>SEAL & STAMP
                            </div>
                            <div class="signature">
                                Principal / Registrar<br>
                                Authorized Signatory
                            </div>
                        </div>
                    </div>
                </div>
            </body>
            </html>
            """.formatted(
                student.getStudname(),
                request.getId(),
                issueDate,
                student.getStudname(),
                student.getPrnno(),
                student.getYear() != null ? student.getYear() : 3,
                student.getBranch() != null ? student.getBranch() : "Computer Science",
                request.getReason()
            );

        return ResponseEntity.ok(html);
    }
}
