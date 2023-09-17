<!DOCTYPE html>
<html lang="ar" dir="rtl">
<meta name="csrf-token" content="{{ csrf_token() }}">

@include('home.partials.head')

<body>

@include('home.partials.navbar')
<!-- Service Section -->
<section id="service" class="pattern-style-4 has-overlay">
    <div class="container raise-2">
        <h3 class="section-title mb-6 pb-3 text-center">Our Plans</h3>

        <div class="card">
            <div class="card-header">
                You will be charge ${{number_format($plan->price, 2)}} for {{$plan->name}}
            </div>
            <div class="card-body">
                <form id="payment-form" action="{{route('subscriptions.create')}}" method="POST">
                    @csrf
                    <input type="hidden" id="plan" name="plan" value="{{$plan->id}}">
                    <div class="row text-left">
                        <div class="col-md-6 text-left">
                            <div class="form-group">
                                <div style="">
                                    <label for="#card-holder-name" style="margin: 13px 816px 20px 0px;">Name</label>
                                    <input type="text" style="margin: 0px 392px 20px 0px;" class="form-control"
                                           id="card-holder-name" name="name" value=""
                                           placeholder="Name of the card holder">
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-xl-4 col-lg-4">
                            <div class="form-group">
                                <label for="">Card Details</label>
                                <div id="card-element"></div>
                            </div>
                        </div>
                        <button type="submit" id="card-btn" class="btn btn-success"
                                data-secret="{{$intent->client_secret}}">
                            <span id="button-text">Purchase</span>
                            <div class="spinner hidden" id="spinner"></div>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</section>

</body>
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("{{config('services.stripe.publishable_key')}}");
    const elements = stripe.elements();

    const cardElement = elements.create('card');
    cardElement.mount('#card-element');
    const form = document.getElementById('payment-form');
    const cardBtn = document.getElementById('card-btn');
    const cardHolderName = document.getElementById('card-holder-name');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        cardBtn.disabled = true;
        const {setupIntent, error} = await stripe.confirmCardSetup(
            cardBtn.dataset.secret, {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: cardHolderName.value
                    }
                }
            }
        )
        if (error) {
            cardBtn.disabled = false
        } else {
            let token = document.createElement('input')
            token.setAttribute('type','hidden')
            token.setAttribute('name','token')
            token.setAttribute('value',setupIntent.payment_method)
            form.appendChild(token)
            form.submit();
        }
    })

</script>
</html>
