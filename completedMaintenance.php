
<?php
require_once('db.php');

	$ID = $_POST['id'];
	update($link, "UPDATE maintenance_report SET maintenanceStatusID =2 WHERE maintenancereportID = $ID;");
	header( 'Location:maintenance.php' ) ;

?>