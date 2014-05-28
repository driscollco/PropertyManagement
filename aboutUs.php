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
        	<div class="wrapContentTop">
	        	<h1 class="tempHeader">About Us</h1>
            </div>
            
            <div class="wrapContentLeft">
            	<p>Property Management Inc. has been a leading property management company for many years. Our unique capabilities enable us to manage your local properties with the same expertise and reliability that we employ on a national level. This mix of local market knowledge and nationwide reach are what set us apart in the property management industry. </p>
                <p>Your local Property Management teams consists of highly-trained experts in every aspect of property management, including marketing, leasing, maintenance, collections, evictions, accounting, inspections, and legal compliance.</p>
            </div>
            <div class="wrapContentRight">
                <ul id="aboutSlider" class="slider">
                   <li>
                     <img src="graphics/about_pic_01.jpg" />
                   </li>
                   <li>
                     <img src="graphics/about_pic_02.jpg" />
                   </li>
                   <li>
                     <img src="graphics/about_pic_03.jpg" />
                   </li>
                </ul>
            </div>


        </div><!-- END content -->
    	
        <div id="footer">
            <?php require_once("footer.php"); ?>
        </div><!-- END footer -->
    </div><!-- END container -->
    
<script src="javascript/jquery-1.10.2.js"></script>
<script src="javascript/slideshow.js"></script>
</body>
</html>