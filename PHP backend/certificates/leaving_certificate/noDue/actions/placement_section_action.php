<?php 
session_start();
include('../../../db_conn.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requests for Bonafide</title>
    <link rel="stylesheet" href="../../../style/stud_sect_action.css">
</head>
<body>

<div class="container">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $prnno = $_POST['prnno'];
        $name = ''; // Initialize a variable for the name (you can fetch it from the database if required)
        echo "<div class='prn-container'>
                <h3>PRN Number: $prnno</h3>
              </div>";

        $sql = "SELECT 
        s.placement_status, s. studname, lc.prnno, s.year
                FROM 
                    students s
                INNER JOIN 
                    leaving_certificate lc ON s.prnno = lc.prnno
                WHERE 
                    lc.prnno = '$prnno'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<div class='table-responsive'><table class='fees-table'>
                    <thead>
                        <tr>
                            <th>PRN Number</th>
                            <th>Name</th>
                            <th>Acadamic Year</th>
                            <th>Placement Status</th>
                        </tr>
                    </thead>
                    <tbody>";

            while ($row = mysqli_fetch_assoc($result)) {
                

                echo "<tr>
                        <td>{$row['prnno']}</td>
                        <td>{$row['studname']}</td>
                        <td>{$row['year']}</td>
                        <td>{$row['placement_status']}</td>
                    </tr>";
                    
            }
            echo "</tbody></table></div>";

           
            echo "<div class='button-container'>
                    <form action='approve.php' method='POST'>
                        <input type='hidden' name='Approve' value='Approved'>
                        <input type='hidden' name='prnno' value=".$prnno.">
                        <button class='btn approve-btn' type='submit' onclick='return confirmApprove()'>Approve</button>
                    </form>
                    <button class='btn reject-btn' onclick='showModal()'>Reject</button>
                  </div>";
        } else {
            echo "<p>No records found for PRN Number: $prnno</p>";
        }
    }
    ?>
</div>

<!-- Modal for rejection reason -->
<div class="modal" id="rejectModal">
    <div class="modal-content">
        <h3>Reason for Rejection</h3>
        <form action="reject.php" method="POST">
            <input type="text" id="rejectionReason" name="reject" placeholder="Enter the reason for rejection" required>
            <input type='hidden' name='prnno' value='<?php echo "$prnno"; ?>'>
            <input type='hidden' name='Rejected' value='Rejected'>
            <div class="modal-actions">
                <button class="submit-button" type="submit">Submit</button>
                <button class="cancel-button" onclick="closeModal(); return false;">Cancel</button>
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

    // Confirmation before submitting approval
    function confirmApprove() {
        return confirm('Do you want to approve this request?');
    }
</script>

</body>
</html>
