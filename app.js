let monthBtn = document.getElementsByClassName("month-btn");
let mainContent = document.getElementById('main-content');
let cardContainer = document.getElementById('card-container');
let logInBtn = document.getElementById('log-in');
let cancelLogInBtn = document.getElementById('cancel-log-in');

window.onload = function() {
	monthClick();

	createAnnouncement('lololo', 4, 1);
	createAnnouncement('lololo', 5, 1);
	createAnnouncement('lololo2', 5, 1);
	createAnnouncement('lololo2', 5, 2);

	sortAnnouncement(0);

	logInClick();
	cancelLogInClick();
}

function monthClick() {
	for(let i = 0; i < monthBtn.length; i++) {

		monthBtn[i].onclick = function() {
			for(let j = 0; j < monthBtn.length; j++) {
				monthBtn[j].classList.remove("selected");
			}
			this.classList.add("selected");

			mainContent.getElementsByTagName("h3")[0].innerText = this.innerText;

			sortAnnouncement(i);
		}
	}
}

function sortAnnouncement(i) {
	for	(let j = 0; j < cardContainer.children.length; j++) {
		cardContainer.children[j].style.display = 'block';

		if (cardContainer.children[j].classList[2] != i + 1) {
			cardContainer.children[j].style.display = 'none';
		}
	}
}

function createAnnouncement(title, date, month) {
	console.log(date);
	let index = 0;
	let exists = false;

	if (cardContainer.children.length == 0) {
		exists = false;
	} else {
		for (let i = 0; i < cardContainer.children.length; i++) {
			if (cardContainer.children[i].classList[1] == date && cardContainer.children[i].classList[2] == month) {
				index = i;
				exists = true;
				console.log(date + ': ' + index);
			}
		}
	}

	if (!exists) {
		createDate(date, month);
		index = cardContainer.children.length - 1;
	}

	console.log(date + ": " + index);
	createCard(index, title, date, month);
}

function createDate(date, month) {
	cardContainer.innerHTML += `
		<div class="dates ${date} ${month}">
			<h4 class="date">${date}</h4>
		</div>`;
}

function createCard(i, title, date, month) {
	cardContainer.children[i].innerHTML += `
		<div class="card">
			<p class="card-title">${title}</p>
		</div>`;
}

function logInClick() {
	logInBtn.onclick = function() {
		document.getElementById("log-in-container").style.display = "block";
	}
}

function cancelLogInClick() {
	cancelLogInBtn.onclick = function() {
		document.getElementById("log-in-container").style.display = "none";

		document.getElementsByName('email')[0].value = "";
		document.getElementsByName('password')[0].value = "";
	}
}