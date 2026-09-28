<?php 
session_start();
include('../../db_conn.php');



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prnno = intval($_POST['prnno']);
    $table = $_POST['table'];
    $academic_status = $_POST['academic_status'];
    $SGPA = $_POST['SGPA'];
    $CGPA = $_POST['CGPA'];
    $exam_form_status = $_POST['exam_form_status'];

    // echo "$table";
    $sql = "UPDATE $table
            SET academic_status=?, SGPA=?, CGPA=?, exam_form_status=? 
            WHERE prnno=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sddsi", $academic_status, $SGPA, $CGPA, $exam_form_status, $prnno);
 
    if ($stmt->execute()) {
        echo "<script>alert('Record updated successfully'); window.location='result.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
