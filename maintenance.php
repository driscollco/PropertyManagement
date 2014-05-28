
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Maintenance Information</title>
<!-- this stylesheet is for the header -->
<link rel="stylesheet" type="text/css" href="css/system_header_styles.css">
<link rel="stylesheet" type="text/css" href="css/maintenance.css">

<!-- this stylesheet is for the container write your css in this file: main_system_styles.css -->
<link rel="stylesheet" type="text/css" href="css/main_system_styles.css">
<script text="text/javascript">
function loadProfile() {

// you can start writing your php code here
	<?php
		require_once("db.php");
		$GLOBALS['emergencyReports']= getResultSet($link, 
		"SELECT M.maintenanceReportID, B.name AS buildingName, I.name AS issueName, S.statusName, U.userID
		FROM maintenance_report M
		LEFT JOIN building B On B.buildingID = M.buildingID
		LEFT JOIN issue_type I ON I.issueID = M.issueID
		LEFT JOIN maintenance_status S ON S.maintenanceStatusID = M.maintenanceStatusID
		LEFT JOIN users U ON U.userID = M.userID
		WHERE I.name = 'Emergency'");
		
		$GLOBALS['generalReports']= getResultSet($link, 
		"SELECT M.maintenanceReportID, B.name AS buildingName, I.name AS issueName, S.statusName, U.userID
		FROM maintenance_report M
		LEFT JOIN building B On B.buildingID = M.buildingID
		LEFT JOIN issue_type I ON I.issueID = M.issueID
		LEFT JOIN maintenance_status S ON S.maintenanceStatusID = M.maintenanceStatusID
		LEFT JOIN users U ON U.userID = M.userID
		WHERE I.name = 'General'");
		
		?>
	}
</script>
</head>


	
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
		<center>
		<p></p>
   <h2><b> Emergency Issues:</b></h2>
<table border="1px" width="500px">
	<tr>
		<td class="tableHeader"><b>Number </b></td> 
		<td class="tableHeader"><b>ISSUES</b></td>
		<td class="tableHeader"><b>USER ID</b></td>
		<td class="tableHeader"><b>STATUS</b></td>
		<td class="tableHeader"><b>Building</b></td>
	
	
	</tr>
		<?php
		foreach($emergencyReports as $emergency)
		{
			$id = $emergency['maintenanceReportID'];
			echo "<tr><td><a href='feedback.php?id=$id'>".$emergency['maintenanceReportID']."</a></td>";
			echo '<td>'.$emergency['issueName'].'</td>';
			echo '<td>'.$emergency['userID'].'</td>';
			echo '<td>'.$emergency['statusName'].'</td>';
			echo '<td>'.$emergency['buildingName'].'</td></tr>';
		}
		?>
</table>

<p> </p>
<p></p>
<h2><b>General Issues:</b></h2>
<p> </p>
<table border="1px" width="500px">
	<tr>
		<td class="tableHeader"><b>Number</b></td>
		<td class="tableHeader"><b>ISSUES</b></td>
		<td class="tableHeader"><b>USER ID</b></td>
		<td class="tableHeader"><b>STATUS</b></td>
		<td class="tableHeader"><b>Building</b></td>
	</tr>
		<?php
		foreach($generalReports as $emergency)
		{
			echo "<tr><td><a href='feedback.php?id=$id'>".$emergency['maintenanceReportID']."</a></td>";
			echo '<td>'.$emergency['issueName'].'</td>';
			echo '<td>'.$emergency['userID'].'</td>';
			echo '<td>'.$emergency['statusName'].'</td>';
			echo '<td>'.$emergency['buildingName'].'</td></tr>';
		}
		?>

	
</table>
</center>
	
    
    
    </div>

	<script>
function open_win() 
{
window.open("feedback.php","_blank" ,'width=400, height=400');
}
</script>
</body>
</html>