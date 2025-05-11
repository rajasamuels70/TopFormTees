document.addEventListener("DOMContentLoaded", function () {
    
    if (typeof customerZip !== "undefined" && customerZip) {
    console.log("Calling calculateSalesTax with ZIP:", customerZip); // Add this line
    calculateSalesTax(customerZip);
}

    function showPaymentForm(method) {
        document.getElementById("credit-card-form").style.display = method === "credit_card" ? "block" : "none";
        document.getElementById("paypal-button-container").style.display = method === "paypal" ? "block" : "none";
        document.getElementById("place-order-btn").style.display = method === "paypal" || method === "credit_card" ? "none" : "block";
    }

    document.querySelectorAll("input[name='payment_method']").forEach(input => {
        input.addEventListener("change", function () {
            showPaymentForm(this.value);
        });
    });

    document.getElementById("validate-card").addEventListener("click", function (event) {
        event.preventDefault();

        let cardNumber = document.getElementById("card-number").value.replace(/\s/g, '');
        let cardType = document.getElementById("card-type").value;
        let expiry = document.getElementById("card-expiry").value;
        let cvv = document.getElementById("card-cvv").value;
        let result = document.getElementById("card-result");

        if (!cardType) {
            showValidationError(result, "Please select a card type!");
            return;
        }

        if (!luhnCheck(cardNumber)) {
            showValidationError(result, "Invalid Card Number!");
            return;
        }

        if (!expiry.match(/^(0[1-9]|1[0-2])\/\d{2}$/)) {
            showValidationError(result, "Invalid Expiry Date!");
            return;
        }

        if (!cvv.match(/^\d{3,4}$/)) {
            showValidationError(result, "Invalid CVV!");
            return;
        }

        showValidationSuccess(result, "Card is Valid! Processing Order...");
        setTimeout(() => {
            document.getElementById("checkout-form").submit();
        }, 2000);
    });

    function luhnCheck(value) {
        let sum = 0;
        let shouldDouble = false;
        for (let i = value.length - 1; i >= 0; i--) {
            let digit = parseInt(value.charAt(i));

            if (shouldDouble) {
                digit *= 2;
                if (digit > 9) digit -= 9;
            }

            sum += digit;
            shouldDouble = !shouldDouble;
        }
        return sum % 10 === 0;
    }

    function showValidationError(element, message) {
        element.textContent = message;
        element.style.color = "red";
    }

    function showValidationSuccess(element, message) {
        element.textContent = message;
        element.style.color = "green";
    }

    // 🔽 Sales Tax Calculation Logic Starts Here
    if (typeof customerZip !== "undefined" && customerZip) {
        calculateSalesTax(customerZip);
    }

    async function fetchSalesTax(zip) {
    console.log("Sending API request for ZIP:", zip);
    try {
        const response = await fetch('/Projects/TopFormTees/api/get_sales_tax.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ zip })
        });

        const rawResponse = await response.text();
        console.log("API Raw Response:", rawResponse);  // Log full API response

        const data = JSON.parse(rawResponse);

        if (data.total_rate) {
            return parseFloat(data.total_rate);
        } else {
            alert("Sales tax data not found for this ZIP code.");
            return 0;
        }
    } catch (error) {
        console.error("Error fetching sales tax:", error);
        return 0;
    }
}


    async function calculateSalesTax(zip) {
        const taxRate = await fetchSalesTax(zip);
        const subtotal = parseFloat(document.getElementById('subtotal').innerText);
        const taxAmount = subtotal * taxRate;

        document.getElementById('sales-tax').innerText = taxAmount.toFixed(2);
        document.getElementById('final-total').innerText = (subtotal + taxAmount).toFixed(2);
    }

    const zipInput = document.getElementById('zipInput');
    if (zipInput) {
        zipInput.addEventListener('change', async (e) => {
            const zip = e.target.value.trim();
            if (zip.length !== 5 || isNaN(zip)) {
                alert("Please enter a valid 5-digit ZIP code.");
                return;
            }
            calculateSalesTax(zip);
        });
    }
});
