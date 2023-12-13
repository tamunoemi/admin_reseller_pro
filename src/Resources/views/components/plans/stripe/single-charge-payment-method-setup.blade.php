@props(['intent'=>''])

<fieldset>
	<legend>Enter Card Information Below</legend>

	<br><br>
	<div id="card-element"></div>

</fieldset>
<br><br>

<button type="submit" id="card-button" class="btn btn-success btn-lg" style="width:100%; font-size:2rem">Complete Order
</button>

@push('after-scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
	const stripe = Stripe('{{ env('STRIPE_KEY') }}')
	const elements = stripe.elements()
	const cardElement = elements.create('card')
	cardElement.mount('#card-element')


	const cardBtn = document.getElementById('card-button')
    const form = document.getElementById('payment-form')

	cardBtn.addEventListener('click', async (e) => {
	form.addEventListener('submit', async (e) => {
	    e.preventDefault()
	    cardBtn.disabled = true

        const { paymentMethod, error } = await stripe.createPaymentMethod(
        'card', cardElement, {
            billing_details: { name: '{{ Auth()->user()->name }}' }
        }
        );


	    if(error) {
	        cardBtn.disable = false
	    } else {
           
	        let token = document.createElement('input')
	        token.setAttribute('type', 'hidden')
	        token.setAttribute('name', 'token')
	        token.setAttribute('value', paymentMethod.id)
	        form.appendChild(token)
			form.submit();
	        
	    }
	})
})

</script>

@endpush