<?php

$fromRow = intval($_POST['fromRow']);
$fromCol = $_POST['fromCol'];
$toRow = intval($_POST['toRow']);
$toCol = $_POST['toCol'];
$pieceType = $_POST['pieceType'];
$pieceColor = $_POST['pieceColor'];
$hasPiece = $_POST['squareHasPiece'];
$boardState = json_decode($_POST['boardState'], true);

// Call the isValidMove function
$moveResult = isValidMove($fromRow, $fromCol, $toRow, $toCol, $pieceType, $pieceColor, $boardState);

// Extracting isValid and shouldCapture variables from the moveResult
$isValid = $moveResult[0];
$shouldCapture = $moveResult[1];

// Prepare the response array
$response = array(
    'success' => $isValid,
    'boardState' => $boardState,
    'capture' => $shouldCapture
);

// Encode the response array to JSON format
$jsonResponse = json_encode($response);

// Send the JSON response
echo $jsonResponse;


function isValidMove($fromRow, $fromCol, $toRow, $toCol, $pieceType, $pieceColor, $boardState) {
    $isValid = false;
    $shouldCapture = false;

    if ($fromRow == $toRow && $fromCol == $toCol) {
        return array($isValid, $shouldCapture);
    }
    if ($toRow < 1 || $toRow > 8 || $toCol < 'a' || $toCol > 'h') {
        return array($isValid, $shouldCapture);
    }

    $fromColNumeric = ord($fromCol) - ord('a') + 1;
    $toColNumeric = ord($toCol) - ord('a') + 1;

    $colDiff = abs($toColNumeric - $fromColNumeric);
    $rowDiff = abs($toRow - $fromRow);

    if ($pieceType === 'Pawn') {
        $rowDiff = $toRow - $fromRow;
        $colDiff = abs(ord($toCol) - ord($fromCol));
        
        if ($pieceColor === 'white' && $rowDiff == 1 && $colDiff == 0 && !isset($boardState[$toCol . $toRow])) {
            $isValid = true;
        } elseif ($pieceColor === 'black' && $rowDiff == -1 && $colDiff == 0 && !isset($boardState[$toCol . $toRow])) {
            $isValid = true;
        }
        
        if ($pieceColor === 'white' && $rowDiff == 2 && $colDiff == 0 && $fromRow == 2) {
            if (!isset($boardState[$toCol . ($toRow - 1)]) && !isset($boardState[$toCol . $toRow])) {
                $isValid = true;
            }
        } elseif ($pieceColor === 'black' && $rowDiff == -2 && $colDiff == 0 && $fromRow == 7) {
            if (!isset($boardState[$toCol . ($toRow + 1)]) && !isset($boardState[$toCol . $toRow])) {
                $isValid = true;
            }
        }

        if ($pieceColor === 'white' && $rowDiff == 1 && $colDiff == 1 && isset($boardState[$toCol . $toRow]) && strtolower($boardState[$toCol . $toRow]['color']) === 'black') {
            $isValid = true;
            $shouldCapture = true;
        } elseif ($pieceColor === 'black' && $rowDiff == -1 && $colDiff == 1 && isset($boardState[$toCol . $toRow]) && strtolower($boardState[$toCol . $toRow]['color']) === 'white') {
            $isValid = true;
            $shouldCapture = true;
        }     
    } elseif ($pieceType === 'Knight') {
        if (($colDiff == 1 && $rowDiff == 2) || ($colDiff == 2 && $rowDiff == 1)) {
            $toSquare = $toCol . $toRow;
            if (!isset($boardState[$toSquare])) {
                $isValid = true;
            } elseif (strtolower($boardState[$toSquare]['color']) !== strtolower($pieceColor)) {
                $isValid = true;
                $shouldCapture = true;
            }
        }
    } elseif ($pieceType === 'Rook') {
        if (($fromRow == $toRow && $fromCol != $toCol) || ($fromRow != $toRow && $fromCol == $toCol)) {
            $toSquare = $toCol . $toRow;
            if ($fromRow == $toRow) {
                $startCol = min(ord($fromCol), ord($toCol)) + 1;
                $endCol = max(ord($fromCol), ord($toCol)) - 1;
                for ($col = $startCol; $col <= $endCol; $col++) {
                    $currentSquare = chr($col) . $fromRow;
                    if (isset($boardState[$currentSquare])) {
                        return array($isValid, $shouldCapture);
                    }
                }
            } else {
                $startRow = min($fromRow, $toRow) + 1;
                $endRow = max($fromRow, $toRow) - 1;
                for ($row = $startRow; $row <= $endRow; $row++) {
                    $currentSquare = $fromCol . $row;
                    if (isset($boardState[$currentSquare])) {
                        return array($isValid, $shouldCapture);
                    }
                }
            }
            if (!isset($boardState[$toSquare])) {
                $isValid = true;
            } elseif (strtolower($boardState[$toSquare]['color']) !== strtolower($pieceColor)) {
                $isValid = true;
                $shouldCapture = true;
            }
        }
    } elseif ($pieceType === 'Bishop') {
        if ($colDiff == $rowDiff) {
            $startRow = min($fromRow, $toRow) + 1;
            $startCol = min(ord($fromCol), ord($toCol)) + 1;
            $endRow = max($fromRow, $toRow) - 1;
            $endCol = max(ord($fromCol), ord($toCol)) - 1;
            for ($row = $startRow, $col = $startCol; $row <= $endRow && $col <= $endCol; $row++, $col++) {
                $currentSquare = chr($col) . $row;
                if (isset($boardState[$currentSquare])) {
                    return array($isValid, $shouldCapture);
                }
            }
            $toSquare = $toCol . $toRow;
            if (!isset($boardState[$toSquare])) {
                $isValid = true;
            } elseif (strtolower($boardState[$toSquare]['color']) !== strtolower($pieceColor)) {
                $isValid = true;
                $shouldCapture = true;
            }
        }
    } elseif ($pieceType === 'Queen') {
        if (($fromRow == $toRow && $fromCol != $toCol) || ($fromRow != $toRow && $fromCol == $toCol)) {
            $toSquare = $toCol . $toRow;
            if ($fromRow == $toRow) {
                $startCol = min(ord($fromCol), ord($toCol)) + 1;
                $endCol = max(ord($fromCol), ord($toCol)) - 1;
                for ($col = $startCol; $col <= $endCol; $col++) {
                    $currentSquare = chr($col) . $fromRow;
                    if (isset($boardState[$currentSquare])) {
                        return array($isValid, $shouldCapture);
                    }
                }
            } else {
                $startRow = min($fromRow, $toRow) + 1;
                $endRow = max($fromRow, $toRow) - 1;
                for ($row = $startRow; $row <= $endRow; $row++) {
                    $currentSquare = $fromCol . $row;
                    if (isset($boardState[$currentSquare])) {
                        return array($isValid, $shouldCapture);
                    }
                }
            }
            if (!isset($boardState[$toSquare])) {
                $isValid = true;
            } elseif (strtolower($boardState[$toSquare]['color']) !== strtolower($pieceColor)) {
                $isValid = true;
                $shouldCapture = true;
            }
        } elseif ($colDiff == $rowDiff) {
            $startRow = min($fromRow, $toRow) + 1;
            $startCol = min(ord($fromCol), ord($toCol)) + 1;
            $endRow = max($fromRow, $toRow) - 1;
            $endCol = max(ord($fromCol), ord($toCol)) - 1;
            for ($row = $startRow, $col = $startCol; $row <= $endRow && $col <= $endCol; $row++, $col++) {
                $currentSquare = chr($col) . $row;
                if (isset($boardState[$currentSquare])) {
                    return array($isValid, $shouldCapture);
                }
            }
            $toSquare = $toCol . $toRow;
            if (!isset($boardState[$toSquare])) {
                $isValid = true;
            } elseif (strtolower($boardState[$toSquare]['color']) !== strtolower($pieceColor)) {
                $isValid = true;
                $shouldCapture = true;
            }
        }
    } elseif ($pieceType === 'King') {
        if (($colDiff <= 1) && ($rowDiff <= 1)) {
            $isValid = true;
        }
    }

    return array($isValid, $shouldCapture);
}
?>
