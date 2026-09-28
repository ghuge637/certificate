<?php 
session_start();
include('../../../db_conn.php');

$prnno = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prnno = isset($_POST['prnno']) ? trim($_POST['prnno']) : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarship Section Get Action</title>
    <link rel="stylesheet" href="../../../style/stud_sect_action.css">
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && $prnno !== '') {
    echo "<div class='container'>";
    echo "<div class='prn-container'>";
    echo "<h3>PRN Number: " . htmlspecialchars($prnno) . "</h3>";

    $stmt = $conn->prepare("SELECT 
        st.studname AS stud_name,
        f.schlorship_form_status AS f_schlorship_form_status, 
        f.first_installment AS f_first_installment, 
        f.second_installment AS f_second_installment, 
        s.schlorship_form_status AS s_schlorship_form_status, 
        s.first_installment AS s_first_installment, 
        s.second_installment AS s_second_installment,
        t.schlorship_form_status AS t_schlorship_form_status, 
        t.first_installment AS t_first_installment, 
        t.second_installment AS t_second_installment,
        fy.schlorship_form_status AS fy_schlorship_form_status, 
        fy.first_installment AS fy_first_installment, 
        fy.second_installment AS fy_second_installment
        FROM students st
        LEFT JOIN First_year f ON st.prnno = f.prnno
        LEFT JOIN Second_year s ON st.prnno = s.prnno
        LEFT JOIN Third_year t ON st.prnno = t.prnno
        LEFT JOIN Final_year fy ON st.prnno = fy.prnno
        WHERE st.prnno = ?");

    $stmt->bind_param("s", $prnno);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        echo "<h3>NAME: " . htmlspecialchars($row['stud_name']) . "</h3>";

        echo "<div class='table-responsive'>
                <table class='fees-table'>
                <tr>
                    <th>Year</th>
                    <th>Scholarship Form Status</th>
                    <th>First Installment</th>
                    <th>Second Installment</th>
                </tr>
                <tr>
                    <td>First Year</td>
                    <td>" . htmlspecialchars($row['f_schlorship_form_status'] ?? '') . "</td>
                    <td>" . htmlspecialchars($row['f_first_installment'] ?? '') . "</td>
                    <td>" . htmlspecialchars($row['f_second_installment'] ?? '') . "</td>
                </tr>
                <tr>
                    <td>Second Year</td>
                    <td>" . htmlspecialchars($row['s_schlorship_form_status'] ?? '') . "</td>
                    <td>" . htmlspecialchars($row['s_first_installment'] ?? '') . "</td>
                    <td>" . htmlspecialchars($row['s_second_installment'] ?? '') . "</td>
                </tr>
                <tr>
                    <td>Third Year</td>
                    <td>" . htmlspecialchars($row['t_schlorship_form_status'] ?? '') . "</td>
                    <td>" . htmlspecialchars($row['t_first_installment'] ?? '') . "</td>
                    <td>" . htmlspecialchars($row['t_second_installment'] ?? '') . "</td>
                </tr>
                <tr>
                    <td>Final Year</td>
                    <td>" . htmlspecialchars($row['fy_schlorship_form_status'] ?? '') . "</td>
                    <td>" . htmlspecialchars($row['fy_first_installment'] ?? '') . "</td>
                    <td>" . htmlspecialchars($row['fy_second_installment'] ?? '') . "</td>
                </tr>
              </table>
            </div>";

        echo "<div class='button-container'>
                <form action='approve.php' method='POST'>
                    <input type='hidden' name='Approve' value='Approved'>
                    <input type='hidden' name='prnno' value='" . htmlspecialchars($prnno) . "'>
                    <button class='btn' type='submit' onclick='return confirmApprove()'>Approve</button>
                </form>
                <button class='reject-btn' onclick='showModal()'>Reject</button>
              </div>";
    } else {
        echo "<p>No records found for PRN Number: " . htmlspecialchars($prnno) . "</p>";
    }

    echo "</div></div>";
}
?>

<?php if ($prnno !== ''): ?>
<div class="modal" id="rejectModal">
    <div class="modal-content">
        <h3>Reason for Rejection</h3>
        <form action="reject.php" method="POST">
            <input type="text" id="rejectionReason" name="reject" placeholder="Enter the reason for rejection">
            <input type="hidden" name="prnno" value="<?php echo htmlspecialchars($prnno); ?>">
            <input type="hidden" name="Rejected" value="Rejected">
            <div class="button-container">
                <button class="submit-button" type="submit">Submit</button>
                <button class="cancel-button" onclick="closeModal(); return false;">Cancel</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<script>
function showModal() {
    document.getElementById('rejectModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('rejectModal').style.display = 'none';
}

function confirmApprove() {
    return confirm('Do you want to approve this request?');
}
</script>

</body>
</html>