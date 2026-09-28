<?php
session_start();
include('../../db_conn.php');

$prnno =  $_SESSION['stud_id'];


// if (isset($_SERVER['Apply']) == 'POST')
if($_SERVER['REQUEST_METHOD']=='POST')
{
    $reason = $_POST['reason'];
    // echo $prnno;



        // SQL query to fetch student data
        $sql = "SELECT prnno, studname, studdob, branch , year FROM students WHERE `prnno` = $prnno ";

        // Execute the query and store the result
        $result = mysqli_query($conn, $sql);

        // Check if there are results
        if (mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {
                $prnno = $row['prnno'];
                $studname = $row['studname'] ;
                $studdob = $row['studdob'];
                $branch = $row['branch'] ;
                $year = $row['year'] ;

                                                            $check_sql = "SELECT * FROM bonafide WHERE prnno = '$prnno'";
                                                            $check_result = mysqli_query($conn, $check_sql);

                                                            if (mysqli_num_rows($check_result) > 0) {

                                                                echo "<script>alert('You already apply for bonafide');</script>";
                                                                echo "<script>window.location.href = 'apply.php';</script>";
                                                            } 
                                                            else {
                                                                    $sql = "INSERT INTO bonafide (prnno, reason)
                                                                        VALUES ('$prnno', '$reason')";
                                                                        $result = mysqli_query($conn, $sql); 

                                                                        echo "<script>alert('You apply successfully for bonafide');</script>";
                                                                        echo "<script>window.location.href = 'apply.php';</script>";
                                                                }
            }
                                                      
        } else{
            echo "<script>alert('You cannot apply for bonafide certificate because data is not available');</script>";
            echo "<script>window.location.href = 'apply.php';</script>";
        }


        // Close the connection
        mysqli_close($conn);
}
?>