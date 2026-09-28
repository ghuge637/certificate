<?php
session_start();
include('../../../db_conn.php');

// Fetch records from the table
$sql = "SELECT prnno, reason, status FROM distributed_leaving_certificates";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distributed Leaving Certificates</title>
    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
     <link rel="stylesheet" href="../../../style/style.css">
</head>
<body>
    <h1>Distributed Leaving Certificates</h1>

    <table class="table">
        <thead>
            <tr>
                <th>PRN No</th>
                <th>Reason</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['prnno']}</td>
                            <td>{$row['reason']}</td>
                            <td>{$row['status']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php $conn->close(); ?>

</body>
</html>
