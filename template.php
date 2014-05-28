<?php
require_once("functions.php");
/* 
use this template to start building your pages
simply go to file->save as-> and enter your file name
then add and modify as needed
*/

// you can start writing your php code here

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Page Title</title>
<!-- this stylesheet is for the header -->
<link rel="stylesheet" type="text/css" href="css/system_header_styles.css">

<!-- this stylesheet is for the container write your css in this file: main_system_styles.css -->
<link rel="stylesheet" type="text/css" href="css/main_system_styles.css">
</head>

<body>
	<!-- this div wraps the header on the top of the page -->
	<div id="wrapSystemHeader">
        <div id="header">
            <ul><!-- these are the links that are displayed in the header bar, modify as needed -->
               <!-- <li class="businessServices"><a href="#">Finance</a></li> -->
                <li class="businessServices"><a href="Finance.php">Finance</a></li>                                     
                <li class="businessServices"><a href="maintenance.php">Maintenance</a></li>
                <li class="businessServices"><a href="parking.php?building=All&status=All&search=">Parking</a></li>
                <li class="businessServices"><a href="rent.php?building=All&status=All&search=">Rent</a></li>                             
            </ul>
            <!-- the log out icon -->
            <a href="logout.php"><img title="Log out" id="key_icon" src="graphics/key_icon.png" width="16" height="32" /></a>
        </div>
    </div>
    
<!--    <div id="container">
        
        <h1 style="margin: 0; padding: 0;">Hello World</h1>
    
    
    </div> 
-->
</body>
</html>