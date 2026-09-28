<?php 
session_start();
if (isset($_SESSION['desk_no'])) {
    $desk_no = $_SESSION['desk_no'];
} else {
    echo 'Username is not set.';
}

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requests for LC</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
            <!-- <form action="filter.php" method="POST" class="filter">
                <div class="filter-container">
                    
                    <select name="status" required>
                        <option value="" disabled selected>Select</option>
                        <option value="Rejected">Short list based on Rejected</option>
                        <option value="Approved">Short list based on Approved</option>
                    </select>

                    <button type="submit" class="btn" name="Apply">Filter</button> 
                </div>
            </form> -->

    <div class="container">
        <div class="title">Requests for LC</div>

                                <?php

                                include('../../db_conn.php');
                                // echo $desk_no;
                                $status = 'Rejected';
                                
                                // if (isset($_POST['status']) && !empty($_POST['status'])) { //if condition impliment for impliment filter
                                //     $status = $_POST['status'];
                                // }

                                // $sql = "SELECT * FROM leaving_certificate Where section = '$desk_no'"; 
                                $sql = "SELECT students.studname, leaving_certificate.prnno, leaving_certificate.status
                                FROM leaving_certificate 
                                JOIN students ON leaving_certificate.prnno = students.prnno 
                                WHERE section = '$desk_no' AND status = '$status'";
                                $check_result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($check_result) > 0) {



                                    echo "<div class='table-wrapper'><table class='table'>
                                            <thead>
                                                <tr>
                                                    <th>PRN No</th>
                                                    <th>Student Name</th>
                                                    <th>Status</th>
                                                    <th>Get Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>";
                                    while ($row = mysqli_fetch_assoc($check_result)) { 
                                        // if($row['reject'] == 'NO'){ echo "hello";}
                                        $prnno = $row['prnno'];
                                        echo "<tr>
                                                <td>" . $row['prnno'] . "</td>
                                                <td>" . $row['studname'] . "</td>
                                                <td>" . $row['status'] . "</td>";   
                                                                                                        switch ($desk_no) {
                                                                                                            
                                                                                                            case 1:
                                                                                                                echo "<td>
                                                                                                                            <form action='actions/stud_sect_action.php' method='POST'>
                                                                                                                                <input type='hidden' name='prnno' value='$prnno'>
                                                                                                                                <button class='btn'type='submit'>View</button>
                                                                                                                            </form>
                                                                                                                        </td>";
                                                                                                                break;
                                                                                                            case 2:
                                                                                                                echo "<td>
                                                                                                                            <form action='actions/scShip_section_action.php' method='POST'>
                                                                                                                                <input type='hidden' name='prnno' value='$prnno'>
                                                                                                                                <button class='btn'type='submit'>View</button>
                                                                                                                            </form>
                                                                                                                        </td>";
                                                                                                                break;
                                                                                                    
                                                                                                            case 3:
                                                                                                                echo "<td>
                                                                                                                            <form action='actions/account_section_action.php' method='POST'>
                                                                                                                                <input type='hidden' name='prnno' value='$prnno'>
                                                                                                                                <button class='btn' type='submit'>View</button>
                                                                                                                            </form>
                                                                                                                        </td>";
                                                                                                                break;
                                                                                                    
                                                                                                            case 4:
                                                                                                                echo "<td>
                                                                                                                            <form action='actions/library_section_action.php' method='POST'>
                                                                                                                                <input type='hidden' name='prnno' value='$prnno'>
                                                                                                                                <button class='btn' type='submit'>View</button>
                                                                                                                            </form>
                                                                                                                        </td>";
                                                                                                                break;
                                                                                                    
                                                                                                            case 5:
                                                                                                                echo "<td>
                                                                                                                            <form action='actions/placement_section_action.php' method='POST'>
                                                                                                                                <input type='hidden' name='prnno' value='$prnno'>
                                                                                                                                <button class='btn' type='submit'>View</button>
                                                                                                                            </form>
                                                                                                                        </td>";
                                                                                                                break;
                                                                                                    
                                                                                                            case 6:
                                                                                                                echo "<td>
                                                                                                                <form action='actions/work_shop_action.php' method='POST'>
                                                                                                                    <input type='hidden' name='prnno' value='$prnno'>
                                                                                                                    <button class='btn' type='submit'>View</button>
                                                                                                                </form>
                                                                                                            </td>";
                                                                                                    break;
                                                                                        
                                                                                                    
                                                                                                            case 7:
                                                                                                                echo "<td>
                                                                                                                        <form action='actions/comp_HOD_action.php' method='POST'>
                                                                                                                            <input type='hidden' name='prnno' value='$prnno'>
                                                                                                                            <button class='btn' type='submit'>View</button>
                                                                                                                        </form>
                                                                                                                    </td>";
                                                                                                            break;
                                                                                                    
                                                                                                            case 8:
                                                                                                                echo "<td>
                                                                                                                                <form action='actions/EnTc_HOD_action.php' method='POST'>
                                                                                                                                    <input type='hidden' name='prnno' value='$prnno'>
                                                                                                                                    <button class='btn' type='submit'>View</button>
                                                                                                                                </form>
                                                                                                                            </td>";
                                                                                                                    break;
                                                                                                    
                                                                                                            case 9:
                                                                                                                echo "<td>
                                                                                                                                <form action='actions/AiDs_HOD_action.php' method='POST'>
                                                                                                                                    <input type='hidden' name='prnno' value='$prnno'>
                                                                                                                                    <button class='btn' type='submit'>View</button>
                                                                                                                                </form>
                                                                                                                            </td>";
                                                                                                                    break;
                                                                                                    
                                                                                                            case 10:
                                                                                                                echo "<td>
                                                                                                                        <form action='actions/mech_HOD_action.php' method='POST'>
                                                                                                                            <input type='hidden' name='prnno' value='$prnno'>
                                                                                                                            <button class='btn' type='submit'>View</button>
                                                                                                                        </form>
                                                                                                                    </td>";
                                                                                                            break;
                                                                                                    
                                                                                                            case 11:
                                                                                                                echo "<td>
                                                                                                                            <form action='actions/principal_action.php' method='POST'>
                                                                                                                                <input type='hidden' name='prnno' value='$prnno'>
                                                                                                                                <button class='btn' type='submit'>View</button>
                                                                                                                            </form>
                                                                                                                        </td>";
                                                                                                                break;
                                                                                                        }
                                                
                                                 
                                                echo "</tr>";
                                    }
                                    echo "</tbody></table></div>";
                                } else { echo "No Rejected requests for LC";}
            
                                ?>

</div>

</body>
</html>

