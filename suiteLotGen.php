<?php
	require_once('db.php');
	$building = $_REQUEST['building'];

	$result = getResultSet($link, 
		"SELECT U.suite
		FROM user_building UB
		LEFT JOIN building B ON B.buildingID = UB.buildingID
		LEFT JOIN users U ON UB.userID = U.userID
		WHERE B.name = '$building';");

	echo json_encode($result);
?>