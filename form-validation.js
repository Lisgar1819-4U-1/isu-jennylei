let title;
let date;
let time;
let category;
let organization;
let place;
let description;

let newGroup;

let textRegExp = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]*$/;
let dateRegExp = /^[12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/;
let timeRegExp = /^(0[1-9]|1[0-2]):(0[0-9]|[1-5][0-9])$/;
let selectRegExp = /^\d*$/;

let error = "";
let errorId = document.getElementById('errorId');

function validateCreate() {
	error = "";

	title = document.forms["create"]['title'].value;
	date = document.forms["create"]['date'].value;
	time = document.forms["create"]['time'].value;
	place = document.forms["create"]['location'].value;
	category = document.forms["create"]['category'].value;
	organization = document.forms["create"]['organization'].value;
	description = document.forms["create"]['description'].value;

	// Date cannot be before today
	// error = checkBeforeToday("date", date);

	// Select option must be a value
	// Date must be in syntax yyyy-mm-dd
	error = syntax("description", description, textRegExp);
	error = syntax("organization, team or group", organization, selectRegExp);
	error = syntax("category", category, selectRegExp);
	error = syntax("location", place, textRegExp);
	error = syntax("date", date, dateRegExp);
	error = syntax("title", title, textRegExp);

	// Length of input fields
	error = maxLength("description", description, 512);
	error = maxLength("location", place, 128);
	error = maxLength("title", title, 128);

	if (error.length > 0) {
		errorId.innerText = error; 
		errorId.style.top = 0; 

		return false; 
	}

	return true;
}

function validateNewGroup() {
	error = "";

	newGroup = document.forms["new-group"]['groupName'].value;

	error = syntax("name", newGroup, textRegExp);
	error = maxLength("name", newGroup, 128);

	if (error.length > 0) {
		errorId.innerText = error;
		errorId.style.top = 0;

		return false;
	}

	return true;
}

function maxLength(name, text, len) {
	if (text.length > len)
		error = "Length of " + name + " cannot be more than " + len + " characters";
	
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