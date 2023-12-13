@props(['paymentMethods'=>[],'intent'=>''])

@if (!empty($paymentMethods))
<fieldset>
	<legend>Available Cards</legend>
	<div class="radio-item-container">

		@foreach($paymentMethods as $paymentMethod)
		<div class="radio-item">
			<label for="vanilla">
				<input type="radio" class="prexisting_payment_method"  name="payment_method" value="{{ $paymentMethod['id'] }}">
				<span> {{ $paymentMethod['billing_details']['name'] }} <span class="card-details">{{ $paymentMethod['card']['brand'] }} - {{ $paymentMethod['card']['last4'] }} </span> </span>
			</label>
		</div>
		@endforeach

	</div>
</fieldset>

<br><br>
<fieldset >
	<legend><input type="checkbox" id="newCardOption"> Enter New Card Information Below</legend>
	<br><br>
	<!-- Stripe Elements Placeholder -->
<div class="newcard" id="card-element"></div>

</fieldset>
<br><br>

<button class="newcard" id="card-button" data-secret="{{ $intent->client_secret }}">
    Add Card
</button>
<br>
@else

<fieldset >
	<legend> Enter New Card Information Below</legend>
	<br><br>
	<!-- Stripe Elements Placeholder -->
<div  id="card-element"></div>
<br><br>
<button id="card-button" data-secret="{{ $intent->client_secret }}">
    Add Card
</button>


</fieldset>
<br><br>

@endif



@if (!empty($paymentMethods))
<button type="submit" id="submitbtn" class="btn btn-success btn-lg" style="width:100%; font-size:2rem" >Complete Order
</button>
@endif

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
	    e.preventDefault()
	    cardBtn.disabled = true
	    const { setupIntent, error } = await stripe.confirmCardSetup(
	        cardBtn.dataset.secret, {
	            payment_method: {
	                card: cardElement,
	                billing_details: {
	                    name: '{{ Auth()->user()->name }}'
	                }
	            }
	        }
	    )

	    if(error) {
	        cardBtn.disable = false
	    } else {
        
	        let token = document.createElement('input')
	        token.setAttribute('type', 'hidden')
	        token.setAttribute('name', 'token')
	        token.setAttribute('value', setupIntent.payment_method)
	        form.appendChild(token)

			let addcard = document.createElement('input')
	        addcard.setAttribute('type', 'hidden')
	        addcard.setAttribute('name', 'add_new_payment_method')
	        addcard.setAttribute('value', '1')
	        form.appendChild(addcard)
			form.submit();


	        
	    }
	})



$('.newcard').hide();
$('#submitbtn').hide();

$(document).on('change','#newCardOption',function(e){

if($(this).is(':checked') ){
	$('#submitbtn').hide();
	$('.newcard').show();
	/*
	document.querySelectorAll('.prexisting_payment_method').forEach(e => {
		console.log(e.target.value)
		$(e).prop('checked',false);
	});
	*/
	$('input[name=payment_method]').prop('checked','')
}
else{
	$('.newcard').hide();
}

})

$(document).on('change','input[name=payment_method]',function(e){

	$('#newCardOption').prop('checked',false);
	$('.newcard').hide();
	$('#submitbtn').show();
})

$('#submitbtn').click(function(e){
	form.submit();
})
</script>


@endpush

