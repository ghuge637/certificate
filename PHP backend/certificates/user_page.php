<?php
session_start();

if (isset($_SESSION['stud_id'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Certificate Portal</title>
  <!-- Font Awesome CDN with fallback -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" onerror="this.onerror=null;this.href='css/font-awesome-fallback.css';">
  <style>
    :root {
      --primary: #2c3e50;
      --secondary: #7f8c8d;
      --light: #f5f5f5;
      --dark: #2c3e50;
      --border: #e0e0e0;
      --card-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
      --transition: all 0.3s ease;
      --attendance: #3498db;
      --documents: #9b59b6;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: #f9f9f9;
      color: var(--dark);
      line-height: 1.6;
      min-height: 100vh;
    }

    /* Header Styles */
    #header-container {
      margin-bottom: 30px;
    }

    .header-loading {
      height: 70px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--light);
      border-bottom: 1px solid var(--border);
    }

    .spinner {
      width: 24px;
      height: 24px;
      border: 2px solid rgba(0, 0, 0, 0.1);
      border-radius: 50%;
      border-top-color: var(--primary);
      animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    /* Main Content */
    .main-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 80vh;
      padding: 20px;
    }

    .welcome-card {
      background: white;
      border-radius: 12px;
      padding: 30px;
      text-align: center;
      box-shadow: var(--card-shadow);
      max-width: 800px;
      width: 100%;
      margin-bottom: 40px;
      border: 1px solid var(--border);
    }

    .welcome-card h1 {
      font-size: 1.8rem;
      margin-bottom: 15px;
      color: var(--primary);
      font-weight: 600;
    }

    .welcome-card p {
      font-size: 1rem;
      color: var(--secondary);
      margin-bottom: 15px;
    }

    .student-id {
      display: inline-block;
      background: var(--light);
      color: var(--primary);
      padding: 6px 15px;
      border-radius: 4px;
      font-weight: 500;
      margin-top: 10px;
      border: 1px solid var(--border);
    }

    /* Certificate Cards */
    .certificate-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 25px;
      width: 100%;
      max-width: 900px;
    }

    .certificate-card {
      background: white;
      border-radius: 12px;
      padding: 25px;
      text-align: center;
      box-shadow: var(--card-shadow);
      transition: var(--transition);
      display: flex;
      flex-direction: column;
      align-items: center;
      border: 1px solid var(--border);
      position: relative;
      overflow: hidden;
    }

    .certificate-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .certificate-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
    }

    .certificate-card.bonafide::before {
      background: var(--primary);
    }

    .certificate-card.leaving::before {
      background: var(--primary);
    }

    .certificate-card.attendance::before {
      background: var(--attendance);
    }

    .certificate-card.documents::before {
      background: var(--documents);
    }

    .certificate-icon {
      font-size: 2.5rem;
      margin-bottom: 20px;
    }

    .certificate-card.bonafide .certificate-icon {
      color: var(--primary);
    }

    .certificate-card.leaving .certificate-icon {
      color: var(--primary);
    }

    .certificate-card.attendance .certificate-icon {
      color: var(--attendance);
    }

    .certificate-card.documents .certificate-icon {
      color: var(--documents);
    }

    .certificate-card h2 {
      font-size: 1.3rem;
      margin-bottom: 15px;
      color: var(--primary);
      font-weight: 600;
    }

    .certificate-card p {
      color: var(--secondary);
      margin-bottom: 25px;
      flex-grow: 1;
      line-height: 1.5;
    }

    .certificate-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      background: var(--primary);
      color: white;
      text-decoration: none;
      padding: 12px 25px;
      border-radius: 6px;
      font-weight: 500;
      transition: var(--transition);
      width: 100%;
      max-width: 180px;
      border: 1px solid var(--primary);
    }

    .certificate-btn:hover {
      background: white;
      color: var(--primary);
    }

    .attendance-btn {
      background: var(--attendance);
      border-color: var(--attendance);
    }

    .attendance-btn:hover {
      color: var(--attendance);
    }

    .documents-btn {
      background: var(--documents);
      border-color: var(--documents);
    }

    .documents-btn:hover {
      color: var(--documents);
    }

    /* Footer */
    footer {
      text-align: center;
      padding: 20px;
      margin-top: 50px;
      background: var(--light);
      color: var(--secondary);
      border-top: 1px solid var(--border);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .welcome-card {
        padding: 25px 20px;
      }
      
      .welcome-card h1 {
        font-size: 1.5rem;
      }
      
      .certificate-container {
        grid-template-columns: 1fr;
      }
      
      .certificate-card {
        padding: 20px;
      }
    }

    @media (max-width: 480px) {
      .welcome-card h1 {
        font-size: 1.4rem;
      }
      
      .certificate-btn {
        padding: 10px 20px;
      }
    }
  </style>
</head>
<body>
  <!-- Header container with loading state -->
  <div id="header-container" class="header-loading">
    <div class="spinner"></div>
  </div>

  <main class="main-container">
    <div class="welcome-card">
      <h1><i class="fas fa-certificate"></i> Student Certificate Portal</h1>
      <p>Apply for official college certificates and access student resources</p>
      <span class="student-id">Student ID: <?php echo isset($_SESSION['stud_id']) ? $_SESSION['stud_id'] : 'N/A'; ?></span>
    </div>

    <div class="certificate-container">
      <div class="certificate-card bonafide">
        <i class="fas fa-file-certificate certificate-icon"></i>
        <h2>Bonafide Certificate</h2>
        <p>Official proof of enrollment for various purposes including bank accounts, scholarships, and more.</p>
        <a href="bonafide/user/apply.php" class="certificate-btn">
          <i class="fas fa-pen"></i> Apply Now
        </a>
      </div>

      <div class="certificate-card leaving">
        <i class="fas fa-graduation-cap certificate-icon"></i>
        <h2>Leaving Certificate</h2>
        <p>Required when leaving the institution, confirming your academic record and status.</p>
        <a href="leaving_certificate/userLc/apply_lc.php" class="certificate-btn">
          <i class="fas fa-pen"></i> Apply Now
        </a>
      </div>

      <div class="certificate-card attendance">
        <i class="fas fa-calendar-check certificate-icon"></i>
        <h2>Attendance</h2>
        <p>View your attendance records, check percentage, and download reports for your reference.</p>
        <a href="attendance/view.php" class="certificate-btn attendance-btn">
          <i class="fas fa-chart-line"></i> View
        </a>
      </div>

      <div class="certificate-card documents">
        <i class="fas fa-file-alt certificate-icon"></i>
        <h2>Documents</h2>
        <p>Access and download your important documents, including mark sheets, ID cards, and more.</p>
        <a href="documents/view.php" class="certificate-btn documents-btn">
          <i class="fas fa-download"></i> Documents
        </a>
      </div>
    </div>
  </main>

  <footer>
    <p>Student Certificate Portal &copy; <?php echo date('Y'); ?></p>
  </footer>

  <!-- Header loading script -->
  <script>
    function loadHeader() {
      fetch('logout/header.html')
      .then(response => {
        if (!response.ok) {
          throw new Error('Header not found');
        }
        return response.text();
      })
      .then(data => {
        document.getElementById('header-container').innerHTML = data;
        // Add event listener to any logout button in the header
        const logoutBtn = document.querySelector('.logout-btn');
        if (logoutBtn) {
          logoutBtn.addEventListener('click', logout);
        }
      })
      .catch(error => {
        console.error('Header load error:', error);
        // Fallback header if external header fails to load
        document.getElementById('header-container').innerHTML = `
          <header style="background: white; color: #2c3e50; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e0e0e0;">
            <div style="display: flex; align-items: center; gap: 12px;">
              <i class="fas fa-certificate" style="font-size: 1.5rem;"></i>
              <div style="font-size: 1.2rem; font-weight: 600;">Certificate Portal</div>
            </div>
            <div style="background-color: #f5f5f5; padding: 6px 12px; border-radius: 4px; font-weight: 500; border: 1px solid #e0e0e0;">
              <i class="fas fa-user-graduate"></i>
              <span>Student ID: <?php echo isset($_SESSION['stud_id']) ? $_SESSION['stud_id'] : 'N/A'; ?></span>
            </div>
          </header>
        `;
      });
    }
    
    // Logout function
    function logout() {
      fetch('logout/logout.php', {
        method: 'POST',
        credentials: 'include'
      })
      .then(response => {
        if (response.ok) {
          window.location.href = 'index.php';
        } else {
          alert("Logout failed");
        }
      })
      .catch(error => console.error('Logout error:', error));
    }
    
    // Load header when page loads
    document.addEventListener('DOMContentLoaded', loadHeader);
  </script>
</body>
</html>
<?php
} else {
    echo "<div style='background: #f9f9f9; height: 100vh; display: flex; justify-content: center; align-items: center;'>
            <div style='background: white; padding: 30px; border-radius: 12px; text-align: center; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08); max-width: 450px; width: 90%; border: 1px solid #e0e0e0;'>
              <i class='fas fa-exclamation-triangle' style='font-size: 2.5rem; color: #7f8c8d; margin-bottom: 20px;'></i>
              <h2 style='color: #2c3e50; margin-bottom: 15px;'>Access Denied</h2>
              <p style='color: #7f8c8d; margin-bottom: 25px;'>You must be logged in to access this page.</p>
              <a href='index.php' style='display: inline-block; background: #2c3e50; color: white; padding: 10px 22px; border-radius: 6px; text-decoration: none; font-weight: 500; border: 1px solid #2c3e50;'>
                <i class='fas fa-sign-in-alt'></i> Login Now
              </a>
            </div>
          </div>";
}
?>