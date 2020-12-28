/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import './styles/sass/app/index.scss';
// const $ = require('jquery');

// // start the Stimulus application
// // import './bootstrap';
// global.$ = global.jQuery = $;

// -> Put our input DOM element into a jQuery Object
const $jqDate = jQuery('input[name="line[date]"]');

// -> Bind keyup/keydown to the input
$jqDate.bind('keyup', 'keydown', function (e) { // To accomdate for backspacing, we detect which key was pressed - if backspace, do nothing:
   if (e.which !== 8) {
      var numChars = $jqDate.val().length;
      if (numChars === 2 || numChars === 5) {
         var thisVal = $jqDate.val();
         thisVal += '/';
         $jqDate.val(thisVal);
      }
   }
});

// -> Test if letter is typing inside date input
$.fn.noMask = function (regex) {
   this.on("keypress", function (e) {
      if (regex.test(String.fromCharCode(e.which))) {
         return false;
      }
   });
}

// -> Call function noMask on this input
$('input[name="line[date]"]').noMask(/[a-zA-Z]/);


