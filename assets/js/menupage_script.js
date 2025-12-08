let quantity = 1;
const minQuantity = 1;
const maxQuantity = 99;





function updateDisplay() {
    document.getElementById('quantityDisplay').textContent = quantity;
    document.getElementById('decreaseBtn').disabled = quantity <= minQuantity;
    document.getElementById('increaseBtn').disabled = quantity >= maxQuantity;
}

function decreaseQuantity() {
    if (quantity > minQuantity) {
        quantity--;
        updateDisplay();
    }
}

function increaseQuantity() {
    if (quantity < maxQuantity) {
        quantity++;
        updateDisplay();
    }
}

function addToCart() {
    alert(`Added ${quantity} item(s) to cart!`);
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    updateDisplay();
});




