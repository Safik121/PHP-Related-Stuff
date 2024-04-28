<?php
session_start();
$player = $_SESSION['player'];

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chess Board</title>
<style>
  .chessboard {
    display: grid;
    grid-template-columns: repeat(8, 50px);
    grid-template-rows: repeat(8, 50px);
  }

  .square {
    width: 50px;
    height: 50px;
    border: 1px solid black;
    position: relative;
    text-align: center;
    font-size: 24px;
  }

  .white {
    background-color: #f0d9b5;
  }

  .black {
    background-color: #b58863;
  }

  .piece {
    cursor: pointer;
    pointer-events: auto; /* Allow pointer events on piece */
    background-color: transparent; /* Make background transparent */
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
  }
</style>
</head>
<body>

<div class="chessboard">
HTML;

function generatePieceDiv($color, $type, $row, $col, $img) {
    return "<div class=\"piece $color\" draggable=\"true\" data-row=\"$row\" data-col=\"$col\" data-type=\"$type\">$img</div>";
}
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

$html .= <<<HTML
</div>

<script src="script.js"></script>
</body>
</html>
HTML;

echo $html;

?>

