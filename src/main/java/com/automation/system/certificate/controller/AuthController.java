package com.automation.system.certificate.controller;

import com.automation.system.certificate.dto.LoginRequest;
import com.automation.system.certificate.dto.LoginResponse;
import com.automation.system.certificate.service.AuthService;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@CrossOrigin(origins = "*")
public class AuthController {

    private final AuthService authService;

    public AuthController(AuthService authService) {
        this.authService = authService;
    }

    @GetMapping("/")
    public String loginPage() {
        return """
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Portal Login - Certificate System</title>
                <style>
                    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; }
                    body { display: flex; justify-content: center; align-items: center; min-height: 100vh; background: radial-gradient(circle at top right, #1e1b4b, #0f172a, #020617); color: #f8fafc; }
                    .login-container { width: 100%; max-width: 440px; background: rgba(30, 41, 59, 0.75); backdrop-filter: blur(16px); border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.12); padding: 2.5rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6); }
                    .brand { text-align: center; margin-bottom: 2rem; }
                    .brand-logo { width: 56px; height: 56px; background: linear-gradient(135deg, #38bdf8, #6366f1); border-radius: 14px; display: inline-flex; justify-content: center; align-items: center; font-size: 28px; margin-bottom: 1rem; box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.4); }
                    .brand h1 { font-size: 1.5rem; font-weight: 700; background: linear-gradient(to right, #ffffff, #94a3b8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
                    .brand p { color: #94a3b8; font-size: 0.875rem; margin-top: 0.25rem; }
                    .role-tabs { display: flex; background: rgba(15, 23, 42, 0.6); padding: 4px; border-radius: 12px; margin-bottom: 1.75rem; border: 1px solid rgba(255, 255, 255, 0.05); }
                    .tab-btn { flex: 1; padding: 0.65rem; border: none; background: transparent; color: #94a3b8; font-weight: 600; font-size: 0.875rem; border-radius: 8px; cursor: pointer; transition: all 0.2s ease; }
                    .tab-btn.active { background: linear-gradient(135deg, #38bdf8, #6366f1); color: #ffffff; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3); }
                    .form-group { margin-bottom: 1.25rem; text-align: left; }
                    .form-group label { display: block; font-size: 0.825rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em; }
                    .form-control { width: 100%; padding: 0.85rem 1rem; background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 10px; color: #ffffff; font-size: 0.95rem; outline: none; transition: border-color 0.2s; }
                    .form-control:focus { border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2); }
                    .btn-submit { width: 100%; padding: 0.9rem; border: none; background: linear-gradient(135deg, #38bdf8, #6366f1); color: #ffffff; font-weight: 700; font-size: 1rem; border-radius: 10px; cursor: pointer; transition: transform 0.1s, box-shadow 0.2s; margin-top: 0.5rem; }
                    .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.5); }
                    .alert { padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.875rem; margin-bottom: 1.25rem; display: none; }
                    .alert-error { background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.4); color: #fca5a5; }
                    .alert-success { background: rgba(34, 197, 94, 0.2); border: 1px solid rgba(34, 197, 94, 0.4); color: #86efac; }
                    .demo-box { margin-top: 1.75rem; padding: 1rem; background: rgba(15, 23, 42, 0.5); border-radius: 10px; border: 1px dashed rgba(255, 255, 255, 0.15); text-align: left; font-size: 0.8rem; color: #94a3b8; }
                    .demo-box strong { color: #e2e8f0; }
                </style>
            </head>
            <body>
                <div class="login-container">
                    <div class="brand">
                        <div class="brand-logo">🎓</div>
                        <h1>Certificate Portal</h1>
                        <p>Sign in to access your dashboard</p>
                    </div>

                    <div class="role-tabs">
                        <button class="tab-btn active" id="tab-student" onclick="setRole('STUDENT')">👨‍🎓 Student</button>
                        <button class="tab-btn" id="tab-staff" onclick="setRole('STAFF')">👨‍🏫 Staff</button>
                    </div>

                    <div id="alertBox" class="alert"></div>

                    <form id="loginForm" onsubmit="handleLogin(event)">
                        <input type="hidden" id="selectedRole" value="STUDENT">
                        <div class="form-group">
                            <label id="userLabel">Student Username / ID</label>
                            <input type="text" id="username" class="form-control" placeholder="e.g. student1" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" id="password" class="form-control" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn-submit" id="submitBtn">Log In as Student</button>
                    </form>

                    <div class="demo-box">
                        <strong>📌 Quick Demo Accounts:</strong><br>
                        • <strong>Student:</strong> <code>student1</code> / <code>password123</code><br>
                        • <strong>Staff:</strong> <code>staff1</code> / <code>password123</code>
                    </div>
                </div>

                <script>
                    let currentRole = 'STUDENT';

                    function setRole(role) {
                        currentRole = role;
                        document.getElementById('selectedRole').value = role;
                        const studentTab = document.getElementById('tab-student');
                        const staffTab = document.getElementById('tab-staff');
                        const userLabel = document.getElementById('userLabel');
                        const submitBtn = document.getElementById('submitBtn');
                        const usernameInput = document.getElementById('username');

                        if (role === 'STUDENT') {
                            studentTab.classList.add('active');
                            staffTab.classList.remove('active');
                            userLabel.innerText = 'Student Username / ID';
                            usernameInput.placeholder = 'e.g. student1';
                            submitBtn.innerText = 'Log In as Student';
                        } else {
                            staffTab.classList.add('active');
                            studentTab.classList.remove('active');
                            userLabel.innerText = 'Staff Username / ID';
                            usernameInput.placeholder = 'e.g. staff1';
                            submitBtn.innerText = 'Log In as Staff';
                        }
                        hideAlert();
                    }

                    async function handleLogin(e) {
                        e.preventDefault();
                        const username = document.getElementById('username').value;
                        const password = document.getElementById('password').value;
                        const role = currentRole;
                        const alertBox = document.getElementById('alertBox');

                        try {
                            const res = await fetch('/api/auth/login', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({ username, password, role })
                            });
                            const data = await res.json();
                            if (data.success) {
                                showAlert('Success! Redirecting to dashboard...', 'success');
                                setTimeout(() => window.location.href = data.redirectUrl, 800);
                            } else {
                                showAlert(data.message, 'error');
                            }
                        } catch (err) {
                            showAlert('Server error during authentication.', 'error');
                        }
                    }

                    function showAlert(msg, type) {
                        const alertBox = document.getElementById('alertBox');
                        alertBox.innerText = msg;
                        alertBox.className = 'alert alert-' + type;
                        alertBox.style.display = 'block';
                    }

                    function hideAlert() {
                        document.getElementById('alertBox').style.display = 'none';
                    }
                </script>
            </body>
            </html>
            """;
    }

    @PostMapping("/api/auth/login")
    public ResponseEntity<LoginResponse> login(@RequestBody LoginRequest request) {
        LoginResponse response = authService.authenticate(request);
        if (response.isSuccess()) {
            return ResponseEntity.ok(response);
        } else {
            return ResponseEntity.badRequest().body(response);
        }
    }

    @GetMapping("/dashboard/student")
    public String studentDashboard() {
        return """
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Student Dashboard - Certificate System</title>
                <style>
                    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
                    body { background: #0f172a; color: #f8fafc; min-height: 100vh; }
                    .navbar { background: #1e293b; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
                    .nav-brand { font-size: 1.25rem; font-weight: 700; color: #38bdf8; display: flex; align-items: center; gap: 0.5rem; }
                    .user-badge { background: rgba(56, 189, 248, 0.15); color: #38bdf8; padding: 0.4rem 1rem; border-radius: 9999px; font-weight: 600; font-size: 0.85rem; }
                    .btn-logout { background: #ef4444; color: white; border: none; padding: 0.4rem 1rem; border-radius: 8px; cursor: pointer; text-decoration: none; font-size: 0.85rem; font-weight: 600; }
                    .container { max-width: 1000px; margin: 2rem auto; padding: 0 1rem; }
                    .header-card { background: linear-gradient(135deg, #1e293b, #334155); padding: 2rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); margin-bottom: 2rem; }
                    .header-card h2 { font-size: 1.75rem; margin-bottom: 0.5rem; }
                    .header-card p { color: #94a3b8; }
                    .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; }
                    .card { background: #1e293b; border-radius: 14px; border: 1px solid rgba(255,255,255,0.08); padding: 1.5rem; }
                    .card h3 { font-size: 1.1rem; color: #38bdf8; margin-bottom: 1rem; }
                    .cert-item { background: #0f172a; padding: 1rem; border-radius: 10px; margin-bottom: 0.75rem; border-left: 4px solid #22c55e; }
                    .cert-item.pending { border-left-color: #eab308; }
                    .cert-title { font-weight: 600; }
                    .cert-sub { font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem; }
                </style>
            </head>
            <body>
                <div class="navbar">
                    <div class="nav-brand">🎓 Certificate System</div>
                    <div style="display:flex; align-items:center; gap: 1rem;">
                        <span class="user-badge">Role: Student</span>
                        <a href="/" class="btn-logout">Logout</a>
                    </div>
                </div>

                <div class="container">
                    <div class="header-card">
                        <h2>Welcome back, Alex Johnson!</h2>
                        <p>Department of Computer Science • ID: STU-1001</p>
                    </div>

                    <div class="grid">
                        <div class="card">
                            <h3>📜 Issued Certificates</h3>
                            <div class="cert-item">
                                <div class="cert-title">Bachelor of Science Degree</div>
                                <div class="cert-sub">Issued on: Jan 15, 2026 • Verified ✓</div>
                            </div>
                            <div class="cert-item">
                                <div class="cert-title">Web Development Specialization</div>
                                <div class="cert-sub">Issued on: Nov 10, 2025 • Verified ✓</div>
                            </div>
                        </div>

                        <div class="card">
                            <h3>⏳ Pending Requests</h3>
                            <div class="cert-item pending">
                                <div class="cert-title">Academic Transcript Certificate</div>
                                <div class="cert-sub">Submitted: Aug 20, 2026 • Under Review</div>
                            </div>
                        </div>
                    </div>
                </div>
            </body>
            </html>
            """;
    }

    @GetMapping("/dashboard/staff")
    public String staffDashboard() {
        return """
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Staff Dashboard - Certificate System</title>
                <style>
                    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
                    body { background: #0f172a; color: #f8fafc; min-height: 100vh; }
                    .navbar { background: #1e293b; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
                    .nav-brand { font-size: 1.25rem; font-weight: 700; color: #818cf8; display: flex; align-items: center; gap: 0.5rem; }
                    .user-badge { background: rgba(129, 140, 248, 0.15); color: #818cf8; padding: 0.4rem 1rem; border-radius: 9999px; font-weight: 600; font-size: 0.85rem; }
                    .btn-logout { background: #ef4444; color: white; border: none; padding: 0.4rem 1rem; border-radius: 8px; cursor: pointer; text-decoration: none; font-size: 0.85rem; font-weight: 600; }
                    .container { max-width: 1000px; margin: 2rem auto; padding: 0 1rem; }
                    .header-card { background: linear-gradient(135deg, #1e1b4b, #312e81); padding: 2rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); margin-bottom: 2rem; }
                    .header-card h2 { font-size: 1.75rem; margin-bottom: 0.5rem; }
                    .header-card p { color: #c7d2fe; }
                    .table-card { background: #1e293b; border-radius: 14px; border: 1px solid rgba(255,255,255,0.08); padding: 1.5rem; }
                    .table-card h3 { font-size: 1.1rem; color: #818cf8; margin-bottom: 1rem; }
                    table { width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem; }
                    th, td { padding: 0.85rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.08); }
                    th { color: #94a3b8; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; }
                    .btn-approve { background: #22c55e; color: white; border: none; padding: 0.35rem 0.75rem; border-radius: 6px; cursor: pointer; font-size: 0.8rem; font-weight: 600; }
                    .btn-reject { background: #64748b; color: white; border: none; padding: 0.35rem 0.75rem; border-radius: 6px; cursor: pointer; font-size: 0.8rem; font-weight: 600; margin-left: 0.25rem; }
                </style>
            </head>
            <body>
                <div class="navbar">
                    <div class="nav-brand">👨‍🏫 Staff Certificate Portal</div>
                    <div style="display:flex; align-items:center; gap: 1rem;">
                        <span class="user-badge">Role: Staff Member</span>
                        <a href="/" class="btn-logout">Logout</a>
                    </div>
                </div>

                <div class="container">
                    <div class="header-card">
                        <h2>Staff Management Panel</h2>
                        <p>Dr. Robert Smith • Academic Affairs Office (ID: STF-5001)</p>
                    </div>

                    <div class="table-card">
                        <h3>📋 Certificate Approval Queue</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Student ID</th>
                                    <th>Certificate Requested</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Alex Johnson</td>
                                    <td>STU-1001</td>
                                    <td>Academic Transcript</td>
                                    <td>Aug 20, 2026</td>
                                    <td>
                                        <button class="btn-approve" onclick="alert('Approved!')">Approve</button>
                                        <button class="btn-reject" onclick="alert('Rejected')">Reject</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sophia Chen</td>
                                    <td>STU-1002</td>
                                    <td>Degree Completion Cert</td>
                                    <td>Aug 22, 2026</td>
                                    <td>
                                        <button class="btn-approve" onclick="alert('Approved!')">Approve</button>
                                        <button class="btn-reject" onclick="alert('Rejected')">Reject</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </body>
            </html>
            """;
    }
}
