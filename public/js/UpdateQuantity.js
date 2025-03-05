function updateQuantityAndPrice(data) {
    const productId = data.product.id;
    const productPrice = data.product.price;
    const updatedQuantity = data.product.quantity;

    const quantityInput = document.getElementById("product_stock" + productId);
    const quantity = document.getElementById("quantity" + productId);
    const priceInput = document.getElementById("unit_price" + productId);
    const price = document.getElementById("sell_price" + productId);

    if (quantityInput) {
        quantityInput.textContent = updatedQuantity.toLocaleString();
    }

    if (priceInput) {
        priceInput.textContent = productPrice.toLocaleString();
    }

    if (quantity) {
        quantity.textContent = updatedQuantity.toLocaleString();
    }

    if (price) {
        price.textContent = productPrice.toLocaleString();
    }
}
