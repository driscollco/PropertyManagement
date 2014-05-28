<?php
	require_once('db.php');

	$buildingID = $_REQUEST['id'];

	$GLOBALS['availableUnits'] = getResultSet($link, "SELECT suite FROM building_suite WHERE userID IS NULL AND buildingID = $buildingID");
	$GLOBALS['availableSpots'] = getResultSet($link, 
			"SELECT US.spotID, US.lotID FROM user_spot US 
			LEFT JOIN parking_lot PL ON PL.lotID = US.lotID 
			WHERE US.userID IS NULL AND PL.buildingID = $buildingID");

	echo json_encode(array_merge($availableUnits, $availableSpots));
	// json_encode($availableUnits);



?>