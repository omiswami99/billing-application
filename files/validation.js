function signup() {

	var phone = document.getElementById('mobile').value;

	var regxPh = /^0?[6-9]\d{9}$/;

	if (regxPh.test(phone) && confirmPass() && confirmGst()) {

	}
	else if (regxPh.test(phone) == -1) {
		document.getElementById("mobile").style.borderBottom = "solid 2px red";
		document.getElementById("numberError").innerHTML = "Enter valid Phone";
		document.getElementById("numberError").style.visibility = "Visible";
		document.getElementById("numberError").style.color = "red";
		return false;

	} else {
		return false;
	}


}


function validatePassword() {
	var pass = document.getElementById('password').value;
	var passDiv = document.getElementById('passDiv');
	passDiv.style.display = "block";
	clear();
	if (pass == "") {
		passDiv.style.display = "none";
		document.getElementById("passNumber").style.color = "red";
		document.getElementById("passLetter").style.color = "red";
		document.getElementById("passSpecial").style.color = "red";
		document.getElementById("passLength").style.color = "red";
	}
	test1(pass);
	test2(pass);
	test3(pass);
	test4(pass);

	if (test1(pass) && test2(pass) && test3(pass) && test4(pass)) {
		document.getElementById("cpassError").innerHTML = "Password is Strong";
		document.getElementById("cpassError").style.color = "limegreen";
		document.getElementById("cpassError").style.visibility = "Visible";
		document.getElementById("password").style.borderColor = "black";
		passDiv.classList.add("animate-hide");
		document.getElementById('goUP').classList.add("go-up");
	} else {
		document.getElementById("cpassError").innerHTML = "Password is Week";
		document.getElementById("cpassError").style.color = "red";
		document.getElementById("cpassError").style.visibility = "Visible";
		passDiv.classList.remove("animate-hide");
		document.getElementById('goUP').classList.remove("go-up");
	}
}
function test1(pass) {

	if (pass.search(/[0-9]/) == -1) {
		document.getElementById("password").style = "border-color: red !important";
		document.getElementById("passNumber").style.color = "red";
		return false;
	} else {
		document.getElementById("passNumber").style.color = "limegreen";
		document.getElementById("password").style = "border-color: solid black !important";
		return true;
	}
}
function test2(pass) {

	if (pass.search(/[A-Z]/) == -1) {
		document.getElementById("password").style = "border-color: red !important";
		document.getElementById("passLetter").style.color = "red";
		return false;
	} else {
		document.getElementById("passLetter").style.color = "limegreen";
		document.getElementById("password").style = "border-color: solid black !important";
		return true;
	}
}
function test3(pass) {

	if (pass.search(/[!@#%^&(_+,;:]/) == -1) {
		document.getElementById("password").style = "border-color: red !important";
		document.getElementById("passSpecial").style.color = "red";
		return false;
	} else {
		document.getElementById("passSpecial").style.color = "limegreen";
		document.getElementById("password").style = "border-color: solid black !important";
		return true;
	}
}
function test4(pass) {

	if (pass.length < 8) {
		document.getElementById("password").style = "border-color: red !important";
		document.getElementById("passLength").style.color = "red";
		return false;
	} else {
		document.getElementById("passLength").style.color = "limegreen";
		document.getElementById("password").style = "border-color: solid black !important";
		return true;
	}
}

function confirmPass() {
	var pass = document.getElementById('password').value;
	var cpass = document.getElementById('cpassword').value;

	if (cpass == "") {
		document.getElementById("cpassError").style.color = "red";
		document.getElementById("cpassError").innerHTML = "Passwords are not matching";
		return false;
	}

	if (pass === cpass) {
		if (test1(cpass) && test2(cpass) && test3(cpass) && test4(cpass)) {
			document.getElementById("password").style.borderBottomColor = "black";
			document.getElementById("cpassword").style = "border-color: solid black !important";
			document.getElementById("cpassError").innerHTML = "Passwords are matched";
			document.getElementById("cpassError").style.visibility = "Visible";
			document.getElementById("cpassError").style.color = "limegreen";
			return true;
		} else {
			document.getElementById("cpassError").innerHTML = "Password is too Week, follow above instructions to create your password strong";
			document.getElementById("cpassError").style.visibility = "Visible";
			document.getElementById("cpassError").style.color = "red";
			return false;
		}
	}
	else {
		document.getElementById("cpassword").style.borderBottomColor = "red";
		document.getElementById("cpassError").innerHTML = "Passwords are not matching";
		document.getElementById("cpassError").style.visibility = "Visible";
		document.getElementById("cpassError").style.color = "red";

		return false;
	}

}


function confirmGst() {
	var gst = document.getElementById('gstNumber').value.toUpperCase();

	var regxGst = /^[0-9]{2}([0-9A-Z]){10}[0-9]Z[0-9]$/;

	if (regxGst.test(gst)) {
		document.getElementById("gstNumber").style.borderBottom = "2.3px solid #26f";
		document.getElementById("gstError").innerHTML = "";
		return true;
	}
	else {
		document.getElementById("gstNumber").style.borderBottom = "solid 2px red";
		document.getElementById("gstError").innerHTML = "Enter complete GSTIN number";
		document.getElementById("gstError").style.visibility = "Visible";
		document.getElementById("gstError").style.color = "red";
		return false;
	}
}
function uppercase() {
	GSTInNumber = document.getElementById('gstNumber');
	GSTInNumber.value = GSTInNumber.value.toUpperCase();
}
function clear() {
	var cpasss = document.getElementById('cpassword');
	cpasss.value = "";
}