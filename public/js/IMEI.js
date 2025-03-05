function attachToggleDetailsEvent() {
    document.addEventListener("DOMContentLoaded", function () {
        const rows = document.querySelectorAll(".row-item");

        rows.forEach((row, index) => {
            const detailsRow = document.getElementById(`details-row-${index}`);

            row.addEventListener("click", () => {
                if (detailsRow) {
                    detailsRow.classList.toggle("hidden");
                }
            });
        });
    });
}

function showIMEI(localStorageName) {
    const storedData = localStorage.getItem(localStorageName);

    const data = storedData ? JSON.parse(storedData) : [];

    const buttons = document.querySelectorAll(".imei-group [data-product-id]");

    buttons.forEach((button) => {
        button.addEventListener("mouseover", function (event) {
            const productId = event.currentTarget.dataset.productId;

            const container = document.querySelector(
                `.imei-list[data-product-id="${productId}"]`
            );

            if (container) {
                var imeiList = container.querySelector("ul");

                if (imeiList) {
                    imeiList.innerHTML = "";

                    const product = data.find(
                        (item) =>
                            item.id === parseInt(productId) ||
                            item.product_id === parseInt(productId)
                    );

                    if (product) {
                        document.getElementById(
                            `imeiCount${productId}`
                        ).innerHTML = product.imei.length;

                        product.imei.forEach((imei) => {
                            const listItem = document.createElement("li");
                            listItem.classList.add(
                                "tracking-widest",
                                "font-light",
                                "text-left",
                                "text-sm"
                            );
                            listItem.textContent = imei;

                            imeiList.appendChild(listItem);
                        });
                    }
                }
            }
        });
    });
}

function showExpireDate(localStorageName) {
    const storedData = localStorage.getItem(localStorageName);

    const data = storedData ? JSON.parse(storedData) : [];

    const buttons = document.querySelectorAll(".expire-group [data-product-id]");

    buttons.forEach((button) => {
        button.addEventListener("mouseover", function (event) {
            const productId = event.currentTarget.dataset.productId;

            const product = data.find(
                (item) =>
                    item.id === parseInt(productId) ||
                    item.product_id === parseInt(productId)
            );
            if (product) {
                var expire_date = document.getElementById("expire_data");
                expire_date.textContent = product.expire_date;
            }
        });
    });
}

function addRow(product, imei = null, counter, localStorageName) {
    var row = document.createElement("tr");
    row.classList.add("border-b");
    var imeiId = `imeiNumber${counter}`;
    const name = product.name || product.product_name;
    const id = product.id || product.product_id;
    const rprice = product.retail_price || product.retail_sell_price;

    row.innerHTML = `
    <td class="px-4 py-2 border-r h-7 whitespace-nowrap">${name}</td>
    <td class="px-4 py-2 border-r h-7 whitespace-nowrap">${Number(
        rprice
    ).toLocaleString()}</td>
        <td class="px-4 py-2 border-r h-7 whitespace-nowrap" id="${imeiId}">${
        imei || ""
    }</td>
    <td class="px-4 py-2 border-r h-7 whitespace-nowrap">
        <button onclick="removeRow(this,'${imeiId}','${id}','${localStorageName}')" class="btn-remove">
            <i class="fa-solid fa-minus bg-red-600 text-white p-1 rounded-full"></i>
        </button>
    </td>`;

    return row;
}

function removeRow(removeBtn, imeiId, productID, localStorageName) {
    
    const storeProducts = localStorage.getItem(localStorageName);

    const products = JSON.parse(storeProducts);

    var product = products.filter(function (item) {
        return (
            item.id === parseInt(productID) ||
            item.product_id === parseInt(productID)
        );
    });
    var imei = parseInt(document.getElementById(imeiId).textContent);

    var updateIMEI = product[0].imei.filter(function (item) {
        return item !== imei;
    });

    var productIndex = products.findIndex(function (item) {
        return (
            item.id === parseInt(productID) ||
            item.product_id === parseInt(productID)
        );
    });

    if (productIndex !== -1) {
        products[productIndex].imei = updateIMEI;
        localStorage.setItem(localStorageName, JSON.stringify(products));
    }

    removeBtn.closest("tr").remove();
    
    productCount++;
    $('#productCount').text(productCount);
    

    // Store the updated product count in localStorage
    localStorage.setItem(`productCount_${productID}`, productCount);

    toggleAddButton(productCount);

}

function showAlert(message) {
    var alertContainer = document.getElementById("alert-container");
    var alertElement = document.createElement("div");
    alertElement.className = "custom-alert";
    alertElement.textContent = message;
    alertContainer.appendChild(alertElement);

    setTimeout(function () {
        alertElement.remove();
    }, 3000);
}

function getLocalStorageData(localStorageName, productID) {
    const storeProducts = localStorage.getItem(localStorageName);

    const products = JSON.parse(storeProducts);

    if (storeProducts && Array.isArray(products)) {
        var product = products.filter(function (item) {
            return (
                item.id === parseInt(productID) ||
                item.product_id === parseInt(productID)
            );
        });

        return product;
    }
}

function getAllIMEINumbers(localStorageName) {
    const storeData = localStorage.getItem(localStorageName);

    const products = JSON.parse(storeData);

    const allIMEI = [];

    products.forEach((product) => {
        allIMEI.push(...product.imei);
    });
    
    return allIMEI;
}

function enableDoneBtn(nextButton, invalidMessage){
    nextButton.removeAttribute("disabled");
    nextButton.classList.remove("opacity-50");
    invalidMessage.textContent = "";
}

function checkEnableCheckOut(localStorageName, nextButton) {
    let isValid = true;
    var items = localStorage.getItem(localStorageName);
    
    nextButton.setAttribute("disabled", "disabled");
    var invalidMessage = document.getElementById("showInvalidMessage");
    
    if (items && JSON.parse(items).length > 0) {
        JSON.parse(items).forEach((item) => {
            
            const { quantity, imei, isIMEI } = item;
            
            if (isIMEI && quantity !== imei.length) {
                isValid = false;
            }
            
        });
        
        if (isValid) {
            enableDoneBtn(nextButton, invalidMessage);
        } else {
            nextButton.setAttribute("disabled", "disabled");
            nextButton.classList.add("opacity-50");
            invalidMessage.classList.add("text-red-600", "text-xs");
            invalidMessage.textContent =
                "* Must be same quantity and IMEI Count";
        }
    } else {
        // enableDoneBtn(nextButton, invalidMessage);
        nextButton.setAttribute("disabled", "disabled");
        nextButton.classList.add("opacity-50");
        invalidMessage.classList.add("text-red-600", "text-sm");
        invalidMessage.textContent =
            "* Cart has No Products !";
    }
}

function scanIMEICode(product, productID, products) {
    var scannedCode = "";

    document.addEventListener("keydown", function (event) {
        var isNumber = /^\d$/;

        if (isNumber.test(event.key)) {
            scannedCode += event.key;
        } else if (event.key === "Enter") {
            product = getLocalStorageData(localStorageName, productID);

            product = product ? product[0] : [];

            if (scannedCode !== "") {
                if (
                    getAllIMEINumbers(localStorageName).includes(
                        parseInt(scannedCode)
                    )
                ) {
                    showAlert("Already Added!.");
                } else {
                    var currentInputElement = document.getElementById(
                        `imeiNumber${imeiCounter - 1}`
                    );

                    if (
                        currentInputElement &&
                        (currentInputElement.textContent == null ||
                            currentInputElement.textContent == "")
                    ) {
                        if (imei_arr.includes(scannedCode)) {
                            currentInputElement.textContent = scannedCode;

                            product.imei.push(parseInt(scannedCode));

                            const index = products.findIndex(
                                (item) =>  item.id === parseInt(productID) ||
                                item.product_id === parseInt(productID)
                            );
                                
                            if (index !== -1) {
                                products[index] = product;
                                
                                localStorage.setItem(
                                    localStorageName,
                                    JSON.stringify(products)
                                );
                            }
                        } else {
                            showAlert(
                                "Not Found IMEI Number.Please Try Again."
                            );
                        }
                    } else {
                        showAlert("Please Add One New !");
                    }
                }

                scannedCode = "";

                return;
            }
        }
    });
}
