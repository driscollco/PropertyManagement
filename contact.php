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
	        	<h1 class="tempHeader">Contact</h1>
            </div>
            
            <div class="wrapContentLeftContact">
            <p>We are conveniently located located in Kean University.</p>
            <p>Fill out the form below and one of our experts will contact you within the next 24 hours.</p>
			<div id="wrapContactForm">
            	<form action="#" method="post" onSubmit="">
                	<label for="contact_name">Name</label>
                    <input id="contact_name" name="contact_name" type="text" placeholder="John Doe" /><br/>
                	<label for="contact_email">Email</label>
                    <input id="contact_email" name="contact_email" type="text" placeholder="john@email.com" /><br/>
                	<label for="contact_phone">Phone</label>
                    <input type="text" id="contact_phone" name="contact_phone" placeholder="123-456-7890" /><br/>
                	<label for="contact_service">Service Interested In</label><br/>
                    <textarea id="contact_service" name="contact_service"></textarea><br/>
                    <input type="button" value="Submit"/><br/>                    
                </form>
            </div>
            </div>
            <div class="wrapContentRight">
            	<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Kean+University,+Morris+Avenue,+Union,+NJ&amp;aq=0&amp;oq=kean+un&amp;sll=40.519553,-74.269148&amp;sspn=0.069292,0.154324&amp;t=h&amp;ie=UTF8&amp;hq=&amp;hnear=&amp;ll=40.680378,-74.234319&amp;spn=0.006295,0.006295&amp;iwloc=A&amp;output=embed"></iframe><br /><small><a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=Kean+University,+Morris+Avenue,+Union,+NJ&amp;aq=0&amp;oq=kean+un&amp;sll=40.519553,-74.269148&amp;sspn=0.069292,0.154324&amp;t=h&amp;ie=UTF8&amp;hq=&amp;hnear=&amp;ll=40.680378,-74.234319&amp;spn=0.006295,0.006295&amp;iwloc=A" style="color:#0000FF;text-align:left">View Larger Map</a></small>
            </div>
        </div><!-- END content -->
    	
        <div id="footer">
            <?php require_once("footer.php"); ?>
        </div><!-- END footer -->
    </div><!-- END container -->
</body>
</html>