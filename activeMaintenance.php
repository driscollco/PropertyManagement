
<?php
require_once('db.php');

	$ID = $_POST['id'];
	update($link, "UPDATE maintenance_report SET maintenanceStatusID =1 WHERE maintenancereportID = $ID;");
	header( 'Location:maintenance.php' ) ;

?>
