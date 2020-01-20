<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('{{ config('saas.billing.stripe.public_key') }}');

    stripe.redirectToCheckout({
        sessionId: '{{ $sessionId }}'
    }).then(function (result) {

    });
</script>