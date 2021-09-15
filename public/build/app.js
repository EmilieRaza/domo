(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["app"],{

/***/ "./assets/css/app.scss":
/*!*****************************!*\
  !*** ./assets/css/app.scss ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ }),

/***/ "./assets/js/app.js":
/*!**************************!*\
  !*** ./assets/js/app.js ***!
  \**************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
// any CSS you require will output into a single css file (app.css in this case)
__webpack_require__(/*! ../css/app.scss */ "./assets/css/app.scss"); // Need jQuery? Install it with "yarn add jquery", then uncomment to require it.


var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");

global.$ = global.jQuery = $;

__webpack_require__(/*! popper.js */ "./node_modules/popper.js/dist/esm/popper.js");

__webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js"); // require('@fortawesome/fontawesome-free/css/all.min.css');
//require('@fortawesome/fontawesome-free/js/all.js');


console.log('Hello Webpack Encore! Edit me in assets/js/app.js'); //baniere accueil animation --

var text1 = ["GAMME", "GAMME", "GAMME"];
var text2 = ["INDUSTRIES", " BIOMASSE", "AGROALIMEN.."];
var count = 2;
setInterval(function () {
  count--;
  document.getElementById('text-1').innerHTML = text1[count];
  document.getElementById('text-2-span').innerHTML = text2[count];

  if (count == 0) {
    count = 3;
  }
}, 7000); //
//jQuery to collapse the navbar on scroll

$(window).scroll(function () {
  if ($(".navbar").offset().top > 50) {
    $(".menu").addClass("fixed");
  } else {
    $(".menu").removeClass("fixed");
  }
}); //tabbar 

$('#myNavTabs a').click(function (evt) {
  evt.preventDefault();
  $(this).tab('show');
});
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  //new tab
  console.log(e.target); //previous tab

  console.log(e.relatedTarget);
}); // SLIDER

$('.carousel').carousel({
  interval: 5000
}); //END SLIDER
//  accordeon caracteristique produit

$(".accordian").on("click", ".accordian-title", function () {
  $(this).toggleClass("active").next().slideToggle(500);
}); // HOVER EFFECT DIV 

$(document).ready(function () {
  $('.hover-div').hover(function () {
    $('.hover-div').stop().fadeTo('fast', 0.3);
    $(this).stop().fadeTo('fast', 1);
  }, function () {
    $('.hover-div').stop().fadeTo('fast', 1);
  });
}); // STRIPE CHECKOUT

$(document).ready(function () {
  var pk = $('#checkout-button').attr('data-pk');
  var session_id = $('#checkout-button').attr('data-id');

  if (pk) {
    var stripe = Stripe(pk);
  }

  var checkoutButton = document.getElementById('checkout-button');
  checkoutButton.addEventListener('click', function () {
    // When the customer clicks on the button, redirect
    // them to Checkout.
    stripe.redirectToCheckout({
      sessionId: session_id
    }).then(function (result) {
      if (result.error) {
        // If `redirectToCheckout` fails due to a browser or network
        // error, display the localized error message to your customer.
        var displayError = document.getElementById('error-message');
        displayError.textContent = result.error.message;
      }
    });
  });
});
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../node_modules/webpack/buildin/global.js */ "./node_modules/webpack/buildin/global.js")))

/***/ })

},[["./assets/js/app.js","runtime","vendors~app"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvY3NzL2FwcC5zY3NzIiwid2VicGFjazovLy8uL2Fzc2V0cy9qcy9hcHAuanMiXSwibmFtZXMiOlsicmVxdWlyZSIsIiQiLCJnbG9iYWwiLCJqUXVlcnkiLCJjb25zb2xlIiwibG9nIiwidGV4dDEiLCJ0ZXh0MiIsImNvdW50Iiwic2V0SW50ZXJ2YWwiLCJkb2N1bWVudCIsImdldEVsZW1lbnRCeUlkIiwiaW5uZXJIVE1MIiwid2luZG93Iiwic2Nyb2xsIiwib2Zmc2V0IiwidG9wIiwiYWRkQ2xhc3MiLCJyZW1vdmVDbGFzcyIsImNsaWNrIiwiZXZ0IiwicHJldmVudERlZmF1bHQiLCJ0YWIiLCJvbiIsImUiLCJ0YXJnZXQiLCJyZWxhdGVkVGFyZ2V0IiwiY2Fyb3VzZWwiLCJpbnRlcnZhbCIsInRvZ2dsZUNsYXNzIiwibmV4dCIsInNsaWRlVG9nZ2xlIiwicmVhZHkiLCJob3ZlciIsInN0b3AiLCJmYWRlVG8iLCJwayIsImF0dHIiLCJzZXNzaW9uX2lkIiwic3RyaXBlIiwiU3RyaXBlIiwiY2hlY2tvdXRCdXR0b24iLCJhZGRFdmVudExpc3RlbmVyIiwicmVkaXJlY3RUb0NoZWNrb3V0Iiwic2Vzc2lvbklkIiwidGhlbiIsInJlc3VsdCIsImVycm9yIiwiZGlzcGxheUVycm9yIiwidGV4dENvbnRlbnQiLCJtZXNzYWdlIl0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7QUFBQSx1Qzs7Ozs7Ozs7Ozs7QUNBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBQSxtQkFBTyxDQUFDLDhDQUFELENBQVAsQyxDQUVBOzs7QUFDQSxJQUFNQyxDQUFDLEdBQUdELG1CQUFPLENBQUMsb0RBQUQsQ0FBakI7O0FBQ0FFLE1BQU0sQ0FBQ0QsQ0FBUCxHQUFXQyxNQUFNLENBQUNDLE1BQVAsR0FBZ0JGLENBQTNCOztBQUNBRCxtQkFBTyxDQUFDLDhEQUFELENBQVA7O0FBQ0FBLG1CQUFPLENBQUMsZ0VBQUQsQ0FBUCxDLENBRUE7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LEVBQUUsR0FBR25DLENBQUMsQ0FBQyxrQkFBRCxDQUFELENBQXNCb0MsSUFBdEIsQ0FBMkIsU0FBM0IsQ0FBVDtBQUNBLE1BQUlDLFVBQVUsR0FBR3JDLENBQUMsQ0FBQyxrQkFBRCxDQUFELENBQXNCb0MsSUFBdEIsQ0FBMkIsU0FBM0IsQ0FBakI7O0FBQ0EsTUFBR0QsRUFBSCxFQUFNO0FBQ0YsUUFBSUcsTUFBTSxHQUFHQyxNQUFNLENBQUNKLEVBQUQsQ0FBbkI7QUFDSDs7QUFFRCxNQUFJSyxjQUFjLEdBQUcvQixRQUFRLENBQUNDLGNBQVQsQ0FBd0IsaUJBQXhCLENBQXJCO0FBQ0E4QixnQkFBYyxDQUFDQyxnQkFBZixDQUFnQyxPQUFoQyxFQUF5QyxZQUFZO0FBQ2pEO0FBQ0E7QUFDQUgsVUFBTSxDQUFDSSxrQkFBUCxDQUEwQjtBQUN0QkMsZUFBUyxFQUFFTjtBQURXLEtBQTFCLEVBR0NPLElBSEQsQ0FHTSxVQUFVQyxNQUFWLEVBQWtCO0FBQ3BCLFVBQUlBLE1BQU0sQ0FBQ0MsS0FBWCxFQUFrQjtBQUNkO0FBQ0E7QUFDQSxZQUFJQyxZQUFZLEdBQUd0QyxRQUFRLENBQUNDLGNBQVQsQ0FBd0IsZUFBeEIsQ0FBbkI7QUFDQXFDLG9CQUFZLENBQUNDLFdBQWIsR0FBMkJILE1BQU0sQ0FBQ0MsS0FBUCxDQUFhRyxPQUF4QztBQUNIO0FBQ0osS0FWRDtBQVdILEdBZEQ7QUFnQkgsQ0F4QkQsRSIsImZpbGUiOiJhcHAuanMiLCJzb3VyY2VzQ29udGVudCI6WyIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW4iLCIvKlxyXG4gKiBXZWxjb21lIHRvIHlvdXIgYXBwJ3MgbWFpbiBKYXZhU2NyaXB0IGZpbGUhXHJcbiAqXHJcbiAqIFdlIHJlY29tbWVuZCBpbmNsdWRpbmcgdGhlIGJ1aWx0IHZlcnNpb24gb2YgdGhpcyBKYXZhU2NyaXB0IGZpbGVcclxuICogKGFuZCBpdHMgQ1NTIGZpbGUpIGluIHlvdXIgYmFzZSBsYXlvdXQgKGJhc2UuaHRtbC50d2lnKS5cclxuICovXHJcblxyXG4vLyBhbnkgQ1NTIHlvdSByZXF1aXJlIHdpbGwgb3V0cHV0IGludG8gYSBzaW5nbGUgY3NzIGZpbGUgKGFwcC5jc3MgaW4gdGhpcyBjYXNlKVxyXG5yZXF1aXJlKCcuLi9jc3MvYXBwLnNjc3MnKTtcclxuXHJcbi8vIE5lZWQgalF1ZXJ5PyBJbnN0YWxsIGl0IHdpdGggXCJ5YXJuIGFkZCBqcXVlcnlcIiwgdGhlbiB1bmNvbW1lbnQgdG8gcmVxdWlyZSBpdC5cclxuY29uc3QgJCA9IHJlcXVpcmUoJ2pxdWVyeScpO1xyXG5nbG9iYWwuJCA9IGdsb2JhbC5qUXVlcnkgPSAkO1xyXG5yZXF1aXJlKCdwb3BwZXIuanMnKTtcclxucmVxdWlyZSgnYm9vdHN0cmFwJyk7XHJcblxyXG4vLyByZXF1aXJlKCdAZm9ydGF3ZXNvbWUvZm9udGF3ZXNvbWUtZnJlZS9jc3MvYWxsLm1pbi5jc3MnKTtcclxuLy9yZXF1aXJlKCdAZm9ydGF3ZXNvbWUvZm9udGF3ZXNvbWUtZnJlZS9qcy9hbGwuanMnKTtcclxuXHJcbmNvbnNvbGUubG9nKCdIZWxsbyBXZWJwYWNrIEVuY29yZSEgRWRpdCBtZSBpbiBhc3NldHMvanMvYXBwLmpzJyk7XHJcblxyXG4vL2JhbmllcmUgYWNjdWVpbCBhbmltYXRpb24gLS1cclxudmFyIHRleHQxID0gW1wiR0FNTUVcIiwgXCJHQU1NRVwiLCBcIkdBTU1FXCJdO1xyXG52YXIgdGV4dDIgPSBbXCJJTkRVU1RSSUVTXCIsIFwiIEJJT01BU1NFXCIsIFwiQUdST0FMSU1FTi4uXCJdO1xyXG52YXIgY291bnQgPSAyO1xyXG5zZXRJbnRlcnZhbCgoKSA9PiB7XHJcbiAgY291bnQtLTtcclxuICBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgndGV4dC0xJykuaW5uZXJIVE1MPSB0ZXh0MVtjb3VudF07XHJcbiAgZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ3RleHQtMi1zcGFuJykuaW5uZXJIVE1MPSB0ZXh0Mltjb3VudF07XHJcbiAgaWYoY291bnQgPT0gMCl7XHJcbiAgICBjb3VudCA9IDM7XHJcbiAgfVxyXG59LCA3MDAwKTtcclxuXHJcbi8vXHJcblxyXG4vL2pRdWVyeSB0byBjb2xsYXBzZSB0aGUgbmF2YmFyIG9uIHNjcm9sbFxyXG4kKHdpbmRvdykuc2Nyb2xsKGZ1bmN0aW9uKCkge1xyXG4gICAgaWYgKCQoXCIubmF2YmFyXCIpLm9mZnNldCgpLnRvcCA+IDUwKSB7XHJcbiAgICAgICQoXCIubWVudVwiKS5hZGRDbGFzcyhcImZpeGVkXCIpO1xyXG4gICAgfSBlbHNlIHtcclxuICAgICAgJChcIi5tZW51XCIpLnJlbW92ZUNsYXNzKFwiZml4ZWRcIik7XHJcbiAgICB9XHJcbn0pO1xyXG5cclxuLy90YWJiYXIgXHJcblxyXG4kKCcjbXlOYXZUYWJzIGEnKS5jbGljayhmdW5jdGlvbiAoZXZ0KSB7XHJcbiAgZXZ0LnByZXZlbnREZWZhdWx0KCk7XHJcbiAgJCh0aGlzKS50YWIoJ3Nob3cnKTtcclxufSk7XHJcblxyXG4kKCdhW2RhdGEtdG9nZ2xlPVwidGFiXCJdJykub24oJ3Nob3duLmJzLnRhYicsIGZ1bmN0aW9uIChlKSB7XHJcbiAgLy9uZXcgdGFiXHJcbiAgY29uc29sZS5sb2coZS50YXJnZXQpO1xyXG4gIFxyXG4gIC8vcHJldmlvdXMgdGFiXHJcbiAgY29uc29sZS5sb2coZS5yZWxhdGVkVGFyZ2V0KTtcclxufSlcclxuXHJcbi8vIFNMSURFUlxyXG4kKCcuY2Fyb3VzZWwnKS5jYXJvdXNlbCh7XHJcbiAgaW50ZXJ2YWw6IDUwMDBcclxufSlcclxuLy9FTkQgU0xJREVSXHJcblxyXG5cclxuLy8gIGFjY29yZGVvbiBjYXJhY3RlcmlzdGlxdWUgcHJvZHVpdFxyXG5cclxuJChcIi5hY2NvcmRpYW5cIikub24oXCJjbGlja1wiLCBcIi5hY2NvcmRpYW4tdGl0bGVcIiwgZnVuY3Rpb24gKCkge1xyXG4gICQodGhpcykudG9nZ2xlQ2xhc3MoXCJhY3RpdmVcIikubmV4dCgpLnNsaWRlVG9nZ2xlKDUwMCk7XHJcbn0pO1xyXG5cclxuLy8gSE9WRVIgRUZGRUNUIERJViBcclxuJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24gKCkge1xyXG4gICQoJy5ob3Zlci1kaXYnKS5ob3ZlcihmdW5jdGlvbiAoKSB7XHJcbiAgICAgICQoJy5ob3Zlci1kaXYnKS5zdG9wKCkuZmFkZVRvKCdmYXN0JywgMC4zKTtcclxuICAgICAgJCh0aGlzKS5zdG9wKCkuZmFkZVRvKCdmYXN0JywgMSk7XHJcbiAgfSwgZnVuY3Rpb24gKCkge1xyXG4gICAgICAkKCcuaG92ZXItZGl2Jykuc3RvcCgpLmZhZGVUbygnZmFzdCcsIDEpO1xyXG4gIH0pO1xyXG59KTtcclxuXHJcbi8vIFNUUklQRSBDSEVDS09VVFxyXG4kKGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpe1xyXG4gICAgdmFyIHBrID0gJCgnI2NoZWNrb3V0LWJ1dHRvbicpLmF0dHIoJ2RhdGEtcGsnKTtcclxuICAgIHZhciBzZXNzaW9uX2lkID0gJCgnI2NoZWNrb3V0LWJ1dHRvbicpLmF0dHIoJ2RhdGEtaWQnKTtcclxuICAgIGlmKHBrKXtcclxuICAgICAgICB2YXIgc3RyaXBlID0gU3RyaXBlKHBrKTtcclxuICAgIH1cclxuXHJcbiAgICB2YXIgY2hlY2tvdXRCdXR0b24gPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnY2hlY2tvdXQtYnV0dG9uJyk7XHJcbiAgICBjaGVja291dEJ1dHRvbi5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGZ1bmN0aW9uICgpIHtcclxuICAgICAgICAvLyBXaGVuIHRoZSBjdXN0b21lciBjbGlja3Mgb24gdGhlIGJ1dHRvbiwgcmVkaXJlY3RcclxuICAgICAgICAvLyB0aGVtIHRvIENoZWNrb3V0LlxyXG4gICAgICAgIHN0cmlwZS5yZWRpcmVjdFRvQ2hlY2tvdXQoe1xyXG4gICAgICAgICAgICBzZXNzaW9uSWQ6IHNlc3Npb25faWRcclxuICAgICAgICB9KVxyXG4gICAgICAgIC50aGVuKGZ1bmN0aW9uIChyZXN1bHQpIHtcclxuICAgICAgICAgICAgaWYgKHJlc3VsdC5lcnJvcikge1xyXG4gICAgICAgICAgICAgICAgLy8gSWYgYHJlZGlyZWN0VG9DaGVja291dGAgZmFpbHMgZHVlIHRvIGEgYnJvd3NlciBvciBuZXR3b3JrXHJcbiAgICAgICAgICAgICAgICAvLyBlcnJvciwgZGlzcGxheSB0aGUgbG9jYWxpemVkIGVycm9yIG1lc3NhZ2UgdG8geW91ciBjdXN0b21lci5cclxuICAgICAgICAgICAgICAgIHZhciBkaXNwbGF5RXJyb3IgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnZXJyb3ItbWVzc2FnZScpO1xyXG4gICAgICAgICAgICAgICAgZGlzcGxheUVycm9yLnRleHRDb250ZW50ID0gcmVzdWx0LmVycm9yLm1lc3NhZ2U7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9KTtcclxuICAgIH0pO1xyXG4gICAgXHJcbn0pOyJdLCJzb3VyY2VSb290IjoiIn0=