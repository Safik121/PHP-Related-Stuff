<?php
// Assuming you have a session started
session_start();

// Clear session data
$_SESSION = array();

// Destroy session
session_destroy();

// Send response
$response = array("success" => true, "message" => "Logout successful");
echo json_encode($response);
?>
