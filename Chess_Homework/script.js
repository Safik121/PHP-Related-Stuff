// script.js

document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.piece');

    let draggedPiece = null;

    buttons.forEach(button => {
        button.addEventListener('dragstart', function(event) {
            draggedPiece = this;
            event.dataTransfer.setData('text/plain', null);
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
