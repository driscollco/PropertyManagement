<?php
	require_once('db.php');
	$building = $_REQUEST['building'];

	$result = getResultSet($link, 
		"SELECT PS.spotID
		FROM user_building UB
		LEFT JOIN building B ON B.buildingID = UB.buildingID
		LEFT JOIN parking_lot PL ON PL.buildingID = B.buildingID
		LEFT JOIN parking_spot PS ON PS.lotID = PL.lotID
		WHERE B.name = '$building';");

	echo json_encode($result);
?>