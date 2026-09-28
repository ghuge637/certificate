<?php 
session_start();
include('../../../db_conn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student section get Action</title>
</head>
<link rel="stylesheet" href="../../../style/stud_sect_action.css">
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prnno = $_POST['prnno'];
    echo "<div class='container'>";
    echo "<div class='prn-container'><h3>PRN Number: $prnno</h3>";

    $sql = "SELECT 
    st.studname AS stud_name,
    f.academic_status AS f_academic_status, f.SGPA AS f_SGPA, f.CGPA AS f_CGPA, f.exam_form_status AS f_exam_form_status, 
    s.academic_status AS s_academic_status, s.SGPA AS s_SGPA, s.CGPA AS s_CGPA, s.exam_form_status AS s_exam_form_status,
    t.academic_status AS t_academic_status, t.SGPA AS t_SGPA, t.CGPA AS t_CGPA, t.exam_form_status AS t_exam_form_status,
    fy.academic_status AS fy_academic_status, fy.SGPA AS fy_SGPA, fy.CGPA AS fy_CGPA , fy.exam_form_status AS fy_exam_form_status
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
                <tr>
                    <th>Year</th>
                    <th>Academic Status</th>
                    <th>SGPA</th>
                    <th>CGPA</th>
                    <th>Exam Form Status</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            
            echo "<h3>NAME:" . $row['stud_name'] ."</h3>";
            echo "<tr>
                    <td>First Year</td>
                    <td>{$row['f_academic_status']}</td>
                    <td>{$row['f_SGPA']}</td>
                    <td>{$row['f_CGPA']}</td>
                    <td>{$row['f_exam_form_status']}</td>
                </tr>
                <tr>
                    <td>Second Year</td>
                    <td>{$row['s_academic_status']}</td>
                    <td>{$row['s_SGPA']}</td>
                    <td>{$row['s_CGPA']}</td>
                    <td>{$row['s_exam_form_status']}</td>
                </tr>
                <tr>
                    <td>Third Year</td>
                    <td>{$row['t_academic_status']}</td>
                    <td>{$row['t_SGPA']}</td>
                    <td>{$row['t_CGPA']}</td>
                    <td>{$row['t_exam_form_status']}</td>
                </tr>
                <tr>
                    <td>Final Year</td>
                    <td>{$row['fy_academic_status']}</td>
                    <td>{$row['fy_SGPA']}</td>
                    <td>{$row['fy_CGPA']}</td>
                    <td>{$row['fy_exam_form_status']}</td>
                </tr>";
        }
        echo "</table></div>";

        echo "<div style='text-align: center; margin-top: 20px;' class='button-container'>
                <form action='approve.php' method='POST'>
                    <input type='hidden' name='Approve' value='Approved'>
                    <input type='hidden' name='prnno' value=".$prnno.">
                    <button class='btn' type='submit' onclick='return confirmApprove()';>Approve</button>
                </form>
                 <button class='reject-btn' onclick='showRejectModal()'>Reject</button>
                 <button class='reject-btn' onclick='showFailModal()'>Failed</button>
              </div>";
    } else {
        echo "<p>No records found for PRN Number: $prnno</p>";
    }
    echo "</div>";
}
?>

<div class="modal" id="rejectModal">
    <div class="modal-content">
        <h3>Reason for Rejection</h3>
        <form action="reject.php" method="POST" onsubmit="return submitRejection('rejectModal', 'rejectionReason', 'Please provide a reason for rejection.');">
            <input type="text" id="rejectionReason" name="reject" placeholder="Enter the reason for rejection">
            <input type='hidden' name='prnno' value='<?php echo "$prnno"; ?>'>
            <input type='hidden' name='Rejected' value='Rejected'>
            <div class="button-container">
                <button class="submit-button" type="submit">Submit</button>
                <button class="cancel-button" onclick="closeModal('rejectModal'); return false;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div class="modal" id="failed">
    <div class="modal-content">
        <h3>Enter Failed Value</h3>
        <form action="approve.php" method="POST" onsubmit="return submitRejection('failed', 'failedvalue', 'Please provide Failed value.');">
            <input type="text" id="failedvalue" name="reject" placeholder="Enter the Failed value">
            <input type='hidden' name='prnno' value='<?php echo "$prnno"; ?>'>
            <input type='hidden' name='failed' value='failed'>
            <input type='hidden' name='Approve' value='Approved'>
            <div class="button-container">
                <button class="submit-button" type="submit">Submit</button>
                <button class="cancel-button" onclick="closeModal('failed'); return false;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Function to show the rejection modal
    function showRejectModal() {
        document.getElementById('rejectModal').style.display = 'flex';
    }

    // Function to show the failed modal
    function showFailModal() {
        document.getElementById('failed').style.display = 'flex';
    }

    // Function to close the modal
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    // Function to handle form submission
    function submitRejection(modalId, inputId, errorMessage) {
        const reason = document.getElementById(inputId).value.trim();
        if (reason) {
            alert(`Really you want to submit: ${reason}`);
            closeModal(modalId);
            return true; // Allow form submission
        } else {
            alert(errorMessage);
            return false; // Prevent form submission
        }
    }

    // Function to confirm approval
    function confirmApprove() {
        return confirm('Do you want to Approve?');
    }
</script>

</body>
</html>
