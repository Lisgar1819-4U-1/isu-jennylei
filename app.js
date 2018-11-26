let monthBtn = document.getElementsByClassName("month-btn");
let mainContent = document.getElementById('main-content');

window.onload = function() {
	monthClick();
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