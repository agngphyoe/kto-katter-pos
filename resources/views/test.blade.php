<style>
    .custom-alert {
        background-color: #ffcc00;
        color: #333;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        position: absolute;
        top: 100px;
        /* Adjust the top position to fit your layout */
        right: 10px;
        /* Adjust the right position to fit your layout */
        z-index: 9999;
    }
</style>
<div id="alert-container"></div>

<!-- HTML code for dynamic input boxes -->
<div id="input-boxes"></div>

<div id="flash-alert" style="display: none;"></div>
<form action="{{ route('purchase-store') }}" method="POST">
    @csrf

    <input type="hidden" name="data" id="selectedProducts">

    <button>Submit</button>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>

<script>
    var scannedCodes = [];
    var scannedCode = '';
    var currentInputIndex = 0;
    var inputBoxes = document.getElementById('input-boxes');
    var flashAlert = document.getElementById('flash-alert');
    const selectedProductsInput = document.getElementById('selectedProducts');

    // Add dynamic input boxes based on quantity
    var quantity = 5; // Replace this with the actual quantity
    for (var i = 0; i < quantity; i++) {
        var inputElement = document.createElement('input');
        inputElement.type = 'text';
        inputElement.placeholder = 'Scan input ' + (i + 1);
        inputBoxes.appendChild(inputElement);
    }

    document.addEventListener('keydown', function(event) {
        var isNumber = /^\d$/;

        if (isNumber.test(event.key)) {
            scannedCode += event.key;
        } else if (event.key === "Enter") {
            // Check if the scanned code already exists in the scannedCodes array
            if (scannedCodes.includes(scannedCode)) {
                showAlert('This is a custom alert message!');
                scannedCode = '';
            } else {
                // Get the current input box
                var currentInputElement = document.getElementById('input-boxes').children[currentInputIndex];

                // Set scanned code to the current input box's value
                if (currentInputElement) {
                    currentInputElement.value = scannedCode;

                    // Move to the next input box
                    currentInputIndex++;

                    // Add the scanned code to the scannedCodes array
                    scannedCodes.push({'code':scannedCode});

                    localStorage.setItem('test', JSON.stringify({
                        'data': scannedCodes
                    }));

                    const cartItems = localStorage.getItem('test');
                    const items = JSON.parse(cartItems);

                    selectedProductsInput.value = JSON.stringify(items);

                    // Reset scanned code for the next scan
                    scannedCode = '';
                } else {
                    showAlert('All input boxes scanned!');
                    scannedCode = '';

                }
            }

            event.preventDefault();
        }
    });

    function showAlert(message) {
        var alertContainer = document.getElementById('alert-container');
        var alertElement = document.createElement('div');
        alertElement.className = 'custom-alert';
        alertElement.textContent = message;
        alertContainer.appendChild(alertElement);

        // Automatically remove the alert after a few seconds
        setTimeout(function() {
            alertElement.remove();
        }, 3000); // Remove after 3 seconds (adjust the duration as needed)
    }
</script>