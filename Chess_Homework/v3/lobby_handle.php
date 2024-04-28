<?php
session_start();

// Assuming you have a database connection
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'chessdb';

$_SESSION['player'] = null;

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted (assuming you're using AJAX to send the request)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    
    // Check if the user is already in a lobby
    $stmt = $conn->prepare("SELECT * FROM lobbies WHERE plrone = ? OR plrtwo = ?");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // User is already in a lobby, return error message
        $response = array("success" => false, "message" => "You are already in a lobby.");
        echo json_encode($response);
        return; // Return early
    } else {
        // Look for an available lobby
        $stmt = $conn->prepare("SELECT * FROM lobbies WHERE plrtwo IS NULL");
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Found an available lobby, join it
            $row = $result->fetch_assoc();
            $lobbyId = $row['id'];
            
            $stmt = $conn->prepare("UPDATE lobbies SET plrtwo = ? WHERE id = ?");
            $stmt->bind_param("si", $username, $lobbyId);
            $stmt->execute();
            $_SESSION['player'] = 2;
        } else {
            // No available lobbies found, create a new one
            $stmt = $conn->prepare("INSERT INTO lobbies (plrone) VALUES (?)");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            
            $lobbyId = $conn->insert_id;
            $_SESSION['player'] = 1;
        }
    }
    
    // Return lobby information along with chessboard HTML
    $response = array(
        "success" => true,
        "lobbyId" => $lobbyId
    );
    echo json_encode($response);
}

function generatePieceDiv($color, $type, $row, $col, $img) {
    return "<div class=\"piece $color\" draggable=\"true\" data-row=\"$row\" data-col=\"$col\" data-type=\"$type\">$img</div>";
}

function generateChessboard($player) {
    $html = '<div class="chessboard">';

    if ($player === 2) {
        // Invert the board for the second player
        for ($row = 8; $row >= 1; $row--) {
            for ($col = 'a'; $col <= 'h'; $col++) {
                $color = (($row + ord($col)) % 2 === 0) ? 'white' : 'black';
                $square_id = "{$col}{$row}"; // Unique ID for each square
                $html .= "<div class=\"square $color\" id=\"$square_id\">";
         
                if ($row === 1) {
                    if ($col === 'a' || $col === 'h') {
                        $html .= generatePieceDiv('white', 'Rook', $row, $col, "♖");
                    } elseif ($col === 'b' || $col === 'g') {
                        $html .= generatePieceDiv('white', 'Knight', $row, $col, "♘");
                    } elseif ($col === 'c' || $col === 'f') {
                        $html .= generatePieceDiv('white', 'Bishop', $row, $col, "♗");
                    } elseif ($col === 'd') {
                        $html .= generatePieceDiv('white', 'Queen', $row, $col, "♕");
                    } elseif ($col === 'e') {
                        $html .= generatePieceDiv('white', 'King', $row, $col, "♔");
                    }
                } elseif ($row === 2) {
                    $html .= generatePieceDiv('white', 'Pawn', $row, $col, "♙");
                }
        
                if ($row === 8) {
                    if ($col === 'a' || $col === 'h') {
                        $html .= generatePieceDiv('black', 'Rook', $row, $col, "♜");
                    } elseif ($col === 'b' || $col === 'g') {
                        $html .= generatePieceDiv('black', 'Knight', $row, $col, "♞");
                    } elseif ($col === 'c' || $col === 'f') {
                        $html .= generatePieceDiv('black', 'Bishop', $row, $col, "♝");
                    } elseif ($col === 'd') {
                        $html .= generatePieceDiv('black', 'Queen', $row, $col, "♛");
                    } elseif ($col === 'e') {
                        $html .= generatePieceDiv('black', 'King', $row, $col, "♚");
                    }
                } elseif ($row === 7) {
                    $html .= generatePieceDiv('black', 'Pawn', $row, $col, "♟︎");
                }
                $html .= "</div>";
            }
        }
    } else {
        // Generate the board normally for the first player
        for ($row = 1; $row <= 8; $row++) {
            for ($col = 'a'; $col <= 'h'; $col++) {
                $color = (($row + ord($col)) % 2 === 0) ? 'white' : 'black';
                $square_id = "{$col}{$row}"; // Unique ID for each square
                $html .= "<div class=\"square $color\" id=\"$square_id\">";
         
                if ($row === 1) {
                    if ($col === 'a' || $col === 'h') {
                        $html .= generatePieceDiv('white', 'Rook', $row, $col, "♖");
                    } elseif ($col === 'b' || $col === 'g') {
                        $html .= generatePieceDiv('white', 'Knight', $row, $col, "♘");
                    } elseif ($col === 'c' || $col === 'f') {
                        $html .= generatePieceDiv('white', 'Bishop', $row, $col, "♗");
                    } elseif ($col === 'd') {
                        $html .= generatePieceDiv('white', 'Queen', $row, $col, "♕");
                    } elseif ($col === 'e') {
                        $html .= generatePieceDiv('white', 'King', $row, $col, "♔");
                    }
                } elseif ($row === 2) {
                    $html .= generatePieceDiv('white', 'Pawn', $row, $col, "♙");
                }
        
                if ($row === 8) {
                    if ($col === 'a' || $col === 'h') {
                        $html .= generatePieceDiv('black', 'Rook', $row, $col, "♜");
                    } elseif ($col === 'b' || $col === 'g') {
                        $html .= generatePieceDiv('black', 'Knight', $row, $col, "♞");
                    } elseif ($col === 'c' || $col === 'f') {
                        $html .= generatePieceDiv('black', 'Bishop', $row, $col, "♝");
                    } elseif ($col === 'd') {
                        $html .= generatePieceDiv('black', 'Queen', $row, $col, "♛");
                    } elseif ($col === 'e') {
                        $html .= generatePieceDiv('black', 'King', $row, $col, "♚");
                    }
                } elseif ($row === 7) {
                    $html .= generatePieceDiv('black', 'Pawn', $row, $col, "♟︎");
                }
                $html .= "</div>";
            }
        }
    }

    $html .= '</div>';
    return $html;
}
?>
