<?php 
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ready LC Table</title>
    <link rel="stylesheet" href="../../../style/style.css">
    <style>
        .history-btn {
            position: absolute;
            top: 20px;
            left: 20px;
        }
    </style>
</head>
<body>

<!-- History Button Positioned at the Top Left -->
<div class="history-btn" >
    <a href="distributed_lc.php"><button class="btn">History</button></a>
</div>

<?php 
include('../../../db_conn.php');

$section = 12;
$sql = "SELECT lc.*, s.studname FROM leaving_certificate lc
        JOIN students s ON lc.prnno = s.prnno
        WHERE lc.section = $section";
$check_result = mysqli_query($conn, $sql);

if (mysqli_num_rows($check_result) > 0) {
    echo "<div class='table-container' style='margin-top: 50px;'>
            <table class='table table-striped table-bordered'>
                <thead class='table-dark text-center'>
                    <tr>
                        <th>PRN No</th>
                        <th>Student Name</th>
                        <th>LC</th>
                    </tr>
                </thead>
                <tbody class='text-center'>";
    
    while ($row = mysqli_fetch_assoc($check_result)) { 
        echo "<tr>
                <td>{$row['prnno']}</td>
                <td>{$row['studname']}</td>
                <td>
                    <form action='generate_LC.php' method='POST' style='display: inline;'>
                        <input type='hidden' name='prnno' value='{$row['prnno']}'>
                        <button class='btn' type='submit'>View</button>
                    </form>
                    <button class='btn' onclick='showModal()'>Completed</button>
                </td>
              </tr>";
    }
    
    echo "</tbody></table></div>";
} else {
    echo "<div class='text-center'><h5>No records found.</h5></div>";
}
?>

</body>
</html>
