<?php
include('../../db_conn.php');

// $prn_number = 20221149;
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $prnno = $_POST['prnno'];
    $status;

    $sql = "SELECT* FROM bonafide Where prnno = $prnno";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) { 
            $prnno = $row['prnno'];
            $reason = $row['reason'];
            $status = $row['status'];
            // echo $status;
        }
        if( $status == 'Completed')
        {
            $sql = "INSERT INTO `distributed_bonafides` (prnno, reason) VALUES ( '$prnno', '$reason' ) ";
            $result = mysqli_query($conn, $sql);
        
            $sql = "DELETE FROM `bonafide` WHERE `prnno` = $prnno ";
            $result = mysqli_query($conn, $sql);
        }
        else{
        $sql = "DELETE FROM `bonafide` WHERE `prnno` = $prnno ";
        $result = mysqli_query($conn, $sql);
        }
    }
    

    echo "<script>window.location.href = 'admin_portal.php';</script>";

    // echo "$prnno" ;

}

?>


