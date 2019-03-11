@extends('layouts.app')

@section('content')
<section class="c-section c-hero">
    <div class="c-hero__content">
        <h1 class="c-hero__title">LinkCutter</h1>
        <p class="c-hero__description">Do you like long link? Neither does Twitter, so cut them. <br> Our powerful algorithms chew away your long and annoying links.</p>
        <form action="{{ route('links.store') }}" method="POST" id="linkform">
            <div class="c-link-input">
                <input class="c-link-input__input" type="text" name="url">
                <label class="c-link-input__label"><span>Enter your link</span></label>
                <svg class="c-link-input__svg" width="300%" height="100%" viewBox="0 0 1200 60" preserveAspectRatio="none">
                    <defs>
                        <lineargradient id="linegrad" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" stop-color="#325dff"></stop>
                            <stop offset="100%" stop-color="#45e791"></stop>
                        </lineargradient>
                    </defs>
                    <path d="M0,56.5c0,0,298.666,0,399.333,0C448.336,56.5,513.994,46,597,46c77.327,0,135,10.5,200.999,10.5c95.996,0,402.001,0,402.001,0"></path>
                </svg>
            </div>
            @if (Auth::user() && Auth::user()->hasFeature('unique-visits'))
                <div class="c-link-input-checkbox">
                    <input class="c-link-input-checkbox__input" type="checkbox" id="tracked" name="is_tracked">
                    <label class="c-link-input-checkbox__label" for="tracked">Do you want to track visits on this link?</label>
                </div>
            @endif

        </form>
    </div>

    <div class="c-link-box" id="linkBox"><span>Here is your short URL: <input class="c-link-box__input" type="text" id="shortLink" onClick="this.select();" autocomplete="off" size="26"></span>
        <div class="c-link-box__stats">Did you know that your link is <strong id="linkStats">26</strong> characters shorter!</div>
    </div>

    <div class="c-scroll-down">
        <div class="c-scroll-down__mouse"></div>
    </div>
</section>

<section class="c-section c-section--pricing c-section--dark" id="pricing">
    <div class="c-section__header">
        <div class="c-section__header-content">
            <h2 class="c-section__header-title">Pricing</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores, blanditiis cum dolore obcaecati quas quod reprehenderit voluptatibus. Alias beatae cumque ea est exercitationem fugit itaque magnam, odio sapiente! Molestias, tenetur?</p>
        </div>
    </div>
    <div class="c-pricing-container">
        @foreach($plans as $plan)
            <div class="c-pricing">
                <header class="c-pricing__header">
                    <h3 class="c-pricing__title">{{ $plan->name }}</h3>
                    <div class="c-pricing__price">{{ $plan->amount }}<span class="c-pricing__price-cur">$</span></div>
                </header>
                <ul class="c-pricing__list">
                    @foreach($features as $feature)
                        <?php $hasFeature = $plan->features->pluck('pivot')->contains('feature_id', $feature->id) ?>
                        <li class="c-pricing__item {{ $hasFeature ? '' : 'c-pricing__item--disabled' }}">
                            {{ $feature->name }}
                            @if ($hasFeature)
                                @icon('check')
                            @else
                                @icon('x')
                            @endif
                        </li>
                    @endforeach
                </ul>
                <footer class="c-pricing__footer">
                    {{--<button class="btn" data-plan-id="{{ $plan->id }}">Choose plan</button>--}}
                    @if ( Auth::user() && Auth::user()->subscribed('default', $plan->id) )
                        <strong class=" c-pricing__footer-btn">Already subscribed</strong>
                    @elseif (Auth::user() && Auth::user()->subscribed())
                        <button class="btn c-pricing__footer-btn" data-plan-id="{{ $plan->id }}" data-change="true">Change</button>
                    @elseif (Auth::user())
                        <button class="btn c-pricing__footer-btn" data-plan-id="{{ $plan->id }}">Subscribe</button>
                    @else
                        <a href="{{ route('login') }}" class="btn c-pricing__footer-btn">Subscribe</a>
                    @endif
                </footer>
            </div>
        @endforeach
    </div>
</section>

@include('layouts.pricing-modal')

@section('scripts')
    <script src="{{ asset('js/velocity.min.js') }}" defer></script>
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        var stripe = Stripe('pk_test_6BvxTt6c8ytYtwJBk5jLH36v');

        function registerElements(elements) {
            var modal = document.querySelector('.c-pricing-modal');

            var form = modal.querySelector('.c-pricing-modal__form');
            //var resetButton = modal.querySelector('a.reset');
            var error = form.querySelector('.error');
            var errorMessage = error.querySelector('.message');

            function enableInputs() {
                Array.prototype.forEach.call(
                    form.querySelectorAll(
                        "input[type='text'], input[type='email'], input[type='tel']"
                    ),
                    function(input) {
                        input.removeAttribute('disabled');
                    }
                );
            }

            function disableInputs() {
                Array.prototype.forEach.call(
                    form.querySelectorAll(
                        "input[type='text'], input[type='email'], input[type='tel']"
                    ),
                    function(input) {
                        input.setAttribute('disabled', 'true');
                    }
                );
            }

            function triggerBrowserValidation() {
                // The only way to trigger HTML5 form validation UI is to fake a user submit
                // event.
                var submit = document.createElement('input');
                submit.type = 'submit';
                submit.style.display = 'none';
                form.appendChild(submit);
                submit.click();
                submit.remove();
            }

            // Listen for errors from each Element, and show error messages in the UI.
            var savedErrors = {};
            elements.forEach(function(element, idx) {
                element.on('change', function(event) {
                    if (event.error) {
                        error.classList.add('visible');
                        savedErrors[idx] = event.error.message;
                        errorMessage.innerText = event.error.message;
                    } else {
                        savedErrors[idx] = null;

                        // Loop over the saved errors and find the first one, if any.
                        var nextError = Object.keys(savedErrors)
                            .sort()
                            .reduce(function(maybeFoundError, key) {
                                return maybeFoundError || savedErrors[key];
                            }, null);

                        if (nextError) {
                            // Now that they've fixed the current error, show another one.
                            errorMessage.innerText = nextError;
                        } else {
                            // The user fixed the last error; no more errors.
                            error.classList.remove('visible');
                        }
                    }
                });
            });

            // Listen on the form's 'submit' handler...
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Trigger HTML5 validation UI on the form if any of the inputs fail
                // validation.
                var plainInputsValid = true;
                Array.prototype.forEach.call(form.querySelectorAll('input'), function(
                    input
                ) {
                    if (input.checkValidity && !input.checkValidity()) {
                        plainInputsValid = false;
                        return;
                    }
                });
                if (!plainInputsValid) {
                    triggerBrowserValidation();
                    return;
                }

                // Show a loading screen...
                modal.classList.add('submitting');

                // Disable all inputs.
                disableInputs();

                function stripeTokenHandler(token) {
                    var form = document.getElementById('hidden-form');
                    var tokenInput = document.createElement('input');
                    tokenInput.setAttribute('type', 'hidden');
                    tokenInput.setAttribute('name', 'stripeToken');
                    tokenInput.setAttribute('value', token.id);
                    form.appendChild(tokenInput);

                    form.submit();
                }

                // Gather additional customer data we may have collected in our form.
                var name = form.querySelector('#name');
                var address1 = form.querySelector('#address');
                var city = form.querySelector('#city');
                var state = form.querySelector('#state');
                var zip = form.querySelector('#zip');
                var additionalData = {
                    name: name ? name.value : undefined,
                    address_line1: address1 ? address1.value : undefined,
                    address_city: city ? city.value : undefined,
                    address_state: state ? state.value : undefined,
                    address_zip: zip ? zip.value : undefined,
                };

                // Use Stripe.js to create a token. We only need to pass in one Element
                // from the Element group in order to create a token. We can also pass
                // in the additional customer data we collected in our form.
                stripe.createToken(elements[0], additionalData).then(function(result) {
                    // Stop loading!
                    modal.classList.remove('submitting');

                    if (result.token) {
                        modal.classList.add('submitted');
                        stripeTokenHandler(result.token);
                    } else {
                        enableInputs();
                    }
                });
            });

            // resetButton.addEventListener('click', function(e) {
            //     e.preventDefault();
            //     // Resetting the form (instead of setting the value to `''` for each input)
            //     // helps us clear webkit autofill styles.
            //     form.reset();
            //
            //     // Clear each Element.
            //     elements.forEach(function(element) {
            //         element.clear();
            //     });
            //
            //     // Reset error state as well.
            //     error.classList.remove('visible');
            //
            //     // Resetting the form does not un-disable inputs, so we need to do it separately:
            //     enableInputs();
            //     modal.classList.remove('submitted');
            // });
        }
    </script>

    <script>

        var elements = stripe.elements({
            locale: window.__exampleLocale
        });

        var card = elements.create("card", {
            iconStyle: "solid",
            style: {
                base: {
                    iconColor: "#325dff",
                    color: "#636363",
                    fontFamily: '"Raleway", sans-serif',
                    fontSize: '16px',

                    "::placeholder": {
                        color: "#aaaaaa"
                    },
                    ":-webkit-autofill": {
                        color: "#fce883"
                    }
                },
                invalid: {
                    iconColor: "#ff4836",
                    color: "#ff1d30"
                }
            }
        });
        card.mount("#example5-card");

        var paymentRequest = stripe.paymentRequest({
            country: "US",
            currency: "usd",
            total: {
                amount: 2500,
                label: "Total"
            }
        });
        paymentRequest.on("token", function(result) {
            var example = document.querySelector(".example5");
            example.querySelector(".token").innerText = result.token.id;
            example.classList.add("submitted");
            result.complete("success");
        });

        var paymentRequestElement = elements.create("paymentRequestButton", {
            paymentRequest: paymentRequest,
            style: {
                paymentRequestButton: {
                    theme: "light"
                }
            }
        });

        paymentRequest.canMakePayment().then(function(result) {
            if (result) {
                document.querySelector(".example5 .card-only").style.display = "none";
                document.querySelector(
                    ".example5 .payment-request-available"
                ).style.display =
                    "block";
                paymentRequestElement.mount("#example5-paymentRequest");
            }
        });

        registerElements([card], 'c-pricing-modal__form');
    </script>
@endsection

<?php /*
<table class="table table-striped dashboard-card__table">
    <thead>
    <tr>
        <th>Features</th>
        @foreach($plans as $plan)
            <th class="text-center">
                <h5>{{ $plan->name }}</h5>

                <strong>{{ $plan->price() }}</strong>
            </th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($features as $feature)
        <tr>
            <th>
                {{ $feature['name'] }}
                <span data-toggle="tooltip" data-placement="top" data-title="{{ $feature['description'] }}">@icon('help-circle')</span>
            </th>
            @foreach($plans as $plan)
                <?php
                $value = false;
                $planFeatures = $plan->features->pluck('pivot')->toArray();
                $foundPlanIdx = array_search($feature->id, array_column($planFeatures, 'feature_id'));

                if ($foundPlanIdx !== false) {
                    $value = (bool) $planFeatures[$foundPlanIdx]['value'];
                }
                ?>
                @if ($value)
                    <td class="text-center">@icon('check-circle')</td>
                @else
                    <td></td>
                @endif
            @endforeach
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th>Options:</th>
        @foreach($plans as $plan)
            <td class="text-center">
                @if ( Auth::user()->subscribed('default', $plan->id) )
                    <strong>Already subscribed</strong>
                @elseif (Auth::user()->subscribed())
                    <form action="{{ route('plans.change', $plan->id) }}" method="POST">
                        @csrf
                        <script
                                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="pk_test_6BvxTt6c8ytYtwJBk5jLH36v"
                                data-amount="{{ $plan->amount * 100 }}"
                                data-name="LinkCutter"
                                data-description="{{ $plan->name }}"
                                data-image="{{ asset('images/logo_color.svg') }}"
                                data-locale="auto"
                                data-label="Update to {{$plan->name}}">
                        </script>
                    </form>
                @else
                    <form action="{{ route('plans.subscribe', $plan->id) }}" method="POST">
                        @csrf
                        <script
                                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="pk_test_6BvxTt6c8ytYtwJBk5jLH36v"
                                data-amount="{{ $plan->amount * 100 }}"
                                data-name="LinkCutter"
                                data-description="{{ $plan->name }}"
                                data-image="{{ asset('images/logo_color.svg') }}"
                                data-locale="auto">
                        </script>
                    </form>
                @endif
                </td>
        @endforeach
    </tr>
    </tfoot>
</table> */?>
{{-- https://stripe.com/docs/stripe-js --}}
@endsection

