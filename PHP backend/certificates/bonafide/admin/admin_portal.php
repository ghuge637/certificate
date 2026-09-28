<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requests for Bonafide</title>
    <link rel="stylesheet" href="../../style/style.css">
    <style>
        /* styling for filter */
            .filter{
            /* padding:20px; */
            margin:auto;
            margin-top:1%;
            }
            select{
            height: 30px;
            width: 60%;
            padding: 5px;
            /* margin-bottom: 20px; */
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .filter-container{
            margin-left: 20%;
        }

    </style>
</head>
<body>
    <div id="header-container"></div><!-- div for header -->
    
    <a href="distributed_bonafides.php" ><button class="btn">History</button></a>
    <div class="container">
        <div class="title">Requests for Bonafide</div>
        
            <form action="" method="POST" class="filter">
                <div class="filter-container">
                    
                    <select name="status" required>
                        <option value="" disabled selected>Select</option>
                        <option value="Approved">Short list based on Approved</option>
                        <option value="Completed">Short list based on Completed</option>
                        <option value="Pending">Short list based on Pending</option>
                    </select>

                    <button type="submit" class="btn" name="Apply">Filter</button> 
                </div>
            </form>

            
            
        
<?php
include('../../db_conn.php');

$status = 'Pending';

    if (isset($_POST['status']) && !empty($_POST['status'])) { //if condition impliment for impliment filter
        $status = $_POST['status'];
    }


    $sql = "SELECT students.prnno, students.studname, students.studdob, students.branch, students.year, bonafide.reason, bonafide.status
            FROM bonafide 
            JOIN students ON bonafide.prnno = students.prnno 
            WHERE bonafide.status = '$status'";  //base on selected veriable display requestes
    $check_result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<div class='table-wrapper'>";
        echo "<table class='table'>
                <thead>
                    <tr>
                        <th>PRN No</th>
                        <th>Student Name</th>
                        <th>Date of Birth</th>
                        <th>Branch</th>
                        <th>Current Year</th>
                        <th>Reason</th>
                        <th>Get action</th>
                        <th>Print</th>
                        <th>Complete</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = mysqli_fetch_assoc($check_result)) { 
            $prnno = $row['prnno'];
            echo "<tr>
                    <td>" . $row['prnno'] . "</td>
                    <td>" . $row['studname'] . "</td>
                    <td>" . $row['studdob'] . "</td>
                    <td>" . $row['branch'] . "</td>
                    <td>" . $row['year'] . "</td>
                    <td>" . $row['reason'] . "</td>";
                    
                        if($row['status'] != 'Pending'){
                            echo "<td>".$row['status']."</td>";
                        }
                        else
                            {
                                echo   " <td>
                                    <form action='approve.php' method='POST'  style=' display: inline;'>
                                    <input type='hidden' name='Approve' value='Approved'>
                                    <input type='hidden' name='prnno' value=".$row['prnno'].">
                                    <button class='btn' type='submit' onclick='return confirmApprove()';>Aprove</button></form>
                                    <button class='reject-btn' onclick='showModal()''>Reject</button>
                                </td> ";}

                                if($row['status'] != 'Pending' && $row['status'] != 'Rejected'){
                                    echo "<td>
                                            <form action='create_bonafide.php' method='POST'  style=' display: inline;'>
                                            <input type='hidden' name='prnno' value='" . $prnno . "'>
                                            <button class='btn' type='submit'>View</button></form>
                                        </td>"; }
                                    else{echo "<td><button class='disable-btn' type='submit'>View</button></form></td>";}


                                    if($row['status'] == 'Completed'){
                                        echo "<td>
                                                <form action='remove_request.php' method='POST' style='display: inline;' onsubmit='return confirmDelete();'>
                                                    <input type='hidden' name='prnno' value='$prnno'>
                                                    <button class='reject-btn'type='submit'>Remove</button>
                                                </form> 
                                            </td>"; }
                                        else{echo "<td><button class='disable-btn' type='submit'>Remove</button></form></td>";}
                    echo "</tr>";
        }
        echo "</tbody></table> </div>";
    }
?>
    </div>

    <div class="modal" id="rejectModal">
        <div class="modal-content">
            <h3>Reason for Rejection</h3>
            <form action="reject.php" method="POST">
                <input type="text" id="rejectionReason" name="reject" placeholder="Enter the reason for rejection">
                <input type='hidden' name='prnno' value='<?php echo "$prnno"; ?>'>
                <input type='hidden' name='Rejected' value='Rejected'>
                <div>
                    <button class="submit-button" onclick="submitRejection()" type="submit">Submit</button>
                    <button class="cancel-button" onclick="closeModal(); return false;" >Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        // Show the modal
        function showModal() {
            document.getElementById('rejectModal').style.display = 'flex';
        }

        // Close the modal
        function closeModal() {
            document.getElementById('rejectModal').style.display = 'none';
        }

        // Submit the rejection
        function submitRejection() {
            const reason = document.getElementById('rejectionReason').value.trim();
            if (reason) {
                alert(`Application Rejected. Reason: ${reason}`);
                closeModal();
            } else {
                alert('Please provide a reason for rejection.');
            }
        }

        //conform cancle message
        function confirmDelete() {
        // Show a confirmation dialog using single quotes for the string
        return confirm('Are you sure you want to delete this request?');
        // If the user clicks 'OK', the form will be submitted
        // If the user clicks 'Cancel', the form submission will be stopped
    }  
    function confirmApprove() {
           return confirm('want to Approve');
    
    } 
    </script>


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


