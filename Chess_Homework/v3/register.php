<?php
// Assuming you have a database connection
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'chessdb';

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $wins = 0;
    $losses = 0;

    $stmt = $conn->prepare("INSERT INTO users (username, password, wins, losses) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $username, $hashed_password, $wins, $losses);
    
    if ($stmt->execute()) {
        // Retrieve user data after successful registration
        $userDataStmt = $conn->prepare("SELECT username, wins, losses FROM users WHERE username = ?");
        $userDataStmt->bind_param("s", $username);
        $userDataStmt->execute();
        $userDataStmt->bind_result($username, $wins, $losses);
        $userDataStmt->fetch();
        $userDataStmt->close();

        $response = array(
            "success" => true,
            "message" => "Registration successful",
            "username" => $username,
            "wins" => $wins,
            "losses" => $losses
        );
        echo json_encode($response);
    } else {
        $response = array("success" => false, "message" => "Registration failed");
        echo json_encode($response);
    }
    
    $stmt->close();
    $conn->close();
}
?>
