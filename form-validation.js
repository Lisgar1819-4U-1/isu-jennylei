let createForm = document.getElementById('create-form');
let title = document.getElementsByName('title')[0];
let date = document.getElementsByName('date')[0];
let time = document.getElementsByName('time')[0];

let textRegExp = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]*$/;
let dateRegExp = /^[12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/;
let timeRegExp = /^(0[1-9]|1[0-2]):(0[0-9]|[1-5][0-9])$/;

let valid = true;

title.addEventListener("input", function (event) {
	value = true;

	// Each time the user types something, we check if the title field is valid.
	if (!(title.value.length > 0 && textRegExp.test(title.value)))
		valid = false;

	if (valid == false)
		title.classList.add('invalid');
}, false);

date.addEventListener("input", function (event) {
	value = true;

	// Each time the user types something, we check if the date field is valid.
	if (!(date.value.length > 0 && textRegExp.test(date.value)))
		valid = false;

	if (valid == false)
		date.classList.add('invalid');
}, false);

time.addEventListener("input", function (event) {
	value = true;

	// Each time the user types something, we check if the time field is valid.
	if (!(time.value.length > 0 && textRegExp.test(time.value)))
		valid = false;

	if (valid == false)
		time.classList.add('invalid');
}, false);

function addEvent(element, event, callback) {
  var previousEventCallBack = element["on"+event];
  element["on"+event] = function (e) {
    var output = callback(e);

    // A callback that returns `false` stops the callback chain
    // and interrupts the execution of the event callback.
    if (output === false) return false;

    if (typeof previousEventCallBack === 'function') {
      output = previousEventCallBack(e);
      if(output === false) return false;
    }
  }
};

// addEvent(createForm, "submit", function () {
//   var test = email.value.length === 0 || emailRegExp.test(email.value);

//   if (!test) {
//     // email.className = "invalid";
//     // error.innerHTML = "I expect an e-mail, darling!";
//     // error.className = "error active";

//     // Some legacy browsers do not support the event.preventDefault() method
//     return false;
//   } else {
//     // email.className = "valid";
//     // error.innerHTML = "";
//     // error.className = "error";
//   }
// });