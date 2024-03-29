// Html elements
let monthBtn = document.getElementsByClassName("month-btn");
let mainContent = document.getElementById('main-content');
let cardContainer = document.getElementById('card-container');
let dates = cardContainer.children;

let logInBtn = document.getElementById('log-in');

let expandable = document.getElementById('expandable');
let overlay = document.getElementById('overlay');
let closeOverlayBtn = document.getElementById('close-overlay');
let cards = document.getElementsByClassName('card');
let editBtn = document.getElementsByClassName('edit-btn');

let filterBtn = document.getElementsByClassName('filter-button');

let months = ['January', 'February', 'March', 'May', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
let curMonth = 9;
let curFilter = ['None', 'None'];

// Waits until html elements are all loaded
window.onload = function() {
	monthClick();

	sortAnnouncement();
	floatAnnouncements();

	logInClick();
	expandAnnouncement();
	overlayClick();
	filterBtnClick();
}

// Adds the class selected to the month item clicked
function monthClick() {
	for(let i = 0; i < monthBtn.length; i++) {
		monthBtn[i].onclick = function() {
			curMonth = (i + 9);
			if(curMonth > 12) curMonth -= 12;

			// Removes class from all list items first
			for(let j = 0; j < monthBtn.length; j++) {
				monthBtn[j].classList.remove("selected");
			}

			// Adds class to clicked list item
			this.classList.add("selected");

			document.getElementById("month-title").innerText = this.innerText;

			// Resets filters
			curFilter[0] = 'None';
			curFilter[1] = 'None';
			filterBtn[0].innerText = filterBtn[0].classList[1];
			filterBtn[1].innerText = filterBtn[1].classList[1];

			resetFilter();

			floatAnnouncements();
		}
	}
}

// Sorts announcements based on current month
function sortAnnouncement() {
	let numVisible = dates.length;

	// If the date is part of the current month then set as visible, if not then invisible
	for	(let j = 0; j < dates.length; j++) {
		if (dates[j].classList.contains('month_' + curMonth)) {
			$(dates[j]).show('slow');
			dates[j].classList.add('visible');
			numVisible++;
		} else {
			$(dates[j]).hide('slow');
			dates[j].classList.remove('visible');
			numVisible--;
		}
	}

	// Display note if no announcements for corresponding month
	if (numVisible <= 0 && (curFilter[0] == 'None' && curFilter[1] == 'None')) {
		$('#no-content').show('slow');
	} else {
		$('#no-content').hide('slow');
	}
}

// Redirects to admin page
function logInClick() {
	if (!logInBtn) return;

	logInBtn.onclick = function() {
		window.location.href='protected/admin.php';
	}
}

// Expands the overlay
function openOverlay() {
		expandable.classList.add('half-screen');
		expandable.classList.remove('no-padding');
		overlay.classList.add('full-screen');
}

// Closes the overlay
function closeOverlay() {
	expandable.classList.remove('half-screen');
	expandable.classList.add('no-padding');
	overlay.classList.remove('full-screen');
}

// Updates overlay content to show announcement information
function expandAnnouncement() {
	for(let i = 0; i < cards.length; i++) {
		cards[i].onclick = function() {
			openOverlay();

			// Gets announcement information from clicked card
			category = this.children[0].innerText;
			group = this.children[1].innerText;
			title = this.children[2].innerText;
			time = this.children[3].innerText;
			room = this.children[4].innerText;
			content = this.children[5].innerText;
			date = this.parentElement.firstElementChild.innerText;
			month = this.parentElement.classList[2];

			// Updates content
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

// Closes overlay when it is clicked
function overlayClick() {
	overlay.onclick = function() {
		closeOverlay();
	}
}

// Aligns the announcements into 2 columns
function floatAnnouncements() {
	let float = 0;

	for(let i = 0; i < dates.length; i++) {
		dates[i].classList.remove('col-1');
		dates[i].classList.remove('col-2');

		if (dates[i].classList.contains('visible')) {
			switch(float) {
				case 0: {
					dates[i].classList.add('col-1');
					float++;
					break;
					}
				case 1: {
					dates[i].classList.add('col-2');
					float--;
					break;
				}
			}
		}
	}
}

// Displays filter dropdown when button clicked
function filterBtnClick() {
	for (let i = 0; i < filterBtn.length; i++) {
		filterBtn[i].onclick = function() {
			let content = this.nextElementSibling;
			
			// console.log(this);
			if(getComputedStyle(content).display == 'none')
				$(content).show('fast');
			else
				$(content).hide('fast');

			filterElementClick(i, this, this.classList[1]);
		}
	}
}

// Checks if any filter options are clicked, if yes then set filter
function filterElementClick(filterIndex, filter, type) {
	let filterElements = filter.parentElement.children[1].children;

	for (let i = 0; i < filterElements.length; i++) {
		filterElements[i].onclick = function() {
			$(this.parentElement).hide('slow');
			
			// Stops if the filter is already active
			if (this.innerText == curFilter[filterIndex]){
				return;
			}

			curFilter[filterIndex] = this.innerText;

			resetFilter();
			console.log(filter);
			// Sets filter
			if (curFilter[filterIndex] == 'None') {
				filter.innerText = type;
			} else {
				filter.innerText = this.innerText;
				addFilter();
			}
		}
	}
}

// Adds filter to currently visible cards
function addFilter() {
	category = curFilter[0].replace(/\s+/, '-');
	topic = curFilter[1].replace(/\s+/, '-');

	// Loops through all cards and adds class for non-visible cards
	for (let i = 0; i < cards.length; i++) {
		if (!cards[i].classList.contains('hidden-card') && cards[i].parentElement.classList.contains('visible')) {
			if(!(cards[i].classList.contains(category) && cards[i].classList.contains(topic))) {
				cards[i].classList.add('hidden-card');
			}
		}
	}

	let visible = false;

	// Loops through all announcements of a certain date to check if any are visible, if no visible cards then date is invisible too
	for (let i = 0; i < dates.length; i++) {
		visible = false;

		if (dates[i].classList.contains('visible')){
			for (let j = 1; j < dates[i].children.length; j++) {
				if (!dates[i].children[j].classList.contains('hidden-card')) {
					visible = true;
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

	// Realigns announcements
	floatAnnouncements();
}

// Removes hidden class on cards and redisplays announcements based on month
function resetFilter() {
	for (let i = 0; i < cards.length; i++) {
		$(cards[i]).show('slow');
		cards[i].classList.remove('hidden-card');
	}

	sortAnnouncement();
	floatAnnouncements();
}