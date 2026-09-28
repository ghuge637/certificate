<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Apply Bonafide</title>
    <link rel="stylesheet" href="../../style/apply.css">
    <!-- <link rel="stylesheet" href="../../style/style.css"> -->
    <style>
        .background {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('https://images.saymedia-content.com/.image/t_share/MTkyOTkyMzE2OTQ3MjQ0MjUz/website-background-templates.jpg') no-repeat center center;
      background-size: cover;
      z-index: -2;
    }

    /* Blur effect */
    .blur-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      background: rgba(255, 255, 255, 0.1);
      z-index: -1;
    }
    </style>
</head>
<body>
        <div id="header-container"></div>  <!-- div for header content  -->

    <div class="background"></div>
  <div class="blur-overlay"></div>
<center><div class="container">
        <div class="select_reason">
        <form action="request.php" method="POST">
            <label for="reason">Select Reason for Bonafide:</label>
            <select id="reason" name="reason" required>
                <option value="" disabled selected>Select</option>
                <option value="scholarships">To apply for Scholarships.</option>
                <option value="loan">For educational loan applications.</option>
                <option value="competitions">For participation in inter-collegiate events or competitions.</option>
                <option value="transfer">To transfer to another school or college.</option>
                <option value="passport">For passport application or renewal.</option>
                <option value="internship">For internship or training purposes.</option>
                <option value="id_verification">For Aadhaar card or other government ID verification.</option>
                <option value="visa">For visa applications (especially for study abroad programs).</option>
                <option value="travel">To avail of student travel concessions (railways, airlines, or buses).</option>
                <option value="hostel">For hostel admission.</option>
                <option value="internship_proof">For company internships requiring proof of enrollment.</option>
            </select>
            <div class="button-container">
                <button type="submit" class="apply-button" name="Apply">Apply</button>
                <a href="../../user_page.php">
                    <button type="button" class="cancel-button">Cancel</button>
                </a>
            </div>
        </form>
        </div>



                   <?php
                        include('../../db_conn.php');
                        
                        $prnno =  $_SESSION['stud_id'];
                       
                        
                        

                        $check_sql = "SELECT * FROM bonafide WHERE prnno = '$prnno'";
                        $check_result = mysqli_query($conn, $check_sql);

                        if (mysqli_num_rows($check_result) > 0) {
                            echo "<div class='container1'><table class='table'>
                                    <thead>
                                        <tr>
                                            <th>PRN No</th>
                                          
                                            <th>Status</th>
                                            <th>Rejected Reason</th>
                                            <th>Cancle Request</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                            while ($row = mysqli_fetch_assoc($check_result)) {

                              $status = $row['status']; //inatilize for display approval msg 

                                echo "<tr>
                                        <td>{$row['prnno']}</td>
                                        
                                        <td>{$row['status']}</td>
                                        <td>{$row['rejected']}</td>
                                        <td>
                                            <form action='remove_request.php' method='POST' style='display: inline;'>
                                                <input type='hidden' name='prnno' value='{$prnno}'>
                                                <button type='submit' onclick='return confirmDelete()' class='remove'>X</button>
                                            </form>
                                        </td>
                                    </tr>";

                            }
                            echo "</tbody></table></div>";

                            if($status =='Approved'){
                                    echo "<p style='margin-top:30px;background-color: transparent; border:2px solid black; border-radius:5px;
                                          justify-content:center; height:40px; display:flex; align-items:center;'>Your Bonafide is generated Please Go and collect it from Office";
                                  }
                        }
                    ?>

</div>
<script>
      function confirmDelete() {
        // Show a confirmation dialog using single quotes for the string
        return confirm('Are you sure you want to delete this request?');
        // If the user clicks 'OK', the form will be submitted
        // If the user clicks 'Cancel', the form submission will be stopped
    }       
    </script>
    </center>

       <!-- show header using below script fetch code from header.html of logout folder -->
<script>
    function loadHeader() {
        fetch('../../logout/header.html') // adjust path if needed
        .then(response => response.text())
        .then(data => {
            document.getElementById('header-container').innerHTML = data;
        })
        .catch(error => console.error('Header load error:', error));
    }
    loadHeader();
</script>


<!-- bellow script for perform logout operation basically its 
 fetch logout code from logout.php file and perform operation -->

<script>
  function logout() {
    fetch('../../logout/logout.php', {
      method: 'POST',
      credentials: 'include'
    })
    .then(response => {
      if (response.ok) {
        window.location.href = '../../index.php';
      } else {
        alert("Logout failed");
      }
    })
    .catch(error => console.error('Logout error:', error));
  }
</script>


</body>
</html>