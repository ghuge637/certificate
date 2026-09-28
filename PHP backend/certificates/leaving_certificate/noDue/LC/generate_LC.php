<?php 
session_start();
include('../../../db_conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prnno = $_POST['prnno'];

    // Fetch student details along with leaving reason
    $sql = "SELECT p.*, l.reason, l.remark
            FROM previous_acadmic_details p 
            LEFT JOIN leaving_certificate l ON p.prnno = l.prnno
            WHERE p.prnno = $prnno";

    $check_result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($check_result) > 0) {
        while ($row = mysqli_fetch_assoc($check_result)) { 
            $name = $row['name'];
            $mother_name = $row['mother_name'];
            $religion = $row['relegion'];
            $caste = $row['cast'];
            $place_of_birth = $row['place_of_birth'];
            $nationality = $row['nationality'];
            $DOB = $row['DOB'];
            $DOB_in_words = $row['DOB_in_words'];
            $previous_institute = $row['previous_institute'];
            $DOA = $row['DOA'];
            
            $standard = $row['standerd'];
            $reason = $row['reason'];
            $remark = $row['remark'];

            $date = new DateTime($DOB);
            $DOB = $date->format('d-m-Y');

            $date = new DateTime($DOA);
            $DOA = $date->format('d-m-Y');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../style/style.css">
    <title>Transfer Certificate</title>
    <style>
        
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 210mm; /* A4 width */
            height: 270mm; /* A4 height */
            padding: 1mm;
            margin: auto;
            border: 1px solid black;
            box-sizing: border-box;
            /* margin-bottom: 30px; */
        }

        /* Title Styling */
        .title {
            margin-top: 170px; /* Reduced margin */
            text-align: center;
            font-size: 30px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px; /* Reduced margin */
            padding: 5px;
            border: 1px solid black;
            display: block;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
            background-color: rgba(234, 234, 234, 0.77);
            border-radius: 8px;
        }

        /* Table Styling */
        .table {
            font-size:16px;
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th, 
        .table td {
            border: 1px solid black;
            padding: 8px; /* Reduced padding */
            text-align: left;
        }

        .table td:first-child {
            width: 5%;
            text-align: center;
            font-weight: bold;
        }

        .table td:nth-child(2) {
            width: 30%; /* Broader second column */
        }

        .table td:nth-child(3) {
            width: 65%; /* Broader third column */
        }

        /* Footer Styling */
        .footer {
            margin-top: 55px; /* Reduced margin */
            text-align: right;
            font-size: 16px;
        }

        .footer p {
            margin: 0;
        }

        /* Bonafide Section */
        .principal {
            text-align: right;
            margin-top: 20px; /* Reduced margin */
            font-weight: bold;
            font-size: 16px;
        }

        .note {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 35px;
            text-align: center;
            font-size: 14px;
            margin-top: 10px; /* Reduced margin */
            border: 1px solid black;
            background-color: rgba(234, 234, 234, 0.77);
        }

        /* Print Styles */
        .print-button {
            text-align: center;
            margin: 20px 0;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .container {
                width: 100%;
                height: 100%;
                border: none;
            }

            .print-button {
                display: none;
            }
        }

        .stamp {
            font-size: 12px;
        }

        @media print {
            body {
                background-color: white;
                justify-content: flex-start;
            }

            .print-btn, .btn-container {
                display: none;
            }

        }
    </style>
</head>
<body>
    <div class="container">
        <?php if($remark != 'NO'){ 
            echo "<div class='title'>LEAVING CERTIFICATE</div>";
         }
          elseif($reason == 'Higher Studies'){ echo "<div class='title'>TRANSFER CERTIFICATE FOR MIGRATION</div>"; }
            else{
                echo "<div class='title'>TRANSFER CERTIFICATE</div>"; }?>
        
        <p><strong>Regd. No.</strong></p>

        <table class="table">
            <tr>
                <td>1</td>
                <td>Name of Student</td>
                <td><?php echo $name ?? ''; ?></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Mother’s Name</td>
                <td><?php echo $mother_name ?? ''; ?></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Religion & Caste with Sub-caste</td>
                <td><?php echo ($religion ?? '') . ', ' . ($caste ?? ''); ?></td>
            </tr>
            <tr>
                <td>4</td>
                <td>Place of Birth</td>
                <td><?php echo $place_of_birth ?? ''; ?></td>
            </tr>
            <tr>
                <td>5</td>
                <td>Nationality</td>
                <td><?php echo $nationality ?? ''; ?></td>
            </tr>
            <tr>
                <td>6</td>
                <td>Date of Birth in Figure</td>
                <td><?php echo $DOB ?? ''; ?></td>
            </tr>
            <tr>
                <td>7</td>
                <td>Date of Birth in Words</td>
                <td><?php echo $DOB_in_words ?? ''; ?></td>
            </tr>
            <tr>
                <td>8</td>
                <td>Last Institute</td>
                <td><?php echo $previous_institute ?? ''; ?></td>
            </tr>
            <tr>
                <td>9</td>
                <td>Date of Admission</td>
                <td><?php echo $DOA ?? ''; ?></td>
            </tr>
            <tr>
                <td>10</td>
                <td>Progress</td>
                <td>Good</td>
            </tr>
            <tr>
                <td>11</td>
                <td>Conduct</td>
                <td>Good</td>
            </tr>
            <tr>
                <td>12</td>
                <td>Date of Leaving Institute</td>
                <td><?php date_default_timezone_set('Asia/Kolkata');
                              echo date(" d-m-Y "); ?></td>
            </tr>
            <tr>
                <td>13</td>
                <td>Standard in which Studying</td>
                <td><?php echo $standard ?? ''; ?></td>
            </tr>
            <tr>
                <td>14</td>
                <td>Reason of Leaving Institute</td>
                <td><?php echo $reason ?? ''; ?></td>
            </tr>
            <?php if($remark != 'NO'){
                        echo"
                        <td>15</td>
                        <td>Remark</td>
                        <td>$remark</td>";
                    }
             ?>
        </table>

        <div>
            <p>This is certified that the above information is in accordance with the institute register.</p>
            <p>Date:<?php echo date(" d-m-Y "); ?></p>
        </div>

        <!-- Bonafide Section -->
        <div class="footer">
            <p style="margin-right: 50px; font-size:18px;"><b>Principal</b></p>
            <div class="stamp">
                <p>Keystone School of Engineering,</p>
                <p style="margin-right: 50px;">Pune - 412308</p>
            </div>
        </div>

        <div class="note">
            No change in any entry in this certificate shall be made except by the authority issuing it.
        </div>
    </div>

    <div>
        <center><button class="btn print-btn"  style="margin-bottom: 50px; margin-top: 50px;" onclick="window.print()">Print</button></center>
    </div>
</body>
</html>