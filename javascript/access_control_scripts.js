// JavaScript Document

function verifySignIn()
{
	var email = document.getElementById("email").value;
	var password = document.getElementById("password").value;
	var result = true;
	
	if(email == "" || email == null || password == "" || password == null) {
		result = false;
		document.getElementById("signinError").innerHTML = "username/password must not be empty";
	}
	
	return result;
}

function verifyRegisterForm() 
{
	var fname = document.getElementById("fname").value;
	var lname = document.getElementById("lname").value;
	var email = document.getElementById("email").value;
	var address = document.getElementById("address").value;
	var city = document.getElementById("city").value;
	var state = document.getElementById("state").value;
	var zip = document.getElementById("zip").value;
	var pass = document.getElementById("password").value;
	var cpass = document.getElementById("confirm_password").value;
	var rcode = document.getElementById("rcode").value;
	var role = document.getElementById("role").value;
	
	if(fname == "" || fname == null || lname == "" || lname == null ||
		email == "" || email == null || address == "" || address == null ||
		city == "" || city == null || state == "" || state == null ||
		zip == "" || zip == null || pass == "" || pass == null ||
		cpass == "" || cpass == null || rcode == "" || rcode == null ||
		role == "" || role == null) {
		
		document.getElementById("registrationError").innerHTML = "all fields are required";
		return false;
	}
	
	if(pass != cpass) {
		document.getElementById("registrationError").innerHTML = "passwords do not match";
		return false;
	}
}

function verifyEmail()
{
	var emailRegEx = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
	    
	if(document.getElementById("email").value.search(emailRegEx) == -1) {
    	document.getElementById("emailMessage").innerHTML = "invalid email format";
	} else {
		checkUserEmailNotAlreadyRegistered();
	}
} 

function checkUserEmailNotAlreadyRegistered()
{
    var email = document.getElementById("email").value;
	
    params  = "email=" + email;
    request = new ajaxRequest()
    request.open("POST", "ajax/check_user_email.php", true)
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    request.setRequestHeader("Content-length", params.length)
    request.setRequestHeader("Connection", "close")
    
    request.onreadystatechange = function()
    {
        if (this.readyState == 4)
            if (this.status == 200)
                if (this.responseText != null)
                    document.getElementById("emailMessage").innerHTML = this.responseText
    }
    request.send(params)
}

function ajaxRequest()
{
    try { var request = new XMLHttpRequest() }
    catch(e1) {
        try { request = new ActiveXObject("Msxml2.XMLHTTP") }
        catch(e2) {
            try { request = new ActiveXObject("Microsoft.XMLHTTP") }
            catch(e3) {
                request = false
    }   }   }
    return request
}