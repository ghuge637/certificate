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
        st.studname AS stud_name,
        f.total_fees AS f_total_fees, f.paid_fees AS f_paid_fees,  
        s.total_fees AS s_total_fees, s.paid_fees AS s_paid_fees,
        t.total_fees AS t_total_fees, t.paid_fees AS t_paid_fees,
        fy.total_fees AS fy_total_fees, fy.paid_fees AS fy_paid_fees
                FROM
                students st
                INNER JOIN  
                First_year f ON st.prnno = f.prnno
                INNER JOIN 
                    Second_year s ON f.prnno = s.prnno
                INNER JOIN 
                    Third_year t ON f.prnno = t.prnno
                INNER JOIN 
                    Final_year fy ON f.prnno = fy.prnno
                WHERE 
                    fy.prnno = '$prnno'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<div class='table-responsive'><table class='fees-table'>
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Total Fees</th>
                            <th>Paid Fees</th>
                            <th>Remaining Fees</th>
                        </tr>
                    </thead>
                    <tbody>";

            while ($row = mysqli_fetch_assoc($result)) {
                
                echo "<h3>Name:". $row['stud_name']."</h3>";
                $f_remain = $row['f_total_fees'] - $row['f_paid_fees'];
                $s_remain = $row['s_total_fees'] - $row['s_paid_fees'];
                $t_remain = $row['t_total_fees'] - $row['t_paid_fees'];
                $fy_remain = $row['fy_total_fees'] - $row['fy_paid_fees'];

                echo "<tr>
                        <td>First Year</td>
                        <td>{$row['f_total_fees']}</td>
                        <td>{$row['f_paid_fees']}</td>
                        <td>{$f_remain}</td>
                    </tr>
                    <tr>
                        <td>Second Year</td>
                        <td>{$row['s_total_fees']}</td>
                        <td>{$row['s_paid_fees']}</td>
                        <td>{$s_remain}</td>
                    </tr>
                    <tr>
                        <td>Third Year</td>
                        <td>{$row['t_total_fees']}</td>
                        <td>{$row['t_paid_fees']}</td>
                        <td>{$t_remain}</td>
                    </tr>
                    <tr>
                        <td>Final Year</td>
                        <td>{$row['fy_total_fees']}</td>
                        <td>{$row['fy_paid_fees']}</td>
                        <td>{$fy_remain}</td>
                    </tr>";
            }
            echo "</tbody></table></div>";

            // Action buttons section
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
