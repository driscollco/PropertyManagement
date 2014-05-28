<?php
require_once("functions.php");
$userid = $_SESSION['user_id'];


$sql = "SELECT * FROM users WHERE userid = '$userid'";
$result = queryMysql($sql);
$user = mysqli_fetch_assoc($result);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Tenant Portal</title>
<link rel="stylesheet" type="text/css" href="css/system_header_styles.css">
</head>

<body>
	<div id="wrapSystemHeader">
    	<ul>
        	<li class="businessServices"><a href="tenantprofile.php">Profile</a></li>
        	<li class="businessServices"><a href="tenantpayment.php?sort=All">Payment</a></li>
        	<li class="businessServices"><a href="tenantmaintenances.php">Maintenance</a></li>
        </ul>
	    <a href="logout.php"><img title="Log out" id="key_icon" src="graphics/key_icon.png" width="16" height="32" /></a>
    </div>
    
   <!-- <div id="welcome">
        <center><h1>Welcome, <?php echo $user['first']." ".$user['last']; ?></h1></center>
    </div>-->
</body>
</html>