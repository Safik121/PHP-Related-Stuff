
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
                
                console.log('Move:', pieceType + ' from ' + fromRow + fromCol + ' to ' + toRow + toCol);
                
                // Update piece position
                draggedPiece.dataset.row = toRow;
                draggedPiece.dataset.col = toCol;

                // Append the dragged piece to the dropped square
                this.appendChild(draggedPiece);
                
                draggedPiece = null;
            }
        });
    });
});
