<?php
session_start();

// Check if the username is set in the session
// if (isset($_SESSION['Username'])) {
//     $Username = $_SESSION['Username'];
// } else {
//     echo 'Username is not set.';
// }

include('../../../db_conn.php'); // Include the database connection file

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the request is for rejection
    if (isset($_POST['Rejected'])) {
        $reject = $_POST['reject']; // Get the rejection reason
        $prnno = $_POST['prnno']; // Get the PRN number

        // Update the `reject` column in the `leaving_certificate` table
        $sql = "UPDATE leaving_certificate SET reject = '$reject' , status = 'Rejected' WHERE prnno = $prnno";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "Error updating rejection reason: " . mysqli_error($conn);
        }
    }
    
}

// Redirect back to the main page
echo "<script>window.location.href = '../multi_section_actions.php';</script>";
?>