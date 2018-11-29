let monthBtn = document.getElementsByClassName("month-btn");
let mainContent = document.getElementById('main-content');
let cardContainer = document.getElementById('card-container');
let logInBtn = document.getElementById('log-in');
let cancelLogInBtn = document.getElementById('cancel-log-in');
let expandableAnnouncement = document.getElementById('expandable');
let overlay = document.getElementById('overlay');
let cards = document.getElementsByClassName('card');

let months = ['September', 'October', 'November', 'December', 'January', 'February', 'March', 'May', 'April', 'May', 'June', 'July', 'August'];

window.onload = function() {
	monthClick();

	createAnnouncement('lololo', 4, 1, 'contests', 'lisgar musical production');
	createAnnouncement('lololo', 5, 1, 'contests', 'lisgar musical production');
	createAnnouncement('lololo', 6, 2, 'contests', 'lisgar musical production');
	createAnnouncement('lololo2', 5, 1, 'contests', 'lisgar musical production');

	sortAnnouncement(0);

	logInClick();
	cancelLogInClick();
	expandAnnouncement();
	closeAnnouncement();
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

function createAnnouncement(title, date, month, category, group) {
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
	createCard(index, title, date, month, category, group);
}

function createDate(date, month) {
	cardContainer.innerHTML += `
		<div class="dates ${date} ${month}">
			<h4 class="date">${date}</h4>
		</div>`;
}

function createCard(i, title, date, month, category, group) {
	cardContainer.children[i].innerHTML += `
		<div class="card">
			<p class="card-info card-category border">${category}</p>
			<p class="card-info">${group}</p>
			<p class="card-title">${title}</p>
		</div>`;
}

function logInClick() {
	if (!logInBtn) return;

	logInBtn.onclick = function() {
		// document.getElementById("log-in-container").style.top = 0;
		document.getElementById("log-in-container").style.display = "block";
	}
}

function cancelLogInClick() {
	cancelLogInBtn.onclick = function() {
		// document.getElementById("log-in-container").style.top = "100%";
		document.getElementById("log-in-container").style.display = "none";

		document.getElementsByName('email')[0].value = "";
		document.getElementsByName('password')[0].value = "";
	}
}

function expandAnnouncement() {
	for(let i = 0; i < cards.length; i++) {
		cards[i].onclick = function() {
			console.log(this);
			expandable.classList.add('half-screen');
			expandable.classList.remove('no-padding');
			overlay.classList.add('full-screen');

			category = this.children[0].innerText;
			group = this.children[1].innerText;
			title = this.children[2].innerText;
			date = this.parentElement.classList[1];
			month = this.parentElement.classList[2];

			expandable.innerHTML = `
				<p class="card-info border">${category}</p>
				<p class="card-info">${group}</p>

				<h4>${title}</h4>
				<p class="card-info">Date: ${months[month-1]} ${date}</p>
				<br>

				<p class="card-info">Description:</p>
				<p class="card-info" style="margin-left: 2em;">asdlhgf;alshhgll;hdlshkglhsa;glsgd</p>
			`;
		}
	}
}

function closeAnnouncement() {
	overlay.onclick = function() {
		expandable.classList.remove('half-screen');
		expandable.classList.add('no-padding');
		overlay.classList.remove('full-screen');
	}
}