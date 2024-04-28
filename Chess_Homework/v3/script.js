function generateBoardState() {
    const squares = document.querySelectorAll('.square');
    const boardState = {};

    squares.forEach(square => {
        const piece = square.querySelector('.piece');
        if (piece) {
            const row = piece.dataset.row;
            const col = piece.dataset.col;
            const pieceType = piece.dataset.type;
            const pieceColor = piece.classList.contains('white') ? 'White' : 'Black';
            boardState[`${col}${row}`] = { type: pieceType, color: pieceColor };
        }
    });

    return boardState;
}

document.addEventListener('DOMContentLoaded', function() {
    const pieces = document.querySelectorAll('.piece');
    let draggedPiece = null;

    pieces.forEach(piece => {
        piece.addEventListener('dragstart', function(event) {
            draggedPiece = this;
            event.dataTransfer.setData('text/plain', null);
            // Set a higher z-index to ensure the dragged piece is on top
            this.style.zIndex = 999;
        });

        piece.addEventListener('dragend', function(event) {
            // Reset the z-index after dragging ends
            this.style.zIndex = 1;
            // Print the updated board state after the move is finished
            //printBoardState();
        });
    });

    const squares = document.querySelectorAll('.square');

    squares.forEach(square => {
        square.addEventListener('dragover', function(event) {
            event.preventDefault();
        });

        square.addEventListener('drop', function(event) {
            if (draggedPiece) {
                const fromRow = draggedPiece.dataset.row;
                const fromCol = draggedPiece.dataset.col;
                const toSquareId = this.id; // Get the ID of the square
                const toRow = toSquareId[1]; // Extract row from square ID
                const toCol = toSquareId[0]; // Extract col from square ID
                const pieceType = draggedPiece.dataset.type; // Get the type of the piece
                const pieceColor = draggedPiece.classList.contains('white') ? 'white' : 'black'; // Get the color of the piece
                const squareHasPiece = square.querySelector('.piece'); // Check if the square has a piece

                console.log('Move:', pieceType + ' from ' + fromRow + fromCol + ' to ' + toRow + toCol + (squareHasPiece ? ' piece on the square: ' + (squareHasPiece.classList.contains('white') ? 'white' : 'black') + ' ' + squareHasPiece.dataset.type : ''));

                // Send move data to PHP script via AJAX
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'move_piece.php');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            console.log('Move successful');
                            // Check if a capture should occur
                            if (response.capture) {
                                // Remove the opposing piece from the square
                                square.removeChild(squareHasPiece);
                            }
                            // Append the dragged piece to the dropped square only if the move is successful
                            square.appendChild(draggedPiece);
                            // Update piece position only if the move is successful
                            draggedPiece.dataset.row = toRow;
                            draggedPiece.dataset.col = toCol;
                        } else {
                            console.error('Move failed');
                        }
                    } else {
                        console.error('Error:', xhr.statusText);
                    }
                    // Reset draggedPiece to null after processing the response
                    draggedPiece = null;
                };
                xhr.onerror = function() {
                    console.error('Request failed');
                    // Reset draggedPiece to null if the request fails
                    draggedPiece = null;
                };

                // Generate and send board state including piece type, color, and piece information
                const boardState = generateBoardState();
                const squareHasPieceValue = squareHasPiece ? 'true' : 'false';
                xhr.send(`fromRow=${fromRow}&fromCol=${fromCol}&toRow=${toRow}&toCol=${toCol}&pieceType=${pieceType}&pieceColor=${pieceColor}&squareHasPiece=${squareHasPieceValue}&boardState=${JSON.stringify(boardState)}`);
            }
        });
    });
});


function printBoardState() {
    const boardState = generateBoardState();
    console.log('Board State:', boardState);
}
