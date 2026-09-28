<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarship Section Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
 <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #6c757d;
            --light: #f8f9fa;
            --dark: #343a40;
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --info: #17a2b8;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fb;
            color: #333;
            line-height: 1.6;
        }
        
        /* Header Styles */
        header {
            background: linear-gradient(120deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .logo {
            font-size: 2rem;
            color: white;
        }
        
        .logo-text {
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        .desk-info {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 8px 15px;
            border-radius: 50px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        /* Main Content */
        .dashboard {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }
        
        .welcome-banner {
            background: linear-gradient(120deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .welcome-text h2 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }
        
        .welcome-text p {
            opacity: 0.9;
        }
        
        .banner-icon {
            font-size: 3.5rem;
            opacity: 0.8;
        }
        
        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .card {
            background: white;
            border-radius: 12px;
            padding: 1.8rem;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            text-align: center;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }
        
        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 1.2rem;
            color: var(--primary);
        }
        
        .card h3 {
            font-size: 1.4rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }
        
        .card p {
            color: var(--secondary);
            margin-bottom: 1.5rem;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 28px;
            background-color: var(--primary);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        
        .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .btn-outline {
            background-color: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }
        
        .btn-outline:hover {
            background-color: var(--primary);
            color: white;
        }
        
        /* Footer */
        footer {
            text-align: center;
            padding: 1.5rem;
            margin-top: 2rem;
            background-color: var(--light);
            color: var(--secondary);
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                text-align: center;
                padding: 1rem;
            }
            
            .logo-container {
                margin-bottom: 1rem;
            }
            
            .welcome-banner {
                flex-direction: column;
                text-align: center;
            }
            
            .banner-icon {
                margin-top: 1rem;
            }
            
            .cards-container {
                grid-template-columns: 1fr;
            }
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
                <h2>Welcome to Scholarship Section</h2>
                <p>Manage scholarship records and leaving certificate requests</p>
            </div>
            <i class="fas fa-university banner-icon"></i>
        </div>
        
        <div class="cards-container">
            <div class="card">
                <i class="fas fa-file-certificate card-icon"></i>
                <h3>Leaving Certificate Requests</h3>
                <p>Process and manage no-due requests for leaving certificates</p>
                <a href="../leaving_certificate/noDue/multi_section_actions.php" class="btn">
                    <i class="fas fa-tasks"></i> Manage LC Requests
                </a>
            </div>
            
            <div class="card">
                <i class="fas fa-user-graduate card-icon"></i>
                <h3>Student Records</h3>
                <p>Update and maintain student scholarship records</p>
                <a href="../update_records/Scholarship/scholarship.php" class="btn btn-outline">
                    <i class="fas fa-edit"></i> Update Records
                </a>
            </div>
            
            <div class="card">
                <i class="fas fa-chart-line card-icon"></i>
                <h3>Reports & Analytics</h3>
                <p>View reports and analytics on scholarship distribution</p>
                <a href="#" class="btn">
                    <i class="fas fa-chart-bar"></i> View Reports
                </a>
            </div>
        </div>
    </main>
    
  

    <script>
        // Load header function
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
                    <header>
                        <div class="logo-container">
                            <i class="fas fa-graduation-cap logo"></i>
                            <div class="logo-text">Scholarship Portal</div>
                        </div>
                        <div class="desk-info">
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