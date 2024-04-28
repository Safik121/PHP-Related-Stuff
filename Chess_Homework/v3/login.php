<?php
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'chessdb';

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    

    // Prepare and bind statement
    $stmt = $conn->prepare("SELECT password, wins, losses FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    
    // Execute the statement
    $stmt->execute();
    $stmt->bind_result($hashed_password, $wins, $losses);
    $stmt->fetch();
    
    // Verify password
    if (password_verify($password, $hashed_password)) {
        session_start();

        $_SESSION["username"] = $username;
        $response = array(
            "success" => true, 
            "message" => "Login successful", 
            "username" => $username, 
            "wins" => $wins, 
            "losses" => $losses
        );
        echo json_encode($response);
    } else {
        $response = array("success" => false, "message" => "Invalid username or password");
        echo json_encode($response);
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
