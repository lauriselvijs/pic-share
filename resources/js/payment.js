import { loadStripe } from "@stripe/stripe-js/pure";
import { STRIPE_KEY } from "./const";

// Stripe.js will not be loaded until `loadStripe` is called
const stripe = await loadStripe(STRIPE_KEY);

const elements = stripe.elements();

const style = {
    base: {
        color: "#43374f",
        fontFamily: '"Quicksand", Arial, sans-serif',
        fontSmoothing: "antialiased",
        fontSize: "16px",
        "::placeholder": {
            color: "#43374f",
        },
    },
    invalid: {
        color: "#d30124",
        iconColor: "#d30124",
    },
};

const cardElement = elements.create("card", {
    hidePostalCode: true,
    style: style,
});

const cardElementContainer = document.getElementById("card-element-container");

if (cardElementContainer) {
    cardElement.mount(cardElementContainer);
}

const cardHolderName = document.getElementById("card-holder-name");
const cardButton = document.getElementById("card-button");
const cardButtonSpinner = document.getElementById("pay-btn-spinner");
const cardButtonText = document.getElementById("pay-btn-text");
const errorElement = document.getElementById("card-errors");

cardElement?.addEventListener("change", function (event) {
    if (event.error) {
        errorElement.textContent = event.error.message;
        cardButton.disabled = true;
    } else {
        errorElement.textContent = "";
        cardButton.disabled = false;
    }
});

cardButton?.addEventListener("click", async () => {
    cardButton.disabled = true;
    cardButtonText.style.display = "none";
    cardButtonSpinner.style.display = "block";

    const { paymentMethod, error } = await stripe.createPaymentMethod({
        card: cardElement,
        type: "card",
        billing_details: {
            name: cardHolderName.value.trim(),
        },
    });

    if (error) {
        errorElement.textContent = error.message;
        cardButton.disabled = false;
        cardButtonText.style.display = "block";
        cardButtonSpinner.style.display = "none";
    } else {
        cardButton.disabled = false;
        cardButtonText.style.display = "block";
        cardButtonSpinner.style.display = "none";

        paymentMethodHandler(paymentMethod.id);
    }
});

cardHolderName?.addEventListener("input", onUserNameInput);

function onUserNameInput(event) {
    const name = event.target.value;

    if (/[\u0080-\uFFFF]/.test(name.toUpperCase().normalize())) {
        cardButton.disabled = true;
        errorElement.textContent = "Name must be in ASCII format";
    } else {
        errorElement.textContent = "";
        cardButton.disabled = false;
    }
}

function paymentMethodHandler(paymentMethodId) {
    const form = document.getElementById("payment-form");
    const hiddenInput = document.createElement("input");
    hiddenInput.setAttribute("type", "hidden");
    hiddenInput.setAttribute("name", "payment_method_id");
    hiddenInput.setAttribute("value", paymentMethodId);
    form.appendChild(hiddenInput);
    form.submit();
}
