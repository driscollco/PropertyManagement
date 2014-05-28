<?php
	require_once('db.php');

	$reportID = $_REQUEST['id'];
	update($link, "DELETE FROM maintenance_report WHERE maintenancereportID = $reportID");
?>