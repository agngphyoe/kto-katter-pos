function getStoredProducts(localStorageName) {
    const storedData = localStorage.getItem(localStorageName);

    return storedData ? JSON.parse(storedData) : [];
}

function setStoredProducts(localStorageName, productsArray) {
    localStorage.setItem(localStorageName, JSON.stringify(productsArray));
}

function displayProductList(product, is_show_quantity = true) {
    const newQuantity = product.new_quantity > 0 ? product.new_quantity : "";

    tableRow = `
    <tr class="bg-white border-b text-left">
    <th scope="row" class="px-6 py-3  font-medium whitespace-nowrap">
        <h1 class="text-paraColor"><span id="name${product.id}">${
        product.name
    }</span> <span class="text-noti" id="code${product.id}">${
        product.code
    }</span></h1>
        </div>
    </th>
    <td class="px-6 py-3 text-left" id="qty${product.id}">${Number(
        product.stock_quantity
    ).toLocaleString()}</td>
  `;

    if (is_show_quantity) {
        tableRow += `
    <td class="px-6 py-2 text-center">
        <input type="number" value="${newQuantity}" id="newQuantity${
            product.id
        }" min="1" max="${
            product.new_quantity > product.stock_quantity
                ? product.stock_quantity
                : product.action_quantity
        }" class="newQuantity outline-none px-2 py-1 bg-bgMain rounded-md w-20 text-right" required />
    </td>`;
    }

    return tableRow;
}

function displayPurchaseReturnProductList(product, is_show_quantity = true) {
    const newQuantity = product.new_quantity > 0 ? product.new_quantity : "";

    tableRow = `
        <tr class="bg-white border-b text-left">
        <th scope="row" class="px-6 py-3  font-medium whitespace-nowrap text-left">
            <h1 class="text-paraColor"><span id="name${product.id}">${
        product.name
    }</span> <span class="text-noti" id="code${product.id}">${
        product.code
    }</span></h1>
            </div>
        </th>
        <td class="px-6 py-2 text-right">
            ${Number(product.buy_price).toLocaleString()}
        </td>
        <td class="px-6 py-2 text-right" id="buy_price${product.id}">
            ${Number(product.total_price).toLocaleString()}
        </td>
        <td class="px-6 py-2 text-center" id="available_quantity${product.id}">
                ${Number(product.stock_quantity).toLocaleString()}
        </td>
    `;

    if (is_show_quantity) {
        tableRow += `
    <td class="px-6 py-2 text-center">
        <input type="number" value="${newQuantity}" id="returned_quantity${product.id}" min="1" max="${product.stock_quantity}" class="newQuantity outline-none px-2 py-1 bg-bgMain rounded-md w-20 text-right" required />
    </td>`;
    }

    return tableRow;
}

function displaySaleReturnProductList(product, is_show_quantity = true) {
    const newQuantity = product.new_quantity > 0 ? product.new_quantity : "";

    tableRow = `
    <tr class="bg-white border-b text-left">
    <th scope="row" class="px-6 py-3  font-medium whitespace-nowrap">
        <h1 class="text-paraColor"><span id="name${product.id}">${
        product.name
    }</span> <span class="text-noti" id="code${product.id}">(${
        product.code
    })</span></h1>
        </div>
    </th>
    <td class="pl-6 pr-2 py-3 text-right" id="price${product.id}">${Number(
        product.buy_price
    ).toLocaleString()}</td>
    <td class="pl-6 pr-2  py-3 text-center" id="qty${product.id}">${Number(
        product.stock_quantity
    ).toLocaleString()} </td>
  `;

    if (is_show_quantity) {
        tableRow += `
    <td class="px-2 py-2 text-center">
        <input type="number" value="${newQuantity}" id="newQuantity${product.id}" min="1" max="${product.stock_quantity}" class="newQuantity outline-none px-4 py-1 bg-bgMain rounded-md text-right" required />
    </td>`;
    }

    return tableRow;
}

function displayPosReturnProductList(product, is_show_quantity = true) {
    const newQuantity = product.new_quantity > 0 ? product.new_quantity : "";

    tableRow = `
    <tr class="bg-white border-b text-left">
    <th scope="row" class="px-6 py-3  font-medium whitespace-nowrap">
        <h1 class="text-paraColor" id="name${product.id}">${product.name}</h1>

    </th>
    <td class="px-6 py-3 text-center" id="qty${product.id}">${Number(
        product.stock_quantity
    ).toLocaleString()}</td>
  `;

    if (is_show_quantity) {
        tableRow += `
    <td class="px-6 py-2 text-center">
        <input type="number" value="${newQuantity}" id="newQuantity${
            product.id
        }" min="1" max="${
            product.new_quantity > product.stock_quantity
                ? product.stock_quantity
                : product.action_quantity
        }" class="newQuantity outline-none px-2 py-1 bg-bgMain rounded-md w-20 text-right" required />
    </td>`;
    }

    return tableRow;
}

function handlePageLoading(localStorageName) {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');

    const products = getStoredProducts(localStorageName);

    const productIds = products.map((product) => product.id);

    checkboxes.forEach((checkbox) => {
        const productId = parseInt(checkbox.dataset.productId);
        checkbox.checked = productIds.includes(productId);
    });

    updateSelectedCount(localStorageName);
}

function handleCheckboxClick(event, localStorageName) {
    const checkbox = event.target;
    var productId = checkbox.dataset.productId;
    var products = getStoredProducts(localStorageName);
    const name = document.getElementById("name" + productId);
    const code = document.getElementById("code" + productId);
    const quantity = document.getElementById("quantity" + productId);
    const buy_price = document.getElementById("buy_price" + productId);
    const retail_price = document.getElementById("retail_price" + productId);
    const wholesale_price = document.getElementById(
        "wholesale_price" + productId
    );
    const wholesale_sell_price = document.getElementById(
        "wholesale_sell_price" + productId
    );
    const retail_sell_price = document.getElementById(
        "retail_sell_price" + productId
    );
    const is_imei = document.getElementById("is_imei" + productId);
    const new_wholesale_price = 0;
    const new_retail_price = 0;

    const isImei = is_imei ? parseInt(is_imei.value) : null;
    const purchasedQuantity = document.getElementById(
        "action_quantity" + productId
    );
    const returnedQuantity = document.getElementById(
        "returned_quantity" + productId
    );

    const stockQuantity = quantity
        ? parseInt(quantity.textContent.replace(/,/g, ""), 10)
        : 0;

    const parseBuyPrice = buy_price
        ? parseInt(buy_price.textContent.replace(/,/g, ""), 10)
        : 0;
    const parseRetailPrice = retail_price
        ? parseInt(retail_price.textContent.replace(/,/g, ""), 10)
        : 0;
    const parseWholesalePrice = wholesale_price
        ? parseInt(wholesale_price.textContent.replace(/,/g, ""), 10)
        : 0;
    const parsePurchasedQuantity = purchasedQuantity
        ? parseInt(purchasedQuantity.textContent.replace(/,/g, ""), 10)
        : 0;
    const parseReturnedQuantity = returnedQuantity
        ? parseInt(returnedQuantity.textContent.replace(/,/g, ""), 10)
        : 0;
    const parseWholesaleSellPrice = wholesale_sell_price
        ? parseInt(wholesale_sell_price.textContent.replace(/,/g, ""), 10)
        : 0;
    const parseRetailSellPrice = retail_sell_price
        ? parseInt(retail_sell_price.textContent.replace(/,/g, ""), 10)
        : 0;

    if (checkbox.checked) {
        var existingProductIndex = products.findIndex(function (product) {
            return product.id === parseInt(productId);
        });

        const productData = {
            id: parseInt(productId),
            name: name.textContent,
            code: code.textContent,
            stock_quantity: stockQuantity,
            new_quantity: 0,
            new_price: 0,
            // newWholesalePrice: 0,
            buy_price: parseBuyPrice,
            retail_price: parseRetailPrice,
            wholesale_price: parseWholesalePrice,
            action_quantity: parsePurchasedQuantity,
            returned_quantity: parseReturnedQuantity,
            wholesale_sell_price: parseWholesaleSellPrice,
            retail_sell_price: parseRetailSellPrice,
            total_price: stockQuantity * parseBuyPrice,
            new_total_price: 0,
            new_wholesale_price: new_wholesale_price,
            new_retail_price: new_retail_price,
        };

        if (isImei !== null) {
            productData.isIMEI = isImei;
            productData.imei = [];
        }

        if (existingProductIndex === -1) {
            products.push(productData);
        } else {
            products[existingProductIndex] = productData;
        }
    } else {
        products = products.filter(
            (product) => product.id !== parseInt(productId)
        );
    }

    setStoredProducts(localStorageName, products);

    updateSelectedCount(localStorageName);
}

function updateSelectedCount(localStorageName) {
    const products = getStoredProducts(localStorageName);
    const selectedCountElement = document.getElementById("selectedCount");

    selectedCountElement.textContent = products.length.toString();

    const product_inputs = document.getElementById("selectedProducts");

    if (product_inputs) {
        product_inputs.value = JSON.stringify(products);
    }

    const nextButton = document.getElementById("nextButton");

    if (nextButton) {
        nextButton.disabled = products.length === 0;
    }
}

function deleteProduct(localStorageName, productId) {
    const quantityInput = document.getElementById("quantity" + productId);

    if (quantityInput) {
        quantityInput.removeAttribute("required");
    }

    Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete this item.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            let productsArray = getStoredProducts(localStorageName);
            productsArray = productsArray.filter(
                (item) => item.id !== productId
            );
            setStoredProducts(localStorageName, productsArray);

            Swal.fire({
                title: "Success!",
                text: "The item has been deleted.",
                icon: "success",
                showConfirmButton: false,
                timer: 1500,
            }).then((result) => {
                window.location.reload();
            });
        } else {
            if (quantityInput) {
                quantityInput.setAttribute("required", "true");
            }
        }
    });
}

function addValueHiddenFields(hiddenInput, productsArray) {
    const elementId = document.getElementById(hiddenInput);

    elementId.value = JSON.stringify(productsArray);
}

function handleInput(event, localStorageName, hiddenInput) {
    const productId = event.target.id.replace(
        /newQuantity|newPrice|actionQuantity|newWholesalePrice|newRetailPrice/,
        ""
    );
    const value = event.target.value.trim();
    let productsArray = getStoredProducts(localStorageName);

    const productIndex = productsArray.findIndex(
        (item) => item.id === parseInt(productId)
    );

    if (productIndex !== -1) {
        if (event.target.id.startsWith("newQuantity")) {
            if (value === "") {
                productsArray[productIndex].new_quantity = 0;
            } else {
                productsArray[productIndex].new_quantity = parseInt(value);
            }
        } else if (event.target.id.startsWith("newPrice")) {
            if (value === "") {
                productsArray[productIndex].new_price = 0;
            } else {
                productsArray[productIndex].new_price = parseInt(value);
            }
        } else if (event.target.id.startsWith("newWholesalePrice")) {
            productsArray[productIndex].new_wholesale_price =
                value == ""
                    ? productsArray[productIndex].wholesale_price
                    : parseInt(value);
        } else if (event.target.id.startsWith("newRetailPrice")) {
            productsArray[productIndex].new_retail_price =
                value == ""
                    ? productsArray[productIndex].retail_price
                    : parseInt(value);
        }
    }
    setStoredProducts(localStorageName, productsArray);

    addValueHiddenFields(hiddenInput, productsArray);
}
