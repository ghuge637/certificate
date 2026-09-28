<?php session_start();

                        include('../../db_conn.php');
                        if ($_SERVER['REQUEST_METHOD'] == 'POST')
                    {
                        $reject = $_POST['reject'];
                        $newStatus = $_POST['Rejected'];
                        $prnno = $_POST['prnno'];

                        $sql = "UPDATE bonafide SET status = '$newStatus', Rejected = '$reject' WHERE prnno = $prnno";
                        // $sql = "UPDATE bonafide SET Rejected = '$reject' WHERE prnno = $prnno ";
                        $result = mysqli_query($conn, $sql); 
                        echo "<script>window.location.href = 'admin_portal.php';</script>";

                        

                    }

?>