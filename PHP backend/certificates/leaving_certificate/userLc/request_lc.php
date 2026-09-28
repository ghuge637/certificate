<?php
session_start();
include('../../db_conn.php');

$prnno =  $_SESSION['stud_id'];


if($_SERVER['REQUEST_METHOD']=='POST')
{
    // $section = $_POST['apply'];
    $reason = $_POST['reason'];
    // echo $section,$prnno;



$sql = "SELECT * FROM leaving_certificate WHERE prnno = '$prnno'";
$check_result = mysqli_query($conn, $sql);

if (mysqli_num_rows($check_result) > 0) {

    echo "<script>alert('You already apply for LC');</script>";
    echo "<script>window.location.href = 'apply_lc.php';</script>";
} 
else {
        $sql = "INSERT INTO  leaving_certificate (prnno, reason)
        VALUES ('$prnno', '$reason')";
        $result = mysqli_query($conn, $sql);
        
        echo "<script>alert('You apply successfully for LC');</script>";
        echo "<script>window.location.href = 'apply_lc.php';</script>";
    }
}

?>