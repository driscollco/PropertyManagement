<?php
	require_once('db.php');

	$reportID = $_REQUEST['report'];
	$feedback = "'".$_REQUEST['feedback']."'";

	update($link, "UPDATE maintenance_report SET feedback = $feedback WHERE maintenancereportID = $reportID");

?>