let monthBtn = document.getElementsByClassName("month-btn");
let mainContent = document.getElementById('main-content');
let cardContainer = document.getElementById('card-container');
let logInBtn = document.getElementById('log-in');
let cancelLogInBtn = document.getElementById('cancel-log-in');
let expandable = document.getElementById('expandable');
let overlay = document.getElementById('overlay');
let closeOverlayBtn = document.getElementById('close-overlay');
let cards = document.getElementsByClassName('card');
let editBtn = document.getElementsByClassName('edit-btn');

let months = ['January', 'February', 'March', 'May', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
let curMonth = 9;
let curFilter = ['None', 'None'];

window.onload = function() {
	monthClick();

	sortAnnouncement();
	floatAnnouncements();

	logInClick();
	expandAnnouncement();
	overlayClick();
	filterBtnClick();
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

			// sortAnnouncement();
			resetFilter();
			floatAnnouncements();
		}
	}
}

function sortAnnouncement() {
	let numVisible = cardContainer.children.length;

	for	(let j = 0; j < cardContainer.children.length; j++) {
		if (cardContainer.children[j].classList.contains('month_' + curMonth)) {
			$(cardContainer.children[j]).show('slow');
			cardContainer.children[j].classList.add('visible');
			numVisible++;
		} else {
			$(cardContainer.children[j]).hide('slow');
			cardContainer.children[j].classList.remove('visible');
			numVisible--;
		}
	}

	if (numVisible <= 0 && (curFilter[0] == 'none' && curFilter[1] == 'none')) {
		$('#no-content').show('slow');
	} else {
		$('#no-content').hide('slow');
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

function logInClick() {
	if (!logInBtn) return;

	logInBtn.onclick = function() {
		// document.getElementById("log-in-container").style.top = 0;
		window.location.href='protected/admin.php';
	}
}

function openOverlay() {
		expandable.classList.add('half-screen');
		expandable.classList.remove('no-padding');
		overlay.classList.add('full-screen');
}

function closeOverlay() {
	expandable.classList.remove('half-screen');
	expandable.classList.add('no-padding');
	overlay.classList.remove('full-screen');
}

function expandAnnouncement() {
	for(let i = 0; i < cards.length; i++) {
		cards[i].onclick = function() {
			openOverlay();

			category = this.children[0].innerText;
			group = this.children[1].innerText;
			title = this.children[2].innerText;
			time = this.children[3].innerText;
			room = this.children[4].innerText;
			content = this.children[5].innerText;
			date = this.parentElement.firstElementChild.innerText;
			month = this.parentElement.classList[2];

			expandable.innerHTML = `
				<div class="close-overlay" id="close-overlay" onclick="closeOverlay()">&#10005;</div>

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
		closeOverlay();
	}
}

function floatAnnouncements() {
	let float = 0;

	for(let i = 0; i < cardContainer.children.length; i++) {
		cardContainer.children[i].classList.remove('col-1');
		cardContainer.children[i].classList.remove('col-2');

		if (cardContainer.children[i].classList.contains('visible')) {
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

function filterBtnClick() {
	let filterBtn = document.getElementsByClassName('filter-button');

	for (let i = 0; i < filterBtn.length; i++) {
		filterBtn[i].onclick = function() {
			let content = this.nextElementSibling;

			if(getComputedStyle(content).display == 'none')
				$(content).show('slow');
			else
				$(content).hide('slow');

			filterElementClick(i, this, this.classList[1]);
		}
	}
}

function filterElementClick(filterIndex, filter, type) {
	let filterElements = filter.parentElement.children[1].children;

	for (let i = 0; i < filterElements.length; i++) {
		filterElements[i].onclick = function() {
			$(this.parentElement).hide('slow');
			
			if (this.innerText == curFilter[filterIndex]){
				return;
			}

			curFilter[filterIndex] = this.innerText;

			resetFilter();
	console.log('asd');

			if (curFilter[filterIndex] == 'None') {
				filter.firstElementChild.innerText = type;
			} else {
				filter.firstElementChild.innerText = this.innerText;
				addFilter();
			}
		}
	}
}

function addFilter() {
	for (let i = 0; i < cards.length; i++) {
		if (!cards[i].classList.contains('hidden-card') && cards[i].parentElement.classList.contains('visible')) {
			if(!(cards[i].classList.contains(curFilter[0]) && cards[i].classList.contains(curFilter[1]))) {
				cards[i].classList.add('hidden-card');
			}
		}
	}

	let dates = cardContainer.children;
	let visible = false;

	for (let i = 0; i < dates.length; i++) {
		visible = false;

		if (dates[i].classList.contains('visible')){
			for (let j = 1; j < dates[i].children.length; j++) {
				if (!dates[i].children[j].classList.contains('hidden-card')) {
					visible = true;
					break;
				} else {
					$(dates[i].children[j]).hide('fast');
				}
			}

			if (!visible) {
				$(dates[i]).hide('slow');
				dates[i].classList.remove('visible');
			}
		}
	}

	floatAnnouncements();
}

function resetFilter() {
	// curFilter[0] = 'None';
	// curFilter[1] = 'None';

	for (let i = 0; i < cards.length; i++) {
		$(cards[i]).show('slow');
		cards[i].classList.remove('hidden-card');
	}

	sortAnnouncement();
	floatAnnouncements();
}