<?php 
session_start();

if (isset($_SESSION['desk_no'])) {
    $desk_no = $_SESSION['desk_no'];
} else {
    echo 'Username is not set.';
}
                        
include('../../../db_conn.php');
                    if ($_SERVER['REQUEST_METHOD'] == 'POST')
                    {
                        $newStatus = $_POST['Approve'];
                        $prnno = $_POST['prnno'];
                        $section = $_SESSION['desk_no'];
                        // echo $prnno ;
                        // echo  $section;

                        if($newStatus == 'Approved'){
                            $section = $section+1;

                            // echo $section ;

                            $sql = "UPDATE leaving_certificate SET section = '$section' , status = 'Pending' , reject = 'NO' WHERE prnno = $prnno";
                            $result = mysqli_query($conn, $sql); 
                        }

                        if (isset($_POST['failed'])) {
                            $failedValue = $_POST['reject']; // Get the failed value
                            $prnno = $_POST['prnno']; // Get the PRN number
                    
                            // Update the `remark` column in the `leaving_certificate` table
                            $sql = "UPDATE leaving_certificate SET remark = '$failedValue' WHERE prnno = $prnno";
                            $result = mysqli_query($conn, $sql);
                    
                            if (!$result) {
                                echo "Error updating failed value: " . mysqli_error($conn);
                            }
                        }

                    }
                    echo "<script>window.location.href = '../multi_section_actions.php';</script>";


?>