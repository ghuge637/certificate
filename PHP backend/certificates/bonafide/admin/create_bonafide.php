<?php
include('../../db_conn.php');

// $prn_number = 20221149;
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
                $prnno = $_POST['prnno'];

                $sql = "SELECT students.prnno, students.studname, students.studdob, students.branch, students.year, bonafide.reason, bonafide.status
                FROM bonafide 
                JOIN students ON bonafide.prnno = students.prnno 
                WHERE bonafide.prnno = '$prnno'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {
                    // $prnno = $row['prnno'];
                    $studname = $row['studname'] ;
                    $studdob = $row['studdob'];
                    $branch = $row['branch'] ;
                    $year = $row['year'] ;
                    $reason = $row['reason'];
                }
                // Example date in yyyy-mm-dd format

                // Create a DateTime object from the original date
                $date = new DateTime($studdob);

                // Format the date to dd-mm-yy format
                $formattedDate = $date->format('d-m-Y');

            }
}

// if ($year == 1)
// { $year= $year.'st';
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bonafide Certificate</title>
    <style>
        body {
                font-family: 'Times New Roman', serif;
                margin: 0;
                padding: 0;
                font-
                background-color: #eef2f7;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-height: 100vh;
            }

            .certificate-container {
                margin-top: 10px;
                margin-right: 5px;
                width: 210mm;
                height: 297mm;
                background: white;
                padding: 20mm 17.5mm 20mm 25mm;
                border: 2px solid #444;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.25);
                box-sizing: border-box;
            }

            .header {
                margin-top: 100px;
                display: flex;
                justify-content: space-between;
                font-size: 19px;
                margin-bottom: 20px;
            }

            .header span{
                display: inline-block;
                /* font-weight: bold; */
            }


            .title {
                text-align: center;
                margin-bottom: 30px;
                font-size: 22px;
                font-weight: bold;
                text-transform: uppercase;
                color: #333;
                border-radius: 10px;
                border: 3px solid #000;
                display: inline-block;
                padding: 10px 30px;
                letter-spacing: 2px;
            }

            .content {
                line-height: 1.8;
                font-size: 19px;
                text-align: justify;
                color: #222;
                margin-top: 20px;
            }

            .content span {
                display: inline-block;
                min-width: 150px;
                border-bottom: 1px solid #000;
                padding-bottom: 2px;
            }

            .footer {
                margin-top: 90px;
                text-align: right;
                font-size: 20px;
                /* font-weight: bold; */
                color: #333;
            }

            .footer p {
                margin: 0;
            }
            .stamp{
                font-size: 18px;
            }

            .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 35px;
            gap: 10px;
            margin-bottom: 100px;
        }

        .print-btn {
            flex: 1;
            padding: 10px;
            font-size: 16px;
            color: black;
            background-color:white;
            border: 1px solid rgb(0, 0, 0);
            border-radius: 5px;
            cursor: pointer;
            /* box-shadow: 0 4px 6px rgb(25, 86, 255); */
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
        }

        .print-btn:hover {
            background-color:rgb(255, 255, 255);
            box-shadow: 0 6px 10px rgb(0, 0, 0);
        }

        @media print {
            body {
                background-color: white;
                justify-content: flex-start;
            }

            .print-btn, .btn-container {
                display: none;
            }

            .certificate-container {
                border: none;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="header">
            <span>Ref. No: KSE/BONAFIDE/2024-25 / ________ </span>
            <span>Date: <?php date_default_timezone_set('Asia/Kolkata');
                              echo date(" d / m / Y "); ?></span>
        </div><br><br>
        <center><div class="title"><u>Bonafide Certificate</u></div></center>
        <div class="content">
            <p>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; This is to certify that Mr./Ms. <span>&nbsp;&nbsp;&nbsp;<b><?php echo "$studname"; ?></b>&nbsp;&nbsp;&nbsp;</span>, bonafide student of 
                Shalaka foundation’s Keystone School of Engineering, Pune - 412308, which is affiliated 
                to University of Pune, approved by AICTE New Delhi and recognized by Govt. of Maharashtra.
                He/She has been admitted for the Course Commencing in 2024-25 for <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo "$year"; ?></b></span>
                year in <span>&nbsp;&nbsp;&nbsp;<b><?php echo "$branch"; ?></b>&nbsp;&nbsp;&nbsp;</span> Engineering. As per our office records, his/her date of birth is <span>&nbsp;&nbsp;&nbsp;<b><?php echo "$formattedDate"; ?></b></span>.
            </p>
           
            <p>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; This certificate is issued on student demand for<span>&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo "$reason"; ?></b></span>.
            </p> 
        </div>
        <div class="footer">
            <p style="margin-right: 70px;"><b>Principal</b></p>
            <div class="stamp">
                <p>Keystone School of Engineering,</p>
                <p style="margin-right: 60px;">Pune - 412308</p>
            </div>
        </div>
    </div>

    <div class="btn-container">
        <button class="print-btn" onclick="window.print()">Print</button>
        <form action="process_complete.php" method="POST" style="flex: 1;">
            <input type="hidden" name="prnno" value="<?php echo "$prnno"; ?>">
            <input type="hidden" name="Completed" value="Completed">
            <button class="print-btn" type="submit">Complete</button>
        </form>
    </div>
</body>
</html>

