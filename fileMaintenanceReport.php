<?php
	require_once('db.php');

	$buildingID = $_REQUEST['building'];
	$suite = "'".$_REQUEST['suite']."'";
	$problem = $_REQUEST['problem'];
	$issue = "'".$_REQUEST['comment']."'";
	$userID = $_REQUEST['user'];
	$reportDate = "'".date("Y-m-d")."'";
	
	$pattern = "(emergency|before|gas|immediate|immidiately|leak|now|leave|left|urgent|within)i";

	preg_match($pattern, $commment, $matches, PREG_OFFSET_CAPTURE, 3);

	if(count($matches) > 0)
	{ 
		insert($link, "INSERT INTO maintenance_report (maintenanceID, maintenanceStatusID, unit, buildingID, description, userID, reportDate, issueID) VALUES( $problem, 1, $suite, $buildingID, $issue, $userID, $reportDate, 1);");
	}
	else
	{
		insert($link, "INSERT INTO maintenance_report (maintenanceID, maintenanceStatusID, unit, buildingID, description, userID, reportDate, issueID) VALUES( $problem, 1, $suite, $buildingID, $issue, $userID, $reportDate, 2);");
	}
?>