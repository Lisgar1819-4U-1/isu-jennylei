let title;
let date;
let time;
let category;
let organization;

let textRegExp = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]*$/;
let dateRegExp = /^[12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/;
let timeRegExp = /^(0[1-9]|1[0-2]):(0[0-9]|[1-5][0-9])$/;
let selectRegExp = /^\d*$/;

let error = "";
let errorId = document.getElementById('errorId');

function validate() {
	error = "";

	title = document.forms["create"]['title'].value;
	date = document.forms["create"]['date'].value;
	time = document.forms["create"]['time'].value;
	category = document.forms["create"]['category'].value;
	organization = document.forms["create"]['organization'].value;

	// Date cannot be before today
	// error = checkBeforeToday("date", date);

	// Select option must be a value
	// Date must be in syntax yyyy-mm-dd
	error = syntax("organization, team or group", organization, selectRegExp);
	error = syntax("category", category, selectRegExp);
	error = syntax("date", date, dateRegExp);
	error = syntax("title", title, textRegExp);

	// Length of input fields
	error = maxLength("date", date, 10);
	error = maxLength("title", title, 10);

	if (error.length > 0) {
		errorId.innerText = error; 
		errorId.style.top = 0; 

		return false; 
	}; 

	return true;
} 

function maxLength(name, text, len) {
	if (text.length > len)
		error = "Length of input field : " + name + " cannot be more than " + len;
	
	return error;
}

function syntax(name, text, regex) {
	if (!regex.test(text))
		error = "Invalid " + name;
	
	return error;
}

function checkBeforeToday(name, text) {
	utcDate = new Date(text); //Date object a day behind
	var date = new Date(utcDate.getTime() + utcDate.getTimezoneOffset() * 60000) //local Date
	var today = new Date(new Date().toDateString());;

	if (date.getTime() < today.getTime())
		error = "The date field : " + name + " cannot be before today<br/>";
	
	return error;
}