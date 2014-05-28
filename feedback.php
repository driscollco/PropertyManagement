
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Feedback</title>
<!-- this stylesheet is for the header -->
<link rel="stylesheet" type="text/css" href="css/system_header_styles.css">

<!-- this stylesheet is for the container write your css in this file: main_system_styles.css -->
<link rel="stylesheet" type="text/css" href="css/main_system_styles.css">
</head>
<script text="text/javascript">
function loadProfile() {

// you can start writing your php code here
	<?php
		require_once("db.php");
		$GLOBALS['Id'] =$_GET['id'];
		$GLOBALS['maintenanceInformation']= get($link, "SELECT M.maintenanceReportID, B.name AS buildingName,M.buildingID as buildingId,I.name AS issueName, S.statusName, U.userID,U.first as firstName,U.last as lastName,M.feedback as feedback
		FROM maintenance_report M
		LEFT JOIN building B On B.buildingID = M.buildingID
		LEFT JOIN issue_type I ON I.issueID = M.issueID
		LEFT JOIN maintenance_status S ON S.maintenanceStatusID = M.maintenanceStatusID
		LEFT JOIN users U ON U.userID = M.userID
		WHERE M.maintenanceReportID = '$Id'");
	
		?>
	}

function updateMaintenanceStatusActive()
	{
		<?php
			update($link, "UPDATE maintenance_report SET maintenanceStatusID =1 WHERE maintenancereportID = $Id;");
		?>
		window.close();
	}
	
function updateMaintenanceStatusCompleted()
	{
		<?php
			update($link, "UPDATE maintenance_report SET maintenanceStatusID =2 WHERE maintenancereportID = $Id;");
		?>
		close();
	}
</script>
<body onload="loadProfile()">
	<div id="wrapSystemHeader" >
        <div id="header">
            <ul><!-- these are the links that are displayed in the header bar, modify as needed -->
                <li class="businessServices"><a href="Finance.php">Finance</a></li>                                     
                <li class="businessServices"><a href="maintenance.php">Maintenance</a></li>
                <li class="businessServices"><a href="parking.php?building=All&status=All&search=">Parking</a></li>
                <li class="businessServices"><a href="rent.php?building=All&status=All&search=">Rent</a></li>
                          
            </ul>
            <!-- the log out icon -->
            <a href="logout.php"><img title="Log out" id="key_icon" src="graphics/key_icon.png" width="16" height="32" /></a>
        </div>
    </div>

    <div id="container">
        <!-- Place your html code here -->
        <center> <h2>Customers Feedback & Details</h2> 
		<p></p>
		User Id: <?php echo $Id; ?>
		<p></p>
		Name: <?php echo $maintenanceInformation['firstName']." ".$maintenanceInformation['lastName']; ?>
		<p></p>
		Building Id: <?php echo $maintenanceInformation['buildingId']; ?>
		<p></p>
		Maintenance Type : Water flooding
		<p></p>
		<u><h4><b>Feedback</b></h4></u>
		<p></p>
		<textarea readonly id="feedbackarea" rows="10" cols="40"><?php echo $maintenanceInformation['feedback']; ?></textarea>
		<p></p>
		<form action="activeMaintenance.php" method="POST">
		<input type="hidden" name="id" value="<?php echo $Id; ?>">
		<input class="inputButton" type="submit" value="Active"/>
		</form>
		<br />
		<form action="completedMaintenance.php" method="POST">
		<input type="hidden" name="id" value="<?php echo $Id; ?>">
		<input class="inputButton" type="submit" value="Completed"/>
		</form>
	</center>
    
    
    </div>
</body>
</html>