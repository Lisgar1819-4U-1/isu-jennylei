let monthBtn = document.getElementsByClassName("month-btn");
let mainContent = document.getElementById('main-content');
let cardContainer = document.getElementById('card-container');
let logInBtn = document.getElementById('log-in');
let cancelLogInBtn = document.getElementById('cancel-log-in');
let expandableAnnouncement = document.getElementById('expandable');
let overlay = document.getElementById('overlay');
let closeOverlayBtn = document.getElementById('close-overlay');
let cards = document.getElementsByClassName('card');
let editBtn = document.getElementsByClassName('edit-btn');

let months = ['January', 'February', 'March', 'May', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
let curMonth = 9;

window.onload = function() {
	monthClick();

	// createAnnouncement('lololo', 4, 1, 'contests', 'lisgar musical production', '251', '12:00 am');
	// createAnnouncement('lololo', 5, 1, 'contests', 'lisgar musical production', '251', '12:00 am');
	// createAnnouncement('lololo', 6, 1, 'contests', 'lisgar musical production', '251', '12:00 am');
	// createAnnouncement('lololo', 6, 1, 'contests', 'lisgar musical production', '251', '12:00 am');
	// createAnnouncement('lololo2', 5, 1, 'contests', 'lisgar musical production', '251', '12:00 am');
	// createAnnouncement('lololo2', 7, 1, 'contests', 'lisgar musical production', '251', '12:00 am');
	// createAnnouncement('lololo', 11, 1, 'contests', 'lisgar musical production', '251', '12:00 am');
	// createAnnouncement('lololo', 15, 1, 'contests', 'lisgar musical production', '251', '12:00 am');
	// createAnnouncement('lololo', 15, 1, 'contests', 'lisgar musical production', '251', '12:00 am');
	// createAnnouncement('lololo', 17, 1, 'contests', 'lisgar musical production', '251', '12:00 am');
	// createAnnouncement('lololo2', 31, 1, 'contests', 'lisgar musical production', '251', '12:00 am');

	sortAnnouncement();
	floatAnnouncements();

	editClick();
	logInClick();
	cancelLogInClick();
	expandAnnouncement();
	overlayClick();
	filterClick();
	// closeClick();
}

function monthClick() {
	for(let i = 0; i < monthBtn.length; i++) {

		monthBtn[i].onclick = function() {
			curMonth = (i + 9);
			if(curMonth > 12) curMonth -= 12;

			for(let j = 0; j < monthBtn.length; j++) {
				monthBtn[j].classList.remove("selected");
			}
			this.classList.add("selected");

			mainContent.getElementsByTagName("h3")[0].innerText = this.innerText;

			sortAnnouncement();
		}
	}
}

function sortAnnouncement() {
	for	(let j = 0; j < cardContainer.children.length; j++) {
		if (cardContainer.children[j].classList.contains('month_' + curMonth)) {
			$(cardContainer.children[j]).show('slow');
			cardContainer.children[j].classList.add('visible');
		} else {
			$(cardContainer.children[j]).hide('slow');
			cardContainer.children[j].classList.remove('visible');
		}
	}
}

function createAnnouncement(title, date, month, category, group, room, time) {
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
	createCard(index, title, date, month, category, group, room, time);
}

function createDate(date, month) {
	cardContainer.innerHTML += `
		<div class="dates ${date} ${month}">
			<h4 class="date">${date}</h4>
		</div>`;
}

/*
	Announcement information

	Title
	Date
	Time
	Category
	Group
*/
function createCard(num, title, date, month, category, group, room, time) {
	cardContainer.children[num].innerHTML += `
		<div class="card">
			<p class="card-info card-category border">${category}</p>
			<p class="card-info">${group}</p>

			<p class="card-title">${title}</p>

			<p class="card-info card-setting">${time}</p>
			<p class="card-info card-setting">Room ${room}</p>
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
	if(!cancelLogInBtn) return;

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
			// console.log(this);
			expandable.classList.add('half-screen');
			expandable.classList.remove('no-padding');
			overlay.classList.add('full-screen');

			category = this.children[0].innerText;
			group = this.children[1].innerText;
			title = this.children[2].innerText;
			time = this.children[3].innerText;
			room = this.children[4].innerText;
			content = this.children[5].innerText;
			date = this.parentElement.firstElementChild.innerText;
			month = this.parentElement.classList[2];

			expandable.innerHTML = `
				<div class="close-overlay" id="close-overlay" onclick="closeAnnouncement()">&#10005;</div>

				<p class="card-info border">${category}</p>
				<p class="card-info">${group}</p>

				<h4>${title}</h4>
				<p class="card-info">Date: ${months[curMonth]} ${date}</p>
				<p class="card-info">${time}</p>
				<br>

				<p class="card-info">${room}</p>
				<br>

				<p class="card-info">Description:</p>
				<p class="card-info" style="margin-left: 2em;">${content}</p>
			`;
		}
	}
}

function overlayClick() {
	overlay.onclick = function() {
		closeAnnouncement();
	}
}

function closeAnnouncement() {
	expandable.classList.remove('half-screen');
	expandable.classList.add('no-padding');
	overlay.classList.remove('full-screen');
}

function floatAnnouncements() {
	let float = 0;

	for(let i = 0; i < cardContainer.children.length; i++) {
		if (cardContainer.children[i].classList.contains('visible')) {
			cardContainer.children[i].classList.remove('col-1');
			cardContainer.children[i].classList.remove('col-2');

			switch(float) {
				case 0: {
					cardContainer.children[i].classList.add('col-1');
					float++;
					break;
					}
				case 1: {
					cardContainer.children[i].classList.add('col-2');
					float--;
					break;
				}
			}
		}
	}
}

function filterClick() {
	let filters = document.getElementsByClassName('filter-button');

	for (let i = 0; i < filters.length; i++) {
		filters[i].onclick = function() {
			let content = this.nextElementSibling;

			if(!content.style.display || content.style.display == 'none')
				$(content).show('fast');
			else
				$(content).hide('fast');
		}
	}
}

function editClick() {
	for (let i = 0; i < editBtn.length; i++) {
		$(editBtn[i]).click(function(e) {
			e.stopPropagation();
			// expandEdit(this);
			console.log(this);
		});
	}
}