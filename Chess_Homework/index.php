<?php

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
  }

  .white {
    background-color: #f0d9b5;
  }

  .black {
    background-color: #b58863;
  }

  .piece {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80%;
    height: auto;
    cursor: pointer;
    z-index: 1;
  }
</style>
</head>
<body>

<div class="chessboard">
HTML;

function generatePieceButton($color, $type, $row, $col) {
    return "<button class=\"piece $color\" draggable=\"true\" data-row=\"$row\" data-col=\"$col\" data-type=\"$type\">$type</button>";
}

for ($row = 8; $row >= 1; $row--) {
    for ($col = 'a'; $col <= 'h'; $col++) {
        $color = (($row + ord($col)) % 2 === 0) ? 'white' : 'black';
        $square_id = "{$col}{$row}"; // Unique ID for each square
        $html .= "<div class=\"square $color\" id=\"$square_id\">";
 
        if ($row === 1) {
            if ($col === 'a' || $col === 'h') {
                $html .= generatePieceButton('white', 'Rook', $row, $col);
            } elseif ($col === 'b' || $col === 'g') {
                $html .= generatePieceButton('white', 'Knight', $row, $col);
            } elseif ($col === 'c' || $col === 'f') {
                $html .= generatePieceButton('white', 'Bishop', $row, $col);
            } elseif ($col === 'd') {
                $html .= generatePieceButton('white', 'Queen', $row, $col);
            } elseif ($col === 'e') {
                $html .= generatePieceButton('white', 'King', $row, $col);
            }
        } elseif ($row === 2) {
            $html .= generatePieceButton('white', 'Pawn', $row, $col);
        }

        if ($row === 8) {
            if ($col === 'a' || $col === 'h') {
                $html .= generatePieceButton('black', 'Rook', $row, $col);
            } elseif ($col === 'b' || $col === 'g') {
                $html .= generatePieceButton('black', 'Knight', $row, $col);
            } elseif ($col === 'c' || $col === 'f') {
                $html .= generatePieceButton('black', 'Bishop', $row, $col);
            } elseif ($col === 'd') {
                $html .= generatePieceButton('black', 'Queen', $row, $col);
            } elseif ($col === 'e') {
                $html .= generatePieceButton('black', 'King', $row, $col);
            }
        } elseif ($row === 7) {
            $html .= generatePieceButton('black', 'Pawn', $row, $col);
        }
        $html .= "</div>";
    }
}

$html .= <<<HTML
</div>

<script src="script.js"></script>
</body>
</html>
HTML;

echo $html;

?>
