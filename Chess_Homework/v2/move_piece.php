<?php

$fromRow = intval($_POST['fromRow']);
$fromCol = $_POST['fromCol'];
$toRow = intval($_POST['toRow']);
$toCol = $_POST['toCol'];
$pieceType = $_POST['pieceType'];
$pieceColor = $_POST['pieceColor']; 


$validMove = isValidMove($fromRow, $fromCol, $toRow, $toCol, $pieceType, $pieceColor);

$response = array('success' => $validMove);
echo json_encode($response);

function isValidMove($fromRow, $fromCol, $toRow, $toCol, $pieceType, $pieceColor) {

    $fromColNumeric = ord($fromCol) - ord('a') + 1;
    $toColNumeric = ord($toCol) - ord('a') + 1;

    $colDiff = abs($toColNumeric - $fromColNumeric);
    $rowDiff = abs($toRow - $fromRow);

    if ($pieceType === 'Pawn') {
        $rowDiff = $toRow - $fromRow;

        if ($pieceColor === 'white' && $rowDiff > 0) {
            if ($fromRow == 2) {
                if ($toRow == 3 && $fromCol == $toCol) {
                    return true;
                }
                elseif ($toRow == 4 && $fromCol == $toCol && $rowDiff == 2) {
                    return true;
                }
            } else {
                if ($toRow == $fromRow + 1 && $fromCol == $toCol) {
                    return true;
                }
            }
        } elseif ($pieceColor === 'black' && $rowDiff < 0) {
            if ($fromRow == 7) {
                if ($toRow == 6 && $fromCol == $toCol) {
                    return true;
                }
                elseif ($toRow == 5 && $fromCol == $toCol && $rowDiff == -2) {
                    return true;
                }
            } else {
                if ($toRow == $fromRow - 1 && $fromCol == $toCol) {
                    return true;
                }
            }
        }
    } elseif ($pieceType === 'Knight') {
        if (($colDiff == 1 && $rowDiff == 2) || ($colDiff == 2 && $rowDiff == 1)) {
            return true;
        }
    } elseif ($pieceType === 'Rook') {
        if (($fromRow == $toRow && $fromCol != $toCol) || ($fromRow != $toRow && $fromCol == $toCol)) {
            return true;
        }
    } elseif ($pieceType === 'Bishop') {
        if ($colDiff == $rowDiff) {
            return true;
        }
    } elseif ($pieceType === 'Queen') {
        if (($fromRow == $toRow && $fromCol != $toCol) || ($fromRow != $toRow && $fromCol == $toCol)) {
            return true;
        } elseif ($colDiff == $rowDiff) {
            return true;
        }
    }

    return false;
}

?>
