document.addEventListener("DOMContentLoaded", function () {
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

        // If all validations pass, submit the order via index.php
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
});
