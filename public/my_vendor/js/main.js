function numTelf(){
	document.getElementById('phone').addEventListener('input', function (e) {
		var x = e.target.value.replace(/\D/g, '').match(/(\d{0,4})(\d{0,4})/);
		e.target.value = !x[2] ? x[1] : '' + x[1] + ' ' + x[2] + (x[3] ? '-' + x[3] : '');
	  });
	}
	function numCed() {
		document.getElementById('cedula').addEventListener('input', function (e) {
			var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,6})(\d{0,5})/);
			e.target.value = !x[2] ? x[1] : '' + x[1] + ' - ' + x[2] + (x[3] ? ' - ' + x[3] : '');
		});
	}
	function soloNum(input){
		var regex = /[^0-9]/g;
		input.value = input.value.replace(regex, "");
	}
	function showValidationWindow() {
		var validationWindow = document.getElementById("validationWindow");
		validationWindow.style.display = "block";
		var delBtn = document.getElementById("delBtn");
		delBtn.style.display = "none";
	}
	function hideValidationWindow() {
		var validationWindow = document.getElementById("validationWindow");
		validationWindow.style.display = "none";
		var delBtn = document.getElementById("delBtn");
		delBtn.style.display = "block";
	} 
	function showValidationWindow2() {
		var validationWindow = document.getElementById("validationWindow2");
		validationWindow.style.display = "block";
		var delBtn = document.getElementById("delBtn");
		delBtn.style.display = "none";
	}
	function hideValidationWindow2() {
		var validationWindow = document.getElementById("validationWindow2");
		validationWindow.style.display = "none";
		var delBtn = document.getElementById("delBtn");
		delBtn.style.display = "block";
	}