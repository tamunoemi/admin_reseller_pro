@extends('teckiproadmin::checkout.layouts.app')

@section('title', __('Plans'))

@section('nav')
 @include('teckiproadmin::checkout.layouts.pricing-nav')
@endsection

@section('content')

<section class="py-8">
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					You will be charged $99 for demo
				</div>
				<div class="card-body">
					<form id="payment-form" action="{{ route('stripe.subscription.create') }}" method="POST">
						@csrf
						<input type="hidden" name="plan" id="plan" value="{{ $id }}">
						<div class="row">
							<div class="col-xl-4 col-lg-4">
								<div class="form-group">
									<label for="">Name</label>
									<input type="text" name="name" id="card-holder-name" class="form-control" value="" placeholder="Name on the card">
								</div>
							</div>
						</div>
						<div class="row mt-3">
							<div class="col-xl-4 col-lg-4">
								<div class="form-group">
									<label for="">Card details</label>
									<div id="card-element"></div>
								</div>
							</div>
							<div class="col-xl-12 col-lg-12">
								<hr>
								<button type="submit" class="btn btn-primary" id="card-button" data-secret="{{ $intent->client_secret }}">Purchase</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
<script src="https://js.stripe.com/v3/"></script>
<script>
	const stripe = Stripe('{{ env('STRIPE_KEY') }}')
	const elements = stripe.elements()
	const cardElement = elements.create('card')
	cardElement.mount('#card-element')

	const cardHolderName = document.getElementById('card-holder-name')
	const cardBtn = document.getElementById('card-button')
    const form = document.getElementById('payment-form')

	form.addEventListener('submit', async (e) => {
	    e.preventDefault()
	    cardBtn.disabled = true
	    const { setupIntent, error } = await stripe.confirmCardSetup(
	        cardBtn.dataset.secret, {
	            payment_method: {
	                card: cardElement,
	                billing_details: {
	                    name: cardHolderName.value
	                }
	            }
	        }
	    )

	    if(error) {
	        cardBtn.disable = false
	    } else {
            alert('yup')
	        let token = document.createElement('input')
	        token.setAttribute('type', 'hidden')
	        token.setAttribute('name', 'token')
	        token.setAttribute('value', setupIntent.payment_method)
	        form.appendChild(token)
	        form.submit();
	    }
	})

</script>
@endsection
