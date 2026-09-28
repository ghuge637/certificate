<?php session_start();

                        include('../../db_conn.php');
                        // $prnno = 20221149;
                        if ($_SERVER['REQUEST_METHOD'] == 'POST')
                    {
                        $newStatus = $_POST['Completed'];
                        $prnno = $_POST['prnno'];
                       

                        $sql = "UPDATE bonafide SET status = '$newStatus' WHERE prnno = $prnno";
                        $result = mysqli_query($conn, $sql); 
                        
                        echo "<script>window.location.href = 'admin_portal.php';</script>";
                    }

?>