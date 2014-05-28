<?php
require_once("functions.php");

class SignIn
{
	// empty constructor
	function __construct()
	{
		
	}
	
	// validate user for sign in, if user is valid return true
	function validateUser($email, $pass)
	{
		$email = sanitizeString($email);
		$pass = sanitizeString($pass);
	
		$sql = "SELECT email, password FROM login WHERE email = '".$email."' AND password = '".$pass."' LIMIT 1";
		$query = queryMysql($sql); 
		
		if(mysqli_num_rows($query) == 1) {
			$row = mysqli_fetch_assoc($query);
			return true;
		}
		return false;
	}
}


$message = "";

if(isset($_POST['email'])  && isset($_POST['password'])) {
	
	$signIn_object = new SignIn();
	
	if($signIn_object->validateUser($_POST['email'], $_POST['password'])) {
	
		//$message = "welcome, login is valid";	
		$res = queryMysql("SELECT userid, accessID FROM users where email='".$_POST['email']."'");
		$rec = mysqli_fetch_assoc($res);
		$id = $rec['userid'];
		$accessID = $rec['accessID'];
		
		// set a session variable with the user id
		$_SESSION['user_id'] = $id;

		switch ($accessID)
		{
			case 1: // user is a tenant
			  header("Location: tenantprofile.php");
			  break;
			case 2: // user is a manager
			 	header("Location: maintenance.php");
			  break;
			case 3: // user is an owner
			  $message = "owner's page is not yet available";
			  break;
			default:
			  $message = "an unknown error occured please tell an administrator";
		}
	
	} else {
	
		$message = "username/password is not valid";	
	}
}
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Property Management</title>
<link href="css/main_styles.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="container">
    	<div id="header">
        	<?php require_once("navigation.php"); ?>
        </div><!-- END header -->
        
        <div id="content">
        	<h1 id="signInHeader">Property Management</h1>
        	<div id="wrapSignIn">
            	<form id="sign_in_form" name="sign_in_form" action="signIn.php" method="post" onSubmit="return verifySignIn();">
            		<label class="formLabel" for="email">Email:</label>
                	<input class="formTextField" id="email" name="email" type="text"><br/>
                    <label class="formLabel" for="password">Password:</label>
                	<input class="formTextField" id="password" name="password" type="password"><br/>
                    <div id="wrapErrorMessage">
                    	<span id="signinError"><?php if($message != "") {echo $message;} ?></span>
                    </div>
                    
                    <div class="wrapFormButtons">
                    	<input class="formButton" type="submit" value="Log In">
                    	<a id="registerLink" href="register.php"><input class="formButton" type="button" value="Register"></a>
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