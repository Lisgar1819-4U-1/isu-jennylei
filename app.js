let monthBtn = document.getElementsByClassName("month-btn");
let mainContent = document.getElementById('main-content');
let cardContainer = document.getElementById('card-container');

window.onload = function() {
	monthClick();
	createAnnouncement('lololo', 4, '1');
	createAnnouncement('lololo', 5, '1');
	// createAnnouncement('lololo', 6, '1');
}

function monthClick() {
	for(let i = 0; i < monthBtn.length; i++) {

		monthBtn[i].onclick = function() {
			for(let j = 0; j < monthBtn.length; j++) {
				monthBtn[j].classList.remove("selected");
			}
			this.classList.add("selected");

			mainContent.getElementsByTagName("h3")[0].innerText = this.innerText;
		}
	}
}

function createAnnouncement(title, date, month) {
	let index = 0;
	let exists = false;

	if (cardContainer.children.length == 0) {
		exists = false;
	} else {
		for (let i = 0; i < cardContainer.children.length; i++) {
			if (cardContainer.children[i].classList[2] == date) {
				index = i;
				exists = true;
			}
		}
	}

	if (!exists) {
		createCard(date, month);
		index = cardContainer.children.length;
		console.log(cardContainer.children.length);
	}

	console.log(index);
	createCard(index, title, date, month);
}

function createDate(date, month) {
	cardContainer.innerHTML += `
		<div class="dates ${month} ${date}">
			<h4 class="date">${date}</h4>
		</div>`;
}

function createCard(i, title, date, month) {
	cardContainer.children[i].innerHTML += `
		<div class="card">
			<p class="card-title">${title}</p>
		</div>`;
}