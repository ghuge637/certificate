<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaving certificate Request</title>
    <link rel="stylesheet" href="../../style/apply.css">
</head>
<style>
    
    /* Background image */
    .background {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('https://images.saymedia-content.com/.image/t_share/MTkyOTkyMzE2OTQ3MjQ0MjUz/website-background-templates.jpg') no-repeat center center;
      background-size: cover;
      z-index: -2;
    }

    /* Blur effect */
    .blur-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      background: rgba(255, 255, 255, 0.1);
      z-index: -1;
    }
</style>

<body>
  <div id="header-container"></div>  <!-- div for header content  -->
  <div class="background"></div>
  <div class="blur-overlay"></div>
              



                   <?php
                        include('../../db_conn.php');
                        $prnno =  $_SESSION['stud_id'];
                        // echo "$?

                        $check_sql = "SELECT * FROM leaving_certificate WHERE prnno = '$prnno'";
                        $check_result = mysqli_query($conn, $check_sql);

                        if (mysqli_num_rows($check_result) > 0) {

                            while ($row = mysqli_fetch_assoc($check_result)) {

                            switch ($row['section']) {
                                case 1:
                                    echo "<table  class='table'>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Department</th>
                                                            <th>Status</th>
                                                            <th>Reject</th>
                                                        </tr>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Student section</td>";
                                                            if($row['reject'] != 'NO'){
                                                            echo "<td>Rejected</td>
                                                            <td>".$row['reject']."</td>";} else{
                                                                echo "<td>Pending</td>
                                                            <td>".$row['reject']."</td>";
                                                            }
                                                        echo "</tr>
                                                    </table>";
                                            break;
                                case 2:
                                    echo "<table class='table'>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Department</th>
                                                            <th>Status</th>
                                                            <th>Remark</th>
                                                        </tr>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Student Section</td>
                                                            <td>Approve</td>
                                                            <td>NO</td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>Scholership</td>";
                                                            if($row['reject'] != 'NO'){
                                                            echo "<td>Rejected</td>
                                                            <td>".$row['reject']."</td>";} else{
                                                                echo "<td>Pending</td>
                                                            <td>".$row['reject']."</td>";
                                                            }
                                                        echo "</tr>
                                                    </table>";
                                    break;
                                case 3:
                                    echo "<table class='table'>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Department</th>
                                                            <th>Status</th>
                                                            <th>Remark</th>
                                                        </tr>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Student Section</td>
                                                            <td>Approve</td>
                                                            <td>NO</td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>Scholership section</td>
                                                            <td>Approve</td>
                                                            <td>NO</td>
                                                        </tr>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>Account section</td>";
                                                            if($row['reject'] != 'NO'){
                                                            echo "<td>Rejected</td>
                                                            <td>".$row['reject']."</td>";} else{
                                                                echo "<td>Pending</td>
                                                            <td>".$row['reject']."</td>";
                                                            }
                                                        echo "</tr>
                                                    </table>";
                                    break;
                                case 4:
                                    echo "<table class='table'>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Department</th>
                                                            <th>Status</th>
                                                            <th>Remark</th>
                                                        </tr>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Student Section</td>
                                                            <td>Approve</td>
                                                            <td>NO</td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>Scholership section</td>
                                                            <td>Approve</td>
                                                            <td>NO</td>
                                                        </tr>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>Account</td>
                                                            <td>Approve</td>
                                                            <td>NO</td>
                                                        </tr>
                                                        <tr>
                                                            <td>4</td>
                                                            <td>Library</td>";
                                                            if($row['reject'] != 'NO'){
                                                            echo "<td>Rejected</td>
                                                            <td>".$row['reject']."</td>";} else{
                                                                echo "<td>Pending</td>
                                                            <td>".$row['reject']."</td>";
                                                            }
                                                        echo "</tr>
                                                    </table>";
                                    break;
                                case 5:
                                    echo "<table class='table'>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Department</th>
                                                            <th>Status</th>
                                                            <th>Remark</th>
                                                        </tr>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Student Section</td>
                                                            <td>Approve</td>
                                                            <td>NO</td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>Scholership section</td>
                                                            <td>Approve</td>
                                                            <td>NO</td>
                                                        </tr>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>Account</td>
                                                            <td>Approve</td>
                                                            <td>NO</td>
                                                        </tr>
                                                        <tr>
                                                            <td>4</td>
                                                            <td>Library</td>
                                                            <td>Approve</td>
                                                            <td>NO</td>
                                                        </tr>
                                                        <tr>
                                                            <td>5</td>
                                                            <td>Placement</td>";
                                                            if($row['reject'] != 'NO'){
                                                            echo "<td>Rejected</td>
                                                            <td>".$row['reject']."</td>";} else{
                                                                echo "<td>Pending</td>
                                                            <td>".$row['reject']."</td>";
                                                            }
                                                        echo "</tr>
                                                    </table>";
                                    break;

                                    case 6:
                                        echo "<table class='table'>
                                                            <tr>
                                                                <th>Sr. No.</th>
                                                                <th>Department</th>
                                                                <th>Status</th>
                                                                <th>Remark</th>
                                                            </tr>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>Student Section</td>
                                                                <td>Approve</td>
                                                                <td>NO</td>
                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td>Scholership section</td>
                                                                <td>Approve</td>
                                                                <td>NO</td>
                                                            </tr>
                                                            <tr>
                                                                <td>3</td>
                                                                <td>Account</td>
                                                                <td>Approve</td>
                                                                <td>NO</td>
                                                            </tr>
                                                            <tr>
                                                                <td>4</td>
                                                                <td>Library</td>
                                                                <td>Approve</td>
                                                                <td>NO</td>
                                                            </tr>
                                                            <tr>
                                                                <td>5</td>
                                                                <td>Placement</td>
                                                                <td>Approve</td>
                                                                <td>NO</td>
                                                            </tr>
                                                            <tr>
                                                                <td>6</td>
                                                                <td>Workshop</td>";
                                                                if($row['reject'] != 'NO'){
                                                                echo "<td>Rejected</td>
                                                                <td>".$row['reject']."</td>";} else{
                                                                    echo "<td>Pending</td>
                                                                <td>".$row['reject']."</td>";
                                                                }
                                                            echo "</tr>
                                                        </table>";
                                        break;

                                        case 7:
                                            echo "<table class='table'>
                                                                <tr>
                                                                    <th>Sr. No.</th>
                                                                    <th>Department</th>
                                                                    <th>Status</th>
                                                                    <th>Remark</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td>Student Section</td>
                                                                    <td>Approve</td>
                                                                    <td>NO</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2</td>
                                                                    <td>Scholership section</td>
                                                                    <td>Approve</td>
                                                                    <td>NO</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>3</td>
                                                                    <td>Account</td>
                                                                    <td>Approve</td>
                                                                    <td>NO</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>4</td>
                                                                    <td>Library</td>
                                                                    <td>Approve</td>
                                                                    <td>NO</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>5</td>
                                                                    <td>Placement</td>
                                                                    <td>Approve</td>
                                                                    <td>NO</td>
                                                                </tr>
                                                                 <tr>
                                                                    <td>6</td>
                                                                    <td>Workshop</td>
                                                                    <td>Approve</td>
                                                                    <td>NO</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>7</td>
                                                                    <td>Compute HOD</td>";
                                                                    if($row['reject'] != 'NO'){
                                                                    echo "<td>Rejected</td>
                                                                    <td>".$row['reject']."</td>";} else{
                                                                        echo "<td>Pending</td>
                                                                    <td>".$row['reject']."</td>";
                                                                    }
                                                                echo "</tr>
                                                            </table>";
                                            break;

                                        case 8:
                                            echo "<table class='table'>
                                                                <tr>
                                                                    <th>Sr. No.</th>
                                                                    <th>Department</th>
                                                                    <th>Status</th>
                                                                    <th>Remark</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td>Student Section</td>
                                                                    <td>Approve</td>
                                                                    <td>NO</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2</td>
                                                                    <td>Scholership section</td>
                                                                    <td>Approve</td>
                                                                    <td>NO</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>3</td>
                                                                    <td>Account</td>
                                                                    <td>Approve</td>
                                                                    <td>NO</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>4</td>
                                                                    <td>Library</td>
                                                                    <td>Approve</td>
                                                                    <td>NO</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>5</td>
                                                                    <td>Placement</td>
                                                                    <td>Approve</td>
                                                                    <td>NO</td>
                                                                </tr>
                                                                 <tr>
                                                                    <td>6</td>
                                                                    <td>Workshop</td>
                                                                    <td>Approve</td>
                                                                    <td>NO</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>7</td>
                                                                    <td>Computer HOD</td>
                                                                    <td>Approve</td>
                                                                    <td>NO</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>8</td>
                                                                    <td>E&TC HOD</td>";
                                                                    if($row['reject'] != 'NO'){
                                                                    echo "<td>Rejected</td>
                                                                    <td>".$row['reject']."</td>";} else{
                                                                        echo "<td>Pending</td>
                                                                    <td>".$row['reject']."</td>";
                                                                    }
                                                                echo "</tr>
                                                            </table>";
                                            break;

                                            case 9:
                                                echo "<table class='table'>
                                                                    <tr>
                                                                        <th>Sr. No.</th>
                                                                        <th>Department</th>
                                                                        <th>Status</th>
                                                                        <th>Remark</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>1</td>
                                                                        <td>Student Section</td>
                                                                        <td>Approve</td>
                                                                        <td>NO</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>2</td>
                                                                        <td>Scholership section</td>
                                                                        <td>Approve</td>
                                                                        <td>NO</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>Account</td>
                                                                        <td>Approve</td>
                                                                        <td>NO</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>4</td>
                                                                        <td>Library</td>
                                                                        <td>Approve</td>
                                                                        <td>NO</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>5</td>
                                                                        <td>Placement</td>
                                                                        <td>Approve</td>
                                                                        <td>NO</td>
                                                                    </tr>
                                                                     <tr>
                                                                        <td>6</td>
                                                                        <td>Workshop</td>
                                                                        <td>Approve</td>
                                                                        <td>NO</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>7</td>
                                                                        <td>Computer HOD</td>
                                                                        <td>Approve</td>
                                                                        <td>NO</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>8</td>
                                                                        <td>E&TC HOD</td>
                                                                        <td>Approve</td>
                                                                        <td>NO</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>9</td>
                                                                        <td>AI&DS HOD</td>";
                                                                        if($row['reject'] != 'NO'){
                                                                        echo "<td>Rejected</td>
                                                                        <td>".$row['reject']."</td>";} else{
                                                                            echo "<td>Pending</td>
                                                                        <td>".$row['reject']."</td>";
                                                                        }
                                                                    echo "</tr>
                                                                </table>";
                                                break;

                                                case 10:
                                                    echo "<table class='table'>
                                                                        <tr>
                                                                            <th>Sr. No.</th>
                                                                            <th>Department</th>
                                                                            <th>Status</th>
                                                                            <th>Remark</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td>Student Section</td>
                                                                            <td>Approve</td>
                                                                            <td>NO</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td>Scholership section</td>
                                                                            <td>Approve</td>
                                                                            <td>NO</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>3</td>
                                                                            <td>Account</td>
                                                                            <td>Approve</td>
                                                                            <td>NO</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>4</td>
                                                                            <td>Library</td>
                                                                            <td>Approve</td>
                                                                            <td>NO</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>5</td>
                                                                            <td>Placement</td>
                                                                            <td>Approve</td>
                                                                            <td>NO</td>
                                                                        </tr>
                                                                         <tr>
                                                                            <td>6</td>
                                                                            <td>Workshop</td>
                                                                            <td>Approve</td>
                                                                            <td>NO</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>7</td>
                                                                            <td>Computer HOD</td>
                                                                            <td>Approve</td>
                                                                            <td>NO</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>8</td>
                                                                            <td>E&TC HOD</td>
                                                                            <td>Approve</td>
                                                                            <td>NO</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>9</td>
                                                                            <td>AI&DS HOD</td>
                                                                            <td>Approve</td>
                                                                            <td>NO</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>10</td>
                                                                            <td>Mechanical HOD</td>";
                                                                            if($row['reject'] != 'NO'){
                                                                            echo "<td>Rejected</td>
                                                                            <td>".$row['reject']."</td>";} else{
                                                                                echo "<td>Pending</td>
                                                                            <td>".$row['reject']."</td>";
                                                                            }
                                                                        echo "</tr>
                                                                    </table>";
                                                    break;

                                                    case 11:
                                                        echo "<table class='table'>
                                                                            <tr>
                                                                                <th>Sr. No.</th>
                                                                                <th>Department</th>
                                                                                <th>Status</th>
                                                                                <th>Remark</th>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>1</td>
                                                                                <td>Student Section</td>
                                                                                <td>Approve</td>
                                                                                <td>NO</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>2</td>
                                                                                <td>Scholership section</td>
                                                                                <td>Approve</td>
                                                                                <td>NO</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>3</td>
                                                                                <td>Account</td>
                                                                                <td>Approve</td>
                                                                                <td>NO</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>4</td>
                                                                                <td>Library</td>
                                                                                <td>Approve</td>
                                                                                <td>NO</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>5</td>
                                                                                <td>Placement</td>
                                                                                <td>Approve</td>
                                                                                <td>NO</td>
                                                                            </tr>
                                                                             <tr>
                                                                                <td>6</td>
                                                                                <td>Workshop</td>
                                                                                <td>Approve</td>
                                                                                <td>NO</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>7</td>
                                                                                <td>Computer HOD</td>
                                                                                <td>Approve</td>
                                                                                <td>NO</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>8</td>
                                                                                <td>E&TC HOD</td>
                                                                                <td>Approve</td>
                                                                                <td>NO</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>9</td>
                                                                                <td>AI&DS HOD</td>
                                                                                <td>Approve</td>
                                                                                <td>NO</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>10</td>
                                                                                <td>Mechanical HOD</td>
                                                                                <td>Approve</td>
                                                                                <td>NO</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>11</td>
                                                                                <td>Principal</td>";
                                                                                if($row['reject'] != 'NO'){
                                                                                echo "<td>Rejected</td>
                                                                                <td>".$row['reject']."</td>";} else{
                                                                                    echo "<td>Pending</td>
                                                                                <td>".$row['reject']."</td>";
                                                                                }
                                                                            echo "</tr>
                                                                        </table>";
                                                        break;

                                                        case 12:
                                                            echo "<table class='table'>
                                                                                <tr>
                                                                                    <th>Sr. No.</th>
                                                                                    <th>Department</th>
                                                                                    <th>Status</th>
                                                                                    <th>Remark</th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>1</td>
                                                                                    <td>Student Section</td>
                                                                                    <td>Approve</td>
                                                                                    <td>NO</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>2</td>
                                                                                    <td>Scholership section</td>
                                                                                    <td>Approve</td>
                                                                                    <td>NO</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>3</td>
                                                                                    <td>Account</td>
                                                                                    <td>Approve</td>
                                                                                    <td>NO</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>4</td>
                                                                                    <td>Library</td>
                                                                                    <td>Approve</td>
                                                                                    <td>NO</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>5</td>
                                                                                    <td>Placement</td>
                                                                                    <td>Approve</td>
                                                                                    <td>NO</td>
                                                                                </tr>
                                                                                 <tr>
                                                                                    <td>6</td>
                                                                                    <td>Workshop</td>
                                                                                    <td>Approve</td>
                                                                                    <td>NO</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>7</td>
                                                                                    <td>Computer HOD</td>
                                                                                    <td>Approve</td>
                                                                                    <td>NO</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>8</td>
                                                                                    <td>E&TC HOD</td>
                                                                                    <td>Approve</td>
                                                                                    <td>NO</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>9</td>
                                                                                    <td>AI&DS HOD</td>
                                                                                    <td>Approve</td>
                                                                                    <td>NO</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>10</td>
                                                                                    <td>Mechanical HOD</td>
                                                                                    <td>Approve</td>
                                                                                    <td>NO</td>
                                                                                </tr>
<tr>
                                                                                    <td>11</td>
                                                                                    <td>Principal</td>
                                                                                    <td>Approve</td>
                                                                                    <td>NO</td>
                                                                                </tr>
                                                                            </table>";

                                                                            echo" <p style='margin-top:30px;background-color: transparent; border:2px solid black; border-radius:5px;
                                                                             justify-content:center; height:40px; display:flex; align-items:center;'>Your LC is generated Please Go and collect it from Office";
                                                            break;
                            }
                        }
                        
                        
                        }else{
                            ?>

<center><div class="container">
<div class="select_reason">
        <form action="request_lc.php" method="POST">
            <label for="reason" style="font-size:20px; margin-bottom:5px;">Select Reason for Leving Certificate</label>
            <select id="reason" name="reason" required>
                <option value="" disabled selected>Select</option>
                <option value="Transfer to Another College">Moving to another institution.</option>
                <option value="Higher Studies">Admission into a university or specialized course.</option>
                <option value="Family Relocation">Moving due to family reasons. </option>
                <option value="Health Issues">Medical concerns preventing further studies.</option>
                <option value="Financial Constraints"> Inability to afford fees or expenses.</option>
                <option value="Completion of Studies">Successfully finishing the program.</option> 
            </select>
            <div class="button-container">
            <input type="hidden" name="apply"><button class="apply-button" type="submit">Apply</button></input>
                <a href="../../user_page.php">
                    <button type="button" class="cancel-button">Cancel</button>
                </a>
            </div>
        </form>
        </div>
        </div>
        </center>


<?php
                        }
                    ?>

</div>
<script>
      function confirmDelete() {
        // Show a confirmation dialog using single quotes for the string
        return confirm('Are you sure you want to delete this request?');
        // If the user clicks 'OK', the form will be submitted
        // If the user clicks 'Cancel', the form submission will be stopped
    }       
    </script>

    
       <!-- show header using below script fetch code from header.html of logout folder -->
<script>
    function loadHeader() {
        fetch('../../logout/header.html') // adjust path if needed
        .then(response => response.text())
        .then(data => {
            document.getElementById('header-container').innerHTML = data;
        })
        .catch(error => console.error('Header load error:', error));
    }
    loadHeader();
</script>


<!-- bellow script for perform logout operation basically its 
 fetch logout code from logout.php file and perform operation -->

<script>
  function logout() {
    fetch('../../logout/logout.php', {
      method: 'POST',
      credentials: 'include'
    })
    .then(response => {
      if (response.ok) {
        window.location.href = '../../index.php';
      } else {
        alert("Logout failed");
      }
    })
    .catch(error => console.error('Logout error:', error));
  }
</script>
</body>
</html>