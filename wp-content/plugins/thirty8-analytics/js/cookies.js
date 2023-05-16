document.addEventListener("DOMContentLoaded", function() {
	const cookiePop = document.querySelector('.thirty8-cookiepop');
	// const myButtons = cookiePop.querySelectorAll('.cookie-choice');

	// myButtons.forEach((button) => {
	// 	button.addEventListener('click', () => {
	// 		cookiePop.style.display = 'none';
	// 		//redirect = 'https://google.com';
	// 		//window.location.href = redirect;
	// 	});
	// });

	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);

	if(urlParams.has('cookies')) {
		cookiePop.style.display = 'none';
	}
});