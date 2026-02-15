function addOrderItem() {
    const container = document.getElementById('orderItems');
    const itemCount = container.children.length + 1;
    
    const newItem = document.createElement('div');
    newItem.className = 'order-item';
    newItem.innerHTML = `
        <h3>Item ${itemCount}</h3>
        <div class="form-group">
            <label>Product</label>
            <select name="product_id[]" class="product-select" required>
                <option value="">Select product</option>
                ${getProductOptions()}
            </select>
        </div>
        <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="quantity[]" class="quantity" min="1" value="1" required>
        </div>
        <button type="button" onclick="this.parentElement.remove()">Remove</button>
    `;
    
    container.appendChild(newItem);
}

function getProductOptions() {
    const selects = document.querySelectorAll('.product-select');
    if(selects.length > 0) {
        return selects[0].innerHTML;
    }
    return '';
}

function updateProductStock(select) {
    const selectedOption = select.options[select.selectedIndex];
    if(selectedOption) {
        const stock = selectedOption.dataset.stock;
        const quantityInput = select.closest('.order-item').querySelector('.quantity');
        if(quantityInput) {
            quantityInput.max = stock;
        }
    }
}

document.addEventListener('change', function(e) {
    if(e.target.classList.contains('product-select')) {
        updateProductStock(e.target);
    }
});