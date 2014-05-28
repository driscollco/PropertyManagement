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
        	<!--<img id="homeImg" src="graphics/pm_pic_00.jpg" width="960" height="460" />-->
            <ul class="slider">
               <li>
                 <img src="graphics/pm_pic_00.jpg" />
               </li>
               <li>
                 <img src="graphics/pm_pic_01.jpg" />
               </li>
               <li>
                 <img src="graphics/pm_pic_02.jpg" />
               </li>
               <li>
                 <img src="graphics/pm_pic_03.jpg" />
               </li>
               <li>
                 <img src="graphics/pm_pic_04.jpg" />
               </li>               
     		</ul>
            
            <div id="wrapHomeText">
            	<h1 id="homeTextHeader">Property Management</h1>
                <p>Property Management Inc. takes an innovative approach to apartment management. Our unique services utilize our many years of experience managing properties in several locations.</p>

<p>We take personal service to a new height with customization that combines personalized management plans with a wide network of brokers to secure premium rental rates.</p>

<p>There’s no job too big or small for Property Management Inc. Whether you’re an owner who wants to rent out a single condo or you own a building with hundreds of units, we’ll design a personalized plan to meet your needs and goals. Nowhere else will you find such detailed personal service.</p>
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