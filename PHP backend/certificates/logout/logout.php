<?php
session_start();
session_unset();   // remove all session variables
session_destroy(); // destroy the session

http_response_code(200); // tell JavaScript logout was successful
exit();
?>
