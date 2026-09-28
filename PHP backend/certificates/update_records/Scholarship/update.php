<?php 
session_start();
include('../../db_conn.php');



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prnno = intval($_POST['prnno']);
    $table = $_POST['table'];
    $total_fees = $_POST['total_fees'];
    $paid_fees = $_POST['paid_fees'];
    $schlorship_form_status = $_POST['schlorship_form_status'];
    $first_installment = $_POST['first_installment'];
    $second_installment = $_POST['second_installment'];
    // echo "$table";

    $sql = "UPDATE $table
            SET total_fees=?, paid_fees=?, schlorship_form_status=?, first_installment=?, second_installment=? 
            WHERE prnno=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iisiii', $total_fees, $paid_fees, $schlorship_form_status, $first_installment, $second_installment, $prnno);
 
    if ($stmt->execute()) {
        echo "<script>alert('Record updated successfully'); window.location='scholarship.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
