<?php
session_start();
// echo $_SESSION['desk_no'];

if (isset($_SESSION['loggedin']) && isset($_SESSION['desk_no'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Section Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #3498db;
            --primary-dark: #2980b9;
            --secondary: #2c3e50;
            --accent: #e74c3c;
            --success: #2ecc71;
            --warning: #f39c12;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --gray: #7f8c8d;
            --card-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Header Styles */
        #header-container {
            margin-bottom: 30px;
        }

        /* Main Content */
        .dashboard {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .welcome-banner {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 40px;
            box-shadow: var(--card-shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .welcome-text h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .welcome-text p {
            opacity: 0.9;
            font-size: 16px;
        }

        .desk-info {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
        }

        /* Button Container */
        .button-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .button-group {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-top: 5px solid var(--primary);
        }

        .button-group:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .button-group label {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .button-group a {
            width: 100%;
            text-decoration: none;
        }

        .button-group button {
            width: 100%;
            padding: 16px 20px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .button-group button:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary) 100%);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Different colors for different buttons */
        .button-group:nth-child(1) {
            border-top-color: var(--success);
        }
        
        .button-group:nth-child(1) button {
            background: linear-gradient(135deg, var(--success) 0%, #27ae60 100%);
        }

        .button-group:nth-child(2) {
            border-top-color: var(--warning);
        }
        
        .button-group:nth-child(2) button {
            background: linear-gradient(135deg, var(--warning) 0%, #e67e22 100%);
        }

        .button-group:nth-child(3) {
            border-top-color: var(--accent);
        }
        
        .button-group:nth-child(3) button {
            background: linear-gradient(135deg, var(--accent) 0%, #c0392b 100%);
        }

        .button-group:nth-child(4) {
            border-top-color: #9b59b6;
        }
        
        .button-group:nth-child(4) button {
            background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
        }

        
        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            background: var(--secondary);
            color: white;
            border-radius: 12px 12px 0 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .welcome-banner {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .button-container {
                grid-template-columns: 1fr;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .dashboard {
                padding: 15px;
            }

            .welcome-banner {
                padding: 20px;
            }

            .welcome-text h2 {
                font-size: 24px;
            }

            .button-group {
                padding: 20px;
            }

            .button-group button {
                padding: 14px 16px;
                font-size: 15px;
            }
        }

        /* Loading state for header */
        .header-loading {
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f0f0f0;
            border-radius: 0 0 12px 12px;
        }

        .spinner {
            width: 30px;
            height: 30px;
            border: 3px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Header container with loading state -->
    <div id="header-container" class="header-loading">
        <div class="spinner"></div>
    </div>
    
    <main class="dashboard">
        <div class="welcome-banner">
            <div class="welcome-text">
                <h2>Student Section Dashboard</h2>
                <p>Manage student requests and records</p>
                <div class="desk-info">
                    <i class="fas fa-desktop"></i>
                    <span>Desk No: <?php echo isset($_SESSION['desk_no']) ? $_SESSION['desk_no'] : 'N/A'; ?></span>
                </div>
            </div>
            <i class="fas fa-user-graduate" style="font-size: 3rem; opacity: 0.8;"></i>
        </div>


        <div class="button-container">
            <div class="button-group">
                <label for="bonafide-button"><i class="fas fa-file-certificate"></i> Bonafide Requests</label>
                <a href="../bonafide/admin/admin_portal.php">
                    <button id="bonafide-button"><i class="fas fa-external-link-alt"></i> Bonafide</button>
                </a>
            </div>
            <div class="button-group">
                <label for="lc-button"><i class="fas fa-graduation-cap"></i> Leaving Certificate Requests</label>
                <a href="../leaving_certificate/noDue/multi_section_actions.php">
                    <button id="lc-button"><i class="fas fa-external-link-alt"></i> Leaving Certificate</button>
                </a>
            </div>
            <div class="button-group">
                <label for="distribute-button"><i class="fas fa-tasks"></i> Distribute Leaving Certificates</label>
                <a href="../leaving_certificate/noDue/LC/ready_to_distributeLC.php">
                    <button id="distribute-button" type='submit'><i class="fas fa-external-link-alt"></i> Distribute</button>
                </a>
            </div>
            <div class="button-group">
                <label for="update-button"><i class="fas fa-database"></i> Update Records</label>
                <a href="../update_records/result/result.php">
                    <button id="update-button" type='submit'><i class="fas fa-external-link-alt"></i> UPDATE</button>
                </a>
            </div>
        </div>
    </main>

    <footer>
        <p>Student Section Portal &copy; <?php echo date('Y'); ?>. All rights reserved.</p>
    </footer>

    <!-- show header using below script fetch code from header.html of logout folder -->
    <script>
        function loadHeader() {
            fetch('../logout/header.html')
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
                    <header style="background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%); color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <i class="fas fa-graduation-cap" style="font-size: 2rem;"></i>
                            <div style="font-size: 1.5rem; font-weight: 600;">Student Section</div>
                        </div>
                        <div style="background-color: rgba(255, 255, 255, 0.2); padding: 8px 15px; border-radius: 50px; font-weight: 500;">
                            <i class="fas fa-desktop"></i>
                            <span>Desk No: <?php echo isset($_SESSION['desk_no']) ? $_SESSION['desk_no'] : 'N/A'; ?></span>
                        </div>
                    </header>
                `;
            });
        }
        
        // Logout function
        function logout() {
            fetch('../logout/logout.php', {
                method: 'POST',
                credentials: 'include'
            })
            .then(response => {
                if (response.ok) {
                    window.location.href = '../index.php';
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

<?php }
else{
  echo "<script>alert('Please login first!');window.location.href = '../index.php';</script>"; }
  ?>