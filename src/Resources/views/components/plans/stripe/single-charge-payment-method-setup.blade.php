
<input id="card-holder-name" type="text">
 
<!-- Stripe Elements Placeholder -->
<div id="card-element"></div>
 
<button id="card-button">
    Process Payment
</button>


@push('after-scripts')
<script src="https://js.stripe.com/v3/"></script>
 
<script>
    const stripe = Stripe('stripe-public-key');
 
    const elements = stripe.elements();
    const cardElement = elements.create('card');
 
    cardElement.mount('#card-element');

    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');

    cardButton.addEventListener('click', async (e) => {
    const { paymentMethod, error } = await stripe.createPaymentMethod(
        'card', cardElement, {
            billing_details: { name: cardHolderName.value }
        }
    );

    if (error) {
        // Display "error.message" to the user...
    } else {
        // The card has been verified successfully...
    }
    });

</script>
@endpush