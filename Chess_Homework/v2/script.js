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
                
                console.log('Move:', pieceType + ' from ' + fromRow + fromCol + ' to ' + toRow + toCol);
                
                // Send move data to PHP script via AJAX
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'move_piece.php');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            console.log('Move successful');
                
                            // Append the dragged piece to the dropped square only if the move is successful
                            square.appendChild(draggedPiece);  // <- This line should move the piece
                
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
                
                // Send move data including piece type and color
                xhr.send(`fromRow=${fromRow}&fromCol=${fromCol}&toRow=${toRow}&toCol=${toCol}&pieceType=${pieceType}&pieceColor=${pieceColor}`);
            }
        });
    });
});
