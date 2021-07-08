/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');
global.$ = global.jQuery = $;
require('popper.js');
require('bootstrap');

// require('@fortawesome/fontawesome-free/css/all.min.css');
//require('@fortawesome/fontawesome-free/js/all.js');

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

//baniere accueil animation --
var text1 = ["GAMME", "GAMME", "GAMME"];
var text2 = ["INDUSTRIES", " BIOMASSE", "AGROALIMEN.."];
var count = 2;
setInterval(() => {
  count--;
  document.getElementById('text-1').innerHTML= text1[count];
  document.getElementById('text-2-span').innerHTML= text2[count];
  if(count == 0){
    count = 3;
  }
}, 7000);

//

//jQuery to collapse the navbar on scroll
$(window).scroll(function() {
    if ($(".navbar").offset().top > 50) {
      $(".menu").addClass("fixed");
    } else {
      $(".menu").removeClass("fixed");
    }
});

// SLIDER
$('.carousel').carousel({
  interval: 2000
})
//END SLIDER


// STRIPE CHECKOUT
$(document).ready(function(){
    var pk = $('#checkout-button').attr('data-pk');
    var session_id = $('#checkout-button').attr('data-id');
    if(pk){
        var stripe = Stripe(pk);
    }

    var checkoutButton = document.getElementById('checkout-button');
    checkoutButton.addEventListener('click', function () {
        // When the customer clicks on the button, redirect
        // them to Checkout.
        stripe.redirectToCheckout({
            sessionId: session_id
        })
        .then(function (result) {
            if (result.error) {
                // If `redirectToCheckout` fails due to a browser or network
                // error, display the localized error message to your customer.
                var displayError = document.getElementById('error-message');
                displayError.textContent = result.error.message;
            }
        });
    });
    
});