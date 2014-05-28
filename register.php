<?php
require_once("functions.php");

class Register
{
	function __construct() 
	{
		
	}
	

	function registerUser($fname, $lname, $email, $pass, $phone, $address, $suite, $city, $state, $zip, $role, $rcode)
	{
		$userid = $this->getUserId();
		$fname = sanitizeString($fname);
		$lname = sanitizeString($lname);
		$email = sanitizeString($email);
		$pass = sanitizeString($pass);
		
		$address = sanitizeString($address);
		$suite = sanitizeString($suite);;
		$city = sanitizeString($city);
		$state = sanitizeString($state);
		$zip = sanitizeString($zip);
		$phone = sanitizeString($phone);
		$phone = preg_replace('/\D+/', '', $phone);
		$rcode = sanitizeString($rcode);
		
		// role: 1 = tenant, 2 = manager, 3 = owner
		$accessID = sanitizeString($role);
		
		$sql = "INSERT INTO `login` (`userID`, `email`, `password`) VALUES ('$userid', '$email', '$pass')";
		$result = queryMysql($sql);
		
		if($result) {
			$sql = "INSERT INTO `users` (`userid`, `email`, `first`, `last`, `accessID`, `city`, `state`, `zip`, `address`, `suite`, `phone`) VALUES ('$userid', '$email', '$fname', '$lname', '$accessID', '$city', '$state', '$zip', '$address', '$suite', '$phone')";
			$result = queryMysql($sql);
		}
		
		if($result) {
			
			// set a session variable with the user's id
			$_SESSION['user_id'] = $userid;
			
			return true;
		} else {
			return false;	
		}
	}
	
	function getUserId() 
	{
		$sql = "SELECT COUNT(*) FROM login";
		$result = queryMysql($sql);
		$row = mysqli_fetch_row($result);
		$n = $row[0];
		$id = $n + 1;
		return $id;
	}
} // end register class
$fname = (isset($_POST['fname']))? $_POST['fname']:"";
$lname = (isset($_POST['lname']))? $_POST['lname']:"";
$email = (isset($_POST['email']))? $_POST['email']:"";
$phone = (isset($_POST['phone']))? $_POST['phone']:"";
$address = (isset($_POST['address']))? $_POST['address']:"";
$zip = (isset($_POST['zip']))? $_POST['zip']:"";
$city = (isset($_POST['city']))? $_POST['city']:"";

$message = "";

if(isset($_POST['fname'])  && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['address']) &&
isset($_POST['city']) && isset($_POST['state']) && isset($_POST['zip']) && isset($_POST['password']) && 
isset($_POST['rcode']) && isset($_POST['role'])) {
	
	$result = false;
	$email_error = false;
	
	// OPTIONAL FIELDS: $_POST['phone']) && $_POST['suite']
	if (mysqli_num_rows(queryMysql("SELECT * FROM users WHERE email='".$_POST['email']."'"))) {
		$email_error = true;
		$message = "that email already exists";
	
	} else {
		
		$register_object = new Register();
		$result = $register_object->registerUser($_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['password'], $_POST['phone'], $_POST['address'], '', $_POST['city'], $_POST['state'], $_POST['zip'], $_POST['role'], $_POST['rcode']);

	}


	if(!$email_error) {
		
		if($result) {
			
			if($_POST['role'] == 1) {
				header("Location: register2.php");
			} else {
				header("Location: confirmRegistration.php");
			}
		} else {
			$message = "registration error please contact an administrator";	
		}
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Register</title>
<link href="css/main_styles.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="container">
    	<div id="header">
        	<?php require_once("navigation.php"); ?>
        </div><!-- END header -->
        
        <div id="content">
        	<h1 id="registrationHeader">Property Management Registration</h1>
        	<div id="wrapRegister">
            	<form id="register_form" name="register_form" action="register.php" method="post" onSubmit="return verifyRegisterForm();">
                	<label class="registerFormLabel" for="fname">First Name:</label>
                	<input class="registerFormTextField" id="fname" name="fname" type="text" maxlength="30" value="<?php echo $fname; ?>">
                    <label id="registerFormLabelLastName" for="lname">Last Name:</label>
                	<input class="registerFormTextField" id="lname" name="lname" type="text" maxlength="30" value="<?php echo $lname; ?>"><br/>
            		<label class="registerFormLabel" for="email">Email:</label>
                	<input class="registerFormTextField" id="email" name="email" type="text" onBlur="verifyEmail();" maxlength="60" value="<?php echo $email; ?>">
                    <span id="emailMessage"></span><br/>
                    <label class="registerFormLabel" for="phone">Phone:</label>
                	<input class="registerFormTextField" id="phone" name="phone" type="text" maxlength="12" placeholder="123-456-7890" value="<?php echo $phone ?>"><br/>
                    
                    <label class="registerFormLabel" for="address">Address:</label>
                	<input class="registerFormTextField" id="address" name="address" type="text" maxlength="40" value="<?php echo $address;?>">
                    <!--<label id="registerFormLabelSuite" for="suite">Suite:</label>
                	<input class="registerFormTextField" id="suite" name="suite" type="text" maxlength="5">--><br/>
                    <label class="registerFormLabel" for="city">City:</label>
                	<input class="registerFormTextField" id="city" name="city" type="text" maxlength="20" value="<?php echo $city;?>">
                    <label id="registerFormLabelState" for="state">State:</label>
                	<select id="state" name="state">
                    	<option value=""></option>
  						<option value="CT">CT</option>
                        <option value="NJ">NJ</option>
                        <option value="NY">NY</option>
                        <option value="PA">PA</option>
                        <option value="MA">MA</option>
                    </select>
                    <label id="registerFormLabelZip" for="zip">Zip:</label>
                	<input class="registerFormTextField" id="zip" name="zip" type="text" maxlength="5" value="<?php echo $zip; ?>"><br/>
                    
                    <label class="registerFormLabel" for="password">Password:</label>
                	<input class="registerFormTextField" id="password" name="password" type="password" maxlength="40"><br/>
                    <label class="registerFormLabel" for="confirm_password">Confirm Password:</label>
                	<input class="registerFormTextField" id="confirm_password" name="confirm_password" type="password" max="40"><br/>
                    <label class="registerFormLabel" for="rcode">Registration Code:</label>
                	<input class="registerFormTextField" id="rcode" name="rcode" type="text" maxlength="3"><br/>
                    <label class="registerFormLabel" for="role">Role:</label>
                    <select id="role" name="role">
  						<option value=""></option>
                        <option value="1">Tenant</option>
                        <option value="2">Manager</option>
                        <option value="3">Owner</option>
                    </select>
                    
                    
                    <div id="wrapErrorMessage">
                    	<span id="registrationError"><?php if($message != "") {echo $message;} ?></span>
                    </div>
                    
                    <div id="wrapRegisterFormButtons">
                    	<input class="formButton" type="submit" value="Register">
                    	<a id="cancelRegisterLink" href="signIn.php"><input class="formButton" type="button" value="Cancel"></a>
                    </div>
            	</form>
            </div>
        </div><!-- END content -->
    	
        <div id="footer">
            <?php require_once("footer.php"); ?>
        </div><!-- END footer -->
    </div><!-- END container -->
    
<script src="javascript/access_control_scripts.js"></script>
</body>
</html>